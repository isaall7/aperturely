<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\TypeCategories;
use App\Models\Categories;

class PostController extends Controller
{
    public function index()
    {
        $posts = Posts::with(['user', 'photos', 'category'])
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
        $post = Posts::with(['user', 'photos', 'comments.user', 'category'])
            ->withCount(['likes', 'comments'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    public function kategori()
    {
        $kategori = TypeCategories::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function tipeFoto()
    {
        $tipeFoto = Categories::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $tipeFoto
        ]);
    }

    public function postByTipeFoto($id)
    {
        $posts = Posts::with(['user', 'photos', 'category'])
            ->withCount(['likes', 'comments'])
            ->where('category_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }
}
