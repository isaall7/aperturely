<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Photo;
use App\Models\Posts;
use App\Models\Tag;
use App\Models\TypeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostsController extends Controller
{
    public function download($id)
    {
    $photo = Photo::findOrFail($id);

    $path = storage_path('app/public/' . $photo->photo);

    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path);
    }

    public function create()
    {
        return view('user.postingan.create', [
            'categories'     => Categories::all(),
            'typeCategories' => TypeCategories::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'photos'           => 'required|array|min:1|max:10',
            'photos.*'         => 'image|mimes:jpeg,jpg,png,webp|max:15360',
            'caption'          => 'nullable|string|max:2000',
            'category_id'      => 'nullable|exists:categories,id',
            'type_category_id' => 'nullable|exists:type_categories,id',

            // AI score validation
            'ai_porn'   => 'nullable|numeric',
            'ai_hentai' => 'nullable|numeric',
            'ai_sexy'   => 'nullable|numeric',
        ]);

        $porn   = $request->ai_porn ?? 0;
        $hentai = $request->ai_hentai ?? 0;
        $sexy   = $request->ai_sexy ?? 0;

        $nsfwScore = $porn + $hentai + $sexy;

        $unsafe =
            $porn > 0.35 ||
            $hentai > 0.25 ||
            $sexy > 0.25 ||
            $nsfwScore > 0.50;

        DB::beginTransaction();

        try {

            $post = Posts::create([
                'user_id'          => Auth::id(),
                'caption'          => $request->caption,
                'category_id'      => $request->category_id,
                'type_category_id' => $request->type_category_id,
                'status'           => $unsafe ? 'rejected_ai' : 'active',
                'ai_reason'        => $unsafe ? 'NSFW detected by AI filter' : null,
            ]);

            // untuk membuat tag dari caption, misalnya #sunset, #nature, #portrait
            preg_match_all('/#(\w+)/', $request->caption ?? '', $matches);

            $tags = collect($matches[1])
                ->map(fn($tag) => strtolower($tag))
                ->unique();

            $tagIds = [];

            foreach ($tags as $tagName) {
                $slug = Str::slug($tagName);

                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tagName]
                );

                $tagIds[] = $tag->id;
            }

            $post->tags()->syncWithoutDetaching($tagIds);

            if ($unsafe) {
                DB::commit();

                return back()->with(
                    'error',
                    '❌ Postingan ditolak karena terdeteksi mengandung konten sensitif.'
                );
            }

            $manager = new ImageManager(new Driver());

            foreach ($request->file('photos') as $file) {

                $image = $manager->read($file->getPathname())
                    ->scaleDown(1920)
                    ->toJpeg(75);

                $filename = uniqid() . '.jpg';
                $path     = "posts/{$filename}";

                Storage::disk('public')->put($path, (string) $image);

                Photo::create([
                    'post_id' => $post->id,
                    'photo'   => $path,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('user.dashboard')
                ->with('success', 'Postingan berhasil diupload 🎉');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Store Post Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupload postingan.');

            // DB::rollBack();

            // dd($e->getMessage());
        }
    }

    public function searchTag(Request $request)
    {
        $q = $request->q;

            return Tag::where('name', 'like', "%{$q}%")
                ->withCount('posts')
                ->limit(10)
                ->get();
    }

    public function show(Posts $post)
    {
        $post->load(['photos', 'user', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function edit(Posts $postingan)
    {
        abort_if($postingan->user_id !== Auth::id(), 403);

        $postingan->load('tags', 'photos');

        return view('user.postingan.edit', [
            'post'           => $postingan,
            'categories'     => Categories::all(),
            'typeCategories' => TypeCategories::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption'          => 'nullable|string|max:2000',
            'category_id'      => 'nullable|exists:categories,id',
            'type_category_id' => 'nullable|exists:type_categories,id',
        ]);

        DB::beginTransaction();

        try {

            $post = Posts::findOrFail($id);

            // optional: pastikan hanya pemilik yang bisa edit
            if ($post->user_id !== Auth::id()) {
                abort(403);
            }

            // ✅ update data utama
            $post->update([
                'caption'          => $request->caption,
                'category_id'      => $request->category_id,
                'type_category_id' => $request->type_category_id,
            ]);

            // ==============================
            // 🔥 HANDLE TAG (UPDATE)
            // ==============================
            preg_match_all('/#(\w+)/', $request->caption ?? '', $matches);

            $tags = collect($matches[1])
                ->map(fn($tag) => strtolower($tag))
                ->unique();

            $tagIds = [];

            foreach ($tags as $tagName) {
                $slug = Str::slug($tagName);

                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tagName]
                );

                $tagIds[] = $tag->id;
            }

            // 🔥 penting: sync (bukan syncWithoutDetaching)
            $post->tags()->sync($tagIds);

            DB::commit();

            return redirect()
                ->route('user.dashboard')
                ->with('success', 'Postingan berhasil diupdate ✨');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Update Post Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate postingan.');
            // DB::rollBack();

            // dd($e->getMessage());
        }
    }

    public function destroy(Posts $postingan)
    {
        abort_if($postingan->user_id !== Auth::id(), 403);

        foreach ($postingan->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        $postingan->delete();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Postingan berhasil dihapus 🗑️');
    }
}
