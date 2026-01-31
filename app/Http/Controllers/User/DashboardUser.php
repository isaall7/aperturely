<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Posts;
use App\Models\Photo;
use App\Models\Comment; 
use App\Models\Likes_photo;
use App\Models\Categories;
use App\Models\TypeCategories;
use App\Models\Banned;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardUser extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function notifikasi()
    {
        $posts = Posts::with([
                'photos',
                'bans.admin',
            ])
            ->where('user_id', auth()->id())
            ->where('status', 'banned')
            ->whereHas('bans') // pastikan ada data ban
            ->latest()
            ->get();

        return view('user.riwayat.notifikasi', compact('posts'));
    }


    public function index(Request $request)
    {
        $search = $request->search;

        $cari = Posts::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('caption', 'like', "%{$search}%")
                ->orWhereHas('category', function ($qCat) use ($search) {
                    $qCat->where('name', 'like', "%{$search}%")
                        ->orWhereHas('typecategories', function ($qType) use ($search) {
                            $qType->where('name', 'like', "%{$search}%");
                        });
                })
                ->orWhereHas('user', function ($qUser) use ($search) {
                    $qUser->where('name', 'like', "%{$search}%");
                });
            });
        });


        $user = Auth::user();
        
        $posts = Posts::with([
            'photos',
            'user',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])
        ->where('status', 'active')
        ->withCount(['likes', 'comments']) // Hitung total likes & comments
        ->orderByRaw('(likes_count + comments_count * 2) DESC') // Prioritas engagement
        ->orderBy('created_at', 'desc') // Lalu urutkan dari terbaru
        ->paginate(25);
        
        return view('user.dashboard', compact('posts', 'user', 'cari', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
