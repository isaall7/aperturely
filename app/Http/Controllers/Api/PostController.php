<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Posts;
use App\Models\Comment;
use App\Models\Likes_photo;
use App\Models\Photo;
use App\Models\TypeCategories;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::with(['user', 'photos'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        return response()->json([
        'status' => 'success',
        'data' => $posts
    ]);
    }
    
    public function show($id)
    {
        $post = Posts::with(['user', 'photos', 'comments.user'])
            ->withCount(['likes', 'comments'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    public function kategori()
    {
        $kategori = TypeCategories::all(); // sesuaikan nama model kamu
        
        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }
}
