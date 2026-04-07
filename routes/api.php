<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\FollowersController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // (opsional) followers bisa dimasukin sini kalau butuh login
    Route::get('/followers', [FollowersController::class, 'followers']);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']); 
Route::get('/kategori', [PostController::class, 'kategori']); 
Route::get('/tipe-foto', [PostController::class, 'tipeFoto']);
Route::get('/tipe-foto/{id}/posts', [PostController::class, 'postByTipeFoto']);
