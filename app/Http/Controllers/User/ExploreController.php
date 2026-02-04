<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Comment;
use App\Models\Likes_photo;
use App\Models\Photo;
use App\Models\TypeCategories;
use App\Models\Categories;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    public function index()
    {
        // Ambil posts dengan relasi lengkap
        $posts = Posts::with([
            'user',
            'photos',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount(['likes', 'comments'])
        ->orderByRaw('(likes_count + comments_count * 2) DESC')
        ->latest()
        ->paginate(12);

        // Ambil semua kategori untuk filter
        $categories = Categories::all();

        return view('user.explore.index', [
            'posts'         => $posts,
            'categories'    => $categories,
        ]);
    }

    public function filterByCategory($categoryId)
    {
        // Filter posts berdasarkan kategori
        $posts = Posts::whereHas('photos', function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->with([
            'user',
            'photos',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount(['likes', 'comments'])
        ->latest()
        ->paginate(12);

        $categories       = Categories::all();
        $selectedCategory = Categories::find($categoryId);

        return view('user.explore.index', [
            'posts'            => $posts,
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $posts = Posts::when($query, function ($q, $query) {
            $q->where(function ($sub) use ($query) {
                $sub->where('caption', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($qCat) use ($query) {
                        $qCat->where('name', 'like', "%{$query}%")
                            ->orWhereHas('typecategories', function ($qType) use ($query) {
                                $qType->where('name', 'like', "%{$query}%");
                            });
                    })
                    ->orWhereHas('user', function ($qUser) use ($query) {
                        $qUser->where('name', 'like', "%{$query}%");
                    });
            });
        })
        ->with([
            'user',
            'photos',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount(['likes', 'comments'])
        ->latest()
        ->paginate(12);

        $categories = Categories::all();

        return view('user.explore.index', [
            'posts'         => $posts,
            'categories'    => $categories,
            'searchQuery'   => $query,
        ]);
    }

    public function trending()
    {
        // Ambil 10 posts terpopuler berdasarkan likes dan comments
        $trendingPosts = Posts::with([
            'user',
            'photos',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount(['likes', 'comments'])
        ->orderByRaw('(likes_count + comments_count * 2) DESC')
        ->paginate(10);

        return view('user.explore.trending', [
            'trendingPosts' => $trendingPosts,
        ]);
    }
}