<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Comment;
use App\Models\Likes_photo;
use App\Models\Photo;
use App\Models\TypeCategories;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    //digunakan untuk menampilkan halaman explore dengan semua post yang sudah di filter
    // berdasarkan kategori dan tipe foto, dan juga menampilkan semua kategori untuk filter
    public function index()
    {
        // Ambil posts dengan relasi lengkap
        $posts = Posts::with([
            'user',
            'photos',
            'likes',
            'comments' => function ($q) {
                $q->where('status', 'active');
            },
            'comments.user',
            'comments.replies' => function ($q) {
                $q->where('status', 'active');
            },
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount([
            'likes',
            'comments' => function ($q) {
                $q->where('status', 'active');
            }
        ])

        ->orderByRaw('(likes_count + comments_count * 2) DESC')
        ->latest()
        ->paginate(12);

        // Ambil semua kategori untuk filter
        $categories = Categories::all();

        return view('user.explore.index', [
            'posts'      => $posts,
            'users'      => collect(),
            'categories' => $categories,
            'activeView' => 'posts',
        ]);
    }

    //digunakan untuk menampilkan halaman detail post dengan related post yang sudah di filter berdasarkan tipe kategori
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
            'users'            => collect(),
            'categories'       => $categories,
            'selectedCategory' => $selectedCategory,
            'activeView'       => 'posts',
        ]);
    }

    //digunakan untuk menampilkan halaman detail post dengan related post yang sudah di filter berdasarkan tipe kategori
    public function search(Request $request)
    {
        $query = $request->input('q');
        $view  = $request->input('view', 'posts');

        $categories = Categories::all();

        if ($view === 'accounts') {
            $users = User::with('profile')
                ->where('role', '!=', 'admin')
                ->withCount([
                    'posts' => function ($q) {
                        $q->where('status', 'active');
                    },
                    'followers',
                    'following',
                ])
                ->when($query, function ($qUser, $query) {
                    $qUser->where(function ($sub) use ($query) {
                        $sub->where('name', 'like', "%{$query}%")
                            ->orWhere('username', 'like', "%{$query}%");
                    });
                })
                ->latest()
                ->paginate(12)
                ->withQueryString();

            return view('user.explore.index', [
                'posts'         => collect(),
                'users'         => $users,
                'categories'    => $categories,
                'searchQuery'   => $query,
                'activeView'    => 'accounts',
            ]);
        }

        $posts = Posts::when($query, function ($q, $query) {
            $q->where(function ($sub) use ($query) {
                $sub->where('caption', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($qCat) use ($query) {
                        $qCat->where('name', 'like', "%{$query}%")
                            ->orWhereHas('typecategories', function ($qType) use ($query) {
                                $qType->where('name', 'like', "%{$query}%");
                            });
                    })
                    ->orWhereHas('tags', function ($qTag) use ($query) {
                        $qTag->where('name', 'like', "%{$query}%");
                    });
            });
        })
        ->with([
            'user',
            'photos',
            'likes',
            'tags',
            'comments.user',
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount(['likes', 'comments'])
        ->latest()
        ->paginate(12)
        ->withQueryString();

        return view('user.explore.index', [
            'posts'         => $posts,
            'users'         => collect(),
            'categories'    => $categories,
            'searchQuery'   => $query,
            'activeView'    => 'posts',
        ]);
    }

    //digunakan untuk menampilkan postingan yang sedang trending berdasarkan jumlah likes dan comments
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
