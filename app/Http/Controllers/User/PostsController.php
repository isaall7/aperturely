<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Photo;
use App\Models\User;
use App\Models\Comment;
use App\Models\Likes_photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user) {
            $totalPost = Posts::where('user_id', $user->id)->count();
            $totalLike = Likes_photo::whereHas('post', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();
            
            $posts = Posts::with([
                'photos',
                'user',
                'likes',
                'comments.user',
                'comments.replies.user'
            ])
            ->where('status', 'active')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);
        } else {
            $totalPost = 0;
            $totalLike = 0;
            $posts = collect(); // Collection kosong
        }
            
        return view('user.profile', compact('user', 'posts', 'totalPost', 'totalLike'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.postingan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'photos' => 'required|array|min:1|max:10',  // ✅ photos
            'photos.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:5120',
            'caption' => 'nullable|string|max:2000',
            'camera_type' => 'required|in:DSLR,Mirrorless,Phone',
            'genre' => 'required|in:Landscape,Portrait,Street,Macro',
        ], [
            'photos.required' => 'Minimal upload 1 foto',
            'photos.max' => 'Maksimal upload 10 foto',
            'photos.*.image' => 'File harus berupa gambar',
            'photos.*.mimes' => 'Format foto harus jpeg, jpg, png, atau gif',
            'photos.*.max' => 'Ukuran foto maksimal 5MB',
            'camera_type.required' => 'Tipe kamera wajib dipilih',
            'camera_type.in' => 'Tipe kamera tidak valid',
            'genre.required' => 'Genre foto wajib dipilih',
            'genre.in' => 'Genre foto tidak valid',
        ]);

        try {
            // Buat Post
            $post = Posts::create([
                'user_id' => Auth::id(),
                'caption' => $request->caption, 
                'camera_type' => $request->camera_type,
                'genre' => $request->genre,
                'status' => 'active',
            ]);

            // Upload dan simpan photos
            if ($request->hasFile('photos')) {  // ✅ Ubah jadi 'photos'
                foreach ($request->file('photos') as $photoFile) {  // ✅ Ubah jadi 'photos'
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $photoFile->getClientOriginalExtension();
                    
                    // Store ke public/storage/posts
                    $path = $photoFile->storeAs('posts', $filename, 'public');

                    // Simpan ke database
                    Photo::create([
                        'post_id' => $post->id,
                        'photo' => $path,  // ✅ Ini nama column di database
                    ]);
                }
            }

            return redirect()
                ->route('user.profile')
                ->with('success', 'Postingan berhasil diupload! 🎉');

        } catch (\Exception $e) {
            // Jika error, hapus post yang sudah dibuat
            if (isset($post)) {
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
    public function edit(Posts $post)
    {
        // Cek authorization
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {
        // Cek authorization
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'caption' => 'nullable|string|max:2000',
            'camera_type' => 'required|in:DSLR,Mirrorless,Phone',
            'genre' => 'required|in:Landscape,Portrait,Street,Macro',
        ]);

        $post->update($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Postingan berhasil diupdate! ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $post)
    {
        // Cek authorization
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Hapus semua foto dari storage
            foreach ($post->photo as $photo) {
                Storage::disk('public')->delete($photo->photo);
            }

            // Hapus post (photo akan terhapus otomatis karena cascade)
            $post->delete();

            return redirect()
                ->route('posts.index')
                ->with('success', 'Postingan berhasil dihapus! 🗑️');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus postingan: ' . $e->getMessage());
        }
    }
}