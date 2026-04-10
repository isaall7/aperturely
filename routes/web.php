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
use App\Http\Controllers\User\LikesPhotoController;
use App\Http\Controllers\User\ExploreController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\FirebaseAuthController;

Route::get('/auth/google-redirect', [App\Http\Controllers\Auth\GoogleController::class, 'google_redirect']);
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'google_callback']);

Auth::routes();

Route::prefix('dashboard')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');

    Route::get('/users', [DashboardAdmin::class, 'userAccount'])->name('user.index');
    Route::delete('/users/{id}', [DashboardAdmin::class, 'destroyUser'])->name('user.destroy');

    Route::get('/post', [DashboardAdmin::class, 'userPosts'])->name('user.posts');
    Route::patch('/post/{post}/ban', [DashboardAdmin::class, 'banPost'])->name('post.ban');
    Route::patch('/post/{id}/ban-comment', [DashboardAdmin::class, 'banComment'])->name('post.bancomment');

    Route::resource('/category', CategoryController::class);
    Route::resource('/typecategory', TypeCategoryController::class);

    Route::get('/reports/posts', [DashboardAdmin::class, 'reportPosts'])->name('report.post');
    Route::get('/reports/comments', [DashboardAdmin::class, 'reportComments'])->name('report.comment');
});

Route::prefix('/')->name('user.')->group(function () {
    Route::get('/', [DashboardUser::class, 'index'])->name('dashboard');
    Route::get('/dashboard/kategori/{slug}', [DashboardUser::class, 'index'])->name('dashboard.kategori');
    Route::get('/post/{id}', [DashboardUser::class, 'show'])->name('post-detail');

    Route::resource('/postingan', PostsController::class);
    Route::get('/postingan/{post}/download', [PostsController::class, 'download'])->name('postingan.download');
    Route::get('/tags/search', [PostsController::class, 'searchTag']);

    Route::post('/report/post/{post}', [ReportController::class, 'reportPost'])->name('report.post');
    Route::post('/report/comment/{comment}', [ReportController::class, 'reportComment'])->name('report.comment');

    Route::resource('/avatar', ProfileController::class)->middleware('auth')->except(['show']);
    Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth')->name('profile');
    Route::get('/users/{name}', [ProfileController::class, 'show'])->name('profile.username');

    Route::get('/notifikasi', [DashboardUser::class, 'BanPostUser'])->name('riwayat.postingan');
    Route::get('/riwayat-komentar', [DashboardUser::class, 'BanAndShowComment'])->name('riwayat.komentar');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/post-like/{post}', [LikesPhotoController::class, 'likePhoto'])->name('post.like');

    Route::post('/follow/{userId}', [ProfileController::class, 'follow'])->middleware('auth')->name('profile.follow');
    Route::get('riwayat-menyukai', [DashboardUser::class, 'showLikesPhoto'])->name('riwayat.like');

    Route::get('/explore', [ExploreController::class, 'index'])->name('explore.halaman');
    Route::get('/explore/category/{id}', [ExploreController::class, 'filterByCategory'])->name('explore.category');
    Route::get('/explore/search', [ExploreController::class, 'search'])->name('explore.search');
    Route::get('/trending', [ExploreController::class, 'trending'])->name('explore.trending');

    Route::get('riwayat-diikuti', [DashboardUser::class, 'showFollowers'])->name('riwayat.diikuti');
    Route::get('riwayat-mengikuti', [DashboardUser::class, 'showFollowing'])->name('riwayat.mengikuti');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('auth');
    Route::post('/firebase/custom-token', [FirebaseAuthController::class, 'customToken'])->name('firebase.custom-token')->middleware('auth');
});
