<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Posts;
use App\Models\Likes_photo;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // ini buat fitur followers dan following
    public function follow($userId)
    {
        $user = User::findOrFail($userId); 
        
        if (Auth::id() == $userId) {
            return response()->json(['error' => 'Tidak bisa follow diri sendiri'], 400);
        }

        $follow = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $userId)
            ->first();

        if ($follow) {
            $follow->delete();

            return response()->json([
                'following' => false
            ]);
        }

        Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $userId,
        ]);

        return response()->json([
            'following' => true
        ]);
    }

    // masuk ke dalam profile sendiri
    public function index()
    {
        $user = Auth::user(); // user login

        return $this->profileData($user);
    }

    // masuk ke dalam profile pengguna lain
    public function show($username)
    {
        if (Auth::check() && Auth::user()->name === $username) {
        return redirect()->route('user.profile');
        }

        $user = User::where('name', $username)->firstOrFail();

        return $this->profileData($user);
    }

    // data profile
    private function profileData($user)
    {
        $totalPost = Posts::where('user_id', $user->id)->where('status', 'active')->count();
        
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

        return view('user.profile', compact(
            'user',
            'posts',
            'totalPost',
            'totalLike'
        ));
    }

    public function create()
    {
        return view('user.avatar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'bio' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {

            // hapus avatar lama kalau ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');

            $user->update([
                'avatar' => $path,
            ]);
        }

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['bio' => $request->bio]
        );

        return redirect()
            ->route('user.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }


    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        
        return view('user.avatar.edit', [
            'user' => $user,
            'profile' => $user->profile
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        // 🔁 UPDATE AVATAR
        if ($request->hasFile('avatar')) {

            // hapus avatar lama kalau ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');

            // update ke table users
            $user->update([
                'avatar' => $path
            ]);
        }

        // 🔁 UPDATE / CREATE PROFILE
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['bio' => $request->bio]
        );

        return redirect()
            ->route('user.profile')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

    // public function deleteAvatar()
    // {
    //     $user = auth()->user();

    //     if ($user->avatar) {
    //         Storage::disk('public')->delete($user->avatar);
    //         $user->update(['avatar' => null]);
    //     }

    //     return back()->with('success', 'Avatar dihapus.');
    // }

}
