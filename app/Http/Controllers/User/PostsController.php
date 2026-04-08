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
use Intervention\Image\Typography\FontFactory;

class PostsController extends Controller
{
    //ini untuk mengunduh foto dengan watermark, bisa pilih slide mana yang ingin diunduh 
    //jika postingan memiliki lebih dari 1 foto
    public function download(Request $request, Posts $post)
    {
        $post->loadMissing(['photos', 'user']);

        if ($post->photos->isEmpty()) {
            abort(404);
        }

        if ($post->photos->count() === 1) {
            return $this->downloadSinglePhoto($post, $post->photos->first());
        }

        $photo = $post->photos->firstWhere('id', $request->integer('photo'));

        if (!$photo) {
            return back()->with('error', 'Pilih slide foto yang ingin diunduh.');
        }

        return $this->downloadSinglePhoto($post, $photo);
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
    private function downloadSinglePhoto(Posts $post, Photo $photo)
    {
        $tempPath = $this->createWatermarkedPhoto($post, $photo);

        return response()
            ->download($tempPath, $this->buildPhotoFilename($post, $photo))
            ->deleteFileAfterSend(true);
    }

    //ini untuk membuat logo watermark dan username saat foto diunduh
    private function createWatermarkedPhoto(Posts $post, Photo $photo): string
    {
        $sourcePath = storage_path('app/public/' . $photo->photo);

        if (!is_file($sourcePath)) {
            abort(404);
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($sourcePath);
        $padding = max(18, (int) round(min($image->width(), $image->height()) * 0.03));
        $logoHeight = 0;

        $logoPath = public_path('ui/images/logos/aperturely_logo.png');
        if (is_file($logoPath)) {
            $logo = $manager->read($logoPath);
            $logo->scaleDown(width: max(70, min(160, (int) round($image->width() * 0.12))));
            $logoHeight = $logo->height();
            $image->place($logo, 'bottom-right', $padding, $padding);
        }

        $fontSize = max(18, min(44, (int) round($image->width() * 0.022)));
        $textY = max($padding + $fontSize, $image->height() - $padding - $logoHeight - 10);

        $image->text('@' . ($post->user->username ?? $post->user->name ?? 'aperturely'), $image->width() - $padding, $textY, function (FontFactory $font) use ($fontSize) {
            $font->filename($this->resolveWatermarkFont());
            $font->size($fontSize);
            $font->color('#ffffff');
            $font->align('right');
            $font->valign('bottom');
            $font->stroke('#111111', max(1, (int) round($fontSize / 16)));
        });

        $tempPath = $this->ensureTempDirectory() . DIRECTORY_SEPARATOR . Str::uuid() . '.jpg';
        file_put_contents($tempPath, (string) $image->toJpeg(90));

        return $tempPath;
    }

    //ini untuk memastikan direktori sementara untuk menyimpan foto yang sudah diberi watermark, sebelum diunduh
    private function ensureTempDirectory(): string
    {
        $directory = storage_path('app/temp-downloads');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        return $directory;
    }

    //ini untuk membangun nama file saat diunduh, misalnya: aperturely-johndoe-post-123-slide-1.jpg
    private function buildPhotoFilename(Posts $post, Photo $photo): string
    {
        $index = $post->photos->search(fn ($item) => (int) $item->id === (int) $photo->id);
        $slideNumber = $index === false ? 1 : $index + 1;

        return 'aperturely-' . Str::slug($post->user->username ?? $post->user->name ?? 'user') . '-post-' . $post->id . '-slide-' . $slideNumber . '.jpg';
    }

    //ini untuk mencari font yang tersedia untuk watermark, dengan beberapa kandidat umum
    private function resolveWatermarkFont(): string
    {
        $candidates = [
            public_path('ui/css/icons/tabler-icons/fonts/tabler-icons.ttf'),
            'C:\\Windows\\Fonts\\arial.ttf',
            'C:\\Windows\\Fonts\\segoeui.ttf',
        ];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        abort(500, 'Font watermark tidak ditemukan.');
    }
}
