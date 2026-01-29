<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Posts;
use App\Models\Photo;
use App\Models\Comment; 
use App\Models\Likes_photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardUser extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
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
        ->paginate(12);
        
        return view('user.dashboard', compact('posts', 'user'));
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
