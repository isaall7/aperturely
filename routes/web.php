<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardAdmin;

use App\Http\Controllers\User\DashboardUser;
use App\Http\Controllers\User\PostsController;  
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReportController;

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

    Route::resource('/postingan', PostsController::class);

    Route::post('/report/post/{post}', [ReportController::class, 'reportPost'])->name('report.post');
    Route::post('/report/comment/{comment}', [ReportController::class, 'reportComment'])->name('report.comment');

    Route::resource('/avatar', ProfileController::class);
    // profile sendiri
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    // profile user lain
    Route::get('/users/{name}', [ProfileController::class, 'show'])->name('profile.username');

});
