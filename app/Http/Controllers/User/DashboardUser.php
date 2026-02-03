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
use App\Models\Follow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardUser extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // ini buat nampilin user yang mengikuti di halaman riwayat diikuti user
    public function showFollowers()
    {
        $followedUsers = Follow::with('follower')
            ->where('followed_id', auth()->id())
            ->latest()
            ->get();

        $totals = $this->totalSemua();

        return view('user.riwayat.diikuti', [
            'followedUsers'  => $followedUsers,
            'totalPosts'     => $totals['posts'],
            'totalComments'  => $totals['comments'],
            'totalLikes'     => $totals['likes'],
            'totalFollowing' => $totals['following'],
            'totalFollowers' => $totals['followers'],
        ]);
    }

    // ini buat nampilin user yang diikuti di halaman riwayat diikuti user
    public function showFollowing()
    {
        $followingUsers = Follow::with('followed')
            ->where('follower_id', auth()->id())
            ->latest()
            ->get();

        $totals = $this->totalSemua();

        return view('user.riwayat.mengikuti', [
            'followingUsers' => $followingUsers,
            'totalPosts'     => $totals['posts'],
            'totalComments'  => $totals['comments'],
            'totalLikes'     => $totals['likes'],
            'totalFollowing' => $totals['following'],
            'totalFollowers' => $totals['followers'],
        ]);
    }

    // ini buat nampilin foto yang di like di halaman riwayat likes photo user
    public function showLikesPhoto()
    {

        $likesPhotos = Likes_photo::with(['photo', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $totals = $this->totalSemua();

        return view('user.riwayat.like',  [
            'likesPhotos'    => $likesPhotos,
            'totalPosts'     => $totals['posts'],
            'totalComments'  => $totals['comments'],
            'totalLikes'     => $totals['likes'],
            'totalFollowing' => $totals['following'],
            'totalFollowers' => $totals['followers'],
        ]);
    }

    // ini buat nampilin komentar yang di ban sama yang aktif dihalaman riwayat komentar user
    public function BanAndShowComment()
    {
        $activeComments = Comment::with([
                'post',
                'user',
                'parent' // untuk reply
            ])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->get();

        // Ambil semua komentar yang di-ban milik user yang sedang login
        $bannedComments = Comment::with([
                'post',
                'user',
                'parent', // untuk reply
                'bans.admin' // relasi ke tabel banneds
            ])
            ->where('user_id', auth()->id())
            ->where('status', 'banned')
            ->whereHas('bans') // pastikan ada data ban
            ->latest()
            ->get();

        // Hitung total untuk badge di sidebar
        $totalComments = $activeComments->count() + $bannedComments->count();
        
        $totals = $this->totalSemua();
        // Hitung total posts yang di-ban untuk badge notifikasi
        $totalPosts = Posts::where('user_id', auth()->id())
            ->where('status', 'banned')
            ->whereHas('bans')
            ->count();

        return view('user.riwayat.komentar', [
            'activeComments'  => $activeComments,
            'bannedComments'  => $bannedComments,
            'totalComments'   => $totalComments,
            'totalPosts'      => $totalPosts,
            'totalLikes'      => $totals['likes'],
            'totalFollowing'  => $totals['following'],
            'totalFollowers'  => $totals['followers'],
        ]);
    }

    // ini buat nampilin postingan yang di ban di halaman notifikasi user
    public function BanPostUser()
    {
        $posts = Posts::with(['photos', 'bans.admin'])
            ->where('user_id', auth()->id())
            ->where('status', 'banned')
            ->whereHas('bans')
            ->latest()
            ->get();

        $totals = $this->totalSemua();

        return view('user.riwayat.notifikasi', [
            'posts'          => $posts,
            'totalPosts'     => $totals['posts'],
            'totalComments'  => $totals['comments'],
            'totalLikes'     => $totals['likes'],
            'totalFollowing' => $totals['following'],
            'totalFollowers' => $totals['followers'],
        ]);
    }


    private function totalSemua($total = 0)
    {
        $userId = auth()->id();

        // Total komentar aktif
        $totalComments = Comment::where('user_id', $userId)
            ->where('status', 'active',)
            ->count();

        // Total post yang dibanned
        $totalPosts = Posts::where('user_id', $userId)
            ->where('status', 'banned')
            ->whereHas('bans')
            ->count();

        // Total like
        $totalLikes = Likes_photo::where('user_id', $userId)
            ->count();

        $totalFollowing = auth()->check()
            ? auth()->user()->following()->count()
            : 0;

        $totalFollowers = auth()->check()
            ? auth()->user()->followers()->count()
            : 0;

        return [
        'comments'   => $totalComments,
        'posts'      => $totalPosts,
        'likes'      => $totalLikes,
        'following'  => $totalFollowing,
        'followers'  => $totalFollowers,
        'total'      => $totalComments + $totalPosts + $totalLikes + $totalFollowing + $totalFollowers
    ];
    }

    // ini buat nampilin dashboard user beserta postingan aktif
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
        ->inRandomOrder() // Acak urutan postingan
        ->get();
        
        return view('user.dashboard', compact('posts', 'user', 'cari', 'search'));
    }

}
