<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardAdmin;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TypeCategoryController;

use App\Http\Controllers\User\DashboardUser;
use App\Http\Controllers\User\PostsController;  
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\CommentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/auth/google-redirect', [App\Http\Controllers\Auth\GoogleController::class, 'google_redirect']);
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'google_callback']);

Auth::routes();

Route::prefix('dashboard')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');

    Route::get('/users', [DashboardAdmin::class, 'userAccount'])->name('user.index');
    Route::delete('/users/{id}', [DashboardAdmin::class, 'destroyUser'])->name('user.destroy');

    Route::get('/post', [DashboardAdmin::class, 'userPosts'])->name('user.posts');
    Route::patch('/post/{post}/ban', [DashboardAdmin::class, 'banPost'])->name('post.ban');
    Route::patch('/post/{comment}/ban', [DashboardAdmin::class, 'banComment'])->name('post.bancomment');

    Route::resource('/category', CategoryController::class);
    Route::resource('/typecategory', TypeCategoryController::class);

    Route::get('/reports/posts', [DashboardAdmin::class, 'reportPosts'])->name('report.post');
    Route::get('/reports/comments', [DashboardAdmin::class, 'reportComments'])->name('report.comment');
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

    Route::get('/notifikasi', [DashboardUser::class, 'notifikasi'])->name('riwayat.notifikasi');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});
