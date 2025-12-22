<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
        $googleUser = Socialite::driver('google')
        ->stateless() // Nonaktifkan state checking
        ->user();

        $user = User::whereEmail($googleUser->email)->first();
        if (!$user){
            // Jika user belum ada, buat user baru
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->getAvatar(),
                'google_id' => $googleUser->id,
                'password' => bcrypt(str()->random(16)), // Buat password random
            ]);
        }
        Auth::login($user, true); // Login user dan ingat sesinya
        return redirect('/');
        
    }
}