<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Photo;
use App\Models\Posts;
use App\Models\TypeCategories;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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

        $post = Posts::create([
            'user_id'          => Auth::id(),
            'caption'          => $request->caption,
            'category_id'      => $request->category_id,
            'type_category_id' => $request->type_category_id,
            'status'           => 'active',
        ]);

        foreach ($request->file('photos') as $file) {

            // 🔧 Compress image
            $manager = new ImageManager(new Driver());
            $image   = $manager
                ->read($file->getPathname())
                ->scaleDown(1920)
                ->toJpeg(75);

            $filename = uniqid() . '.jpg';
            $path     = "posts/{$filename}";

            Storage::disk('public')->put($path, (string) $image);

            // 🔍 AI SCAN
            $scan = $this->scanWithGoogleVision($path);

            Log::info('Vision Scan Result', $scan);

            /**
             * ❗ STRICT TAPI WARAS
             * - Reject HANYA jika VERY_LIKELY
             * - Design / ilustrasi aman
             */
            $isRejected =
                $scan['adult'] === 5 ||
                $scan['violence'] === 5 ||
                $scan['racy'] === 5;

            if ($isRejected) {
                Storage::disk('public')->delete($path);

                $post->update([
                    'status'    => 'rejected_ai',
                    'ai_reason' => 'Konten terdeteksi sensitif oleh AI',
                ]);

                return back()
                    ->withInput()
                    ->with('error', 'Postingan ditolak oleh sistem AI.');
            }

            Photo::create([
                'post_id' => $post->id,
                'photo'   => $path,
            ]);
        }

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Postingan berhasil diupload 🎉');
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

    /**
     * 🔐 Google Vision AI Scan (STRICT MODE)
     */
     private function scanWithGoogleVision(string $imagePath): array
    {
        try {
            $client = new ImageAnnotatorClient();

            $imageContent = file_get_contents(
                storage_path("app/public/{$imagePath}")
            );

            $image = new Image();
            $image->setContent($imageContent);

            $feature = new Feature();
            $feature->setType(Type::SAFE_SEARCH_DETECTION);

            $response = $client->annotateImage($image, [$feature]);
            $safe     = $response->getSafeSearchAnnotation();

            $client->close();

            return [
                'adult'    => $safe->getAdult(),
                'violence' => $safe->getViolence(),
                'racy'     => $safe->getRacy(),
            ];

        } catch (\Throwable $e) {

            Log::error('Google Vision Error', [
                'message' => $e->getMessage(),
            ]);

            /**
             * ❗ PENTING
             * AI ERROR ≠ USER SALAH
             * JANGAN AUTO REJECT
             */
            return [
                'adult'    => 0,
                'violence' => 0,
                'racy'     => 0,
            ];
        }
    }
}
