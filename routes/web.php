<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdmin;
use App\Http\Controllers\User\DashboardUser;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/auth/google-redirect', [App\Http\Controllers\Auth\GoogleController::class, 'google_redirect']);
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'google_callback']);

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');
});

Route::prefix('/')->name('user.')->group(function () {
    Route::get('/', [DashboardUser::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardUser::class, 'profile'])->name('profile');
});
