<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Photo;
use App\Models\Posts;
use App\Models\TypeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostsController extends Controller
{
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
        ]);

        DB::beginTransaction();
        try {
            $post = Posts::create([
                'user_id'          => Auth::id(),
                'caption'          => $request->caption,
                'category_id'      => $request->category_id,
                'type_category_id' => $request->type_category_id,
                'status'           => 'active',
            ]);

            $manager = new ImageManager(new Driver());

            foreach ($request->file('photos') as $file) {

                // Compress & resize
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
        }
    }

    public function show(Posts $post)
    {
        $post->load(['photos', 'user', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function edit(Posts $postingan)
    {
        abort_if($postingan->user_id !== Auth::id(), 403);
        return view('posts.edit', ['post' => $postingan]);
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
