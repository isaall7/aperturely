<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // untuk profile ada di postscontroller bagian index
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('avatar')) {

            if (auth()->user()->avatar) {
                Storage::disk('public')->delete(auth()->user()->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');

            auth()->user()->update(['avatar' => $path]);
        }

        Profile::updateOrCreate(
            ['user_id' => auth()->id()],
            ['bio' => $request->bio]
        );

        return redirect()->route('user.profile')->with('success', 'Profile Berhasil Dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

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
