<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Photo;
use App\Models\User;
use App\Models\Comment;
use App\Models\Likes_photo;
use App\Models\Categories;
use App\Models\TypeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        $typeCategories = TypeCategories::all();
        return view('user.postingan.create', compact('categories', 'typeCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
          // 1️⃣ VALIDASI
        $validated = $request->validate([
            'photos' => 'required|array|min:1|max:10',
            'photos.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:15360',
            'caption' => 'nullable|string|max:2000',
            'category_id' => 'nullable|exists:categories,id',
            'type_category_id' => 'nullable|exists:type_categories,id',
        ], [
            'photos.required' => 'Minimal upload 1 foto',
            'photos.max' => 'Maksimal upload 10 foto',
            'photos.*.image' => 'File harus berupa gambar',
            'photos.*.mimes' => 'Format foto harus jpeg, jpg, png, atau gif',
            'photos.*.max' => 'Ukuran foto maksimal 5MB',
        ]);

        try {
            // 2️⃣ BUAT POST
            $post = Posts::create([
                'user_id' => Auth::id(),
                'caption' => $request->caption,
                'category_id' => $request->category_id,
                'type_category_id' => $request->type_category_id,
                'status' => 'active',
            ]);

            // 3️⃣ UPLOAD + COMPRESS FOTO
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photoFile) {

                $manager = new ImageManager(new Driver());

                $image = $manager
                    ->read($photoFile->getPathname())
                    ->scaleDown(1920)
                    ->toJpeg(70);  // Kompresi ke JPEG dengan kualitas 70%


                $filename = uniqid() . '.jpg';
                $path = 'posts/' . $filename;

                Storage::disk('public')->put($path, (string) $image);

                    // 🔹 simpan ke database
                    Photo::create([
                        'post_id' => $post->id,
                        'photo' => $path,
                    ]);
                }
            }

            return redirect()
                ->route('user.dashboard')
                ->with('success', 'Postingan berhasil diupload & dikompres! 🎉');

        } catch (\Exception $e) {

            // 4️⃣ ROLLBACK JIKA ERROR
            if (isset($post)) {
                foreach ($post->photos as $photo) {
                    Storage::disk('public')->delete($photo->photo);
                }
                $post->delete();
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal upload postingan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $post)
    {
        $post->load('photo', 'user', 'comments.user');
        
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $postingan)
    {
        // Cek authorization
        if ($postingan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $postingan)
    {
        // Cek authorization
        if ($postingan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'caption' => 'nullable|string|max:2000',
            'camera_type' => 'required|in:DSLR,Mirrorless,Phone',
            'genre' => 'required|in:Landscape,Portrait,Street,Macro',
        ]);

        $postingan->update($validated);

        return redirect()
            ->route('posts.show', $postingan)
            ->with('success', 'Postingan berhasil diupdate! ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $postingan)
    {
        // Cek authorization
        if ((int) $postingan->user_id !== (int) auth()->id()) {
            abort(403);
        }

        foreach ($postingan->photos as $photo) {
            Storage::disk('public')->delete($photo->photo);
        }

        $postingan->delete();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Postingan berhasil dihapus! 🗑️');
    }
}