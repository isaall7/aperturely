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
        // 1️⃣ Ambil semua post_id yang disukai user, unik
        $likedPostIds = Likes_photo::where('user_id', auth()->id())
            ->pluck('post_id')
            ->unique();

        // 2️⃣ Ambil data post beserta satu foto utama dan user
        $likedPosts = Posts::with(['mainPhoto', 'user'])
            ->whereIn('id', $likedPostIds)
            ->latest()
            ->get();

        // 3️⃣ Ambil total statistik
        $totals = $this->totalSemua();

        // 4️⃣ Kirim ke view
        return view('user.riwayat.like', [
            'likedPosts'     => $likedPosts,
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

    //ini buat nampilin detail postingan di halaman detail postingan user
    public function show($id)
    {
        $post = Posts::with([
            'photos',
            'user',
            'likes',
            'comments' => function ($q) {
                $q->whereNull('reply_id')->with(['user', 'replies.user'])->latest();
            },
            'tipeKategori',
        ])
        ->where('status', 'active')
        ->findOrFail($id);

        // Ambil 10 postingan dari kategori yang sama (acak), kecuali postingan ini
        $relatedPosts = collect();

        if ($post->tipeKategori) {
            $relatedPosts = Posts::with(['photos', 'user', 'likes', 'comments'])
                ->where('status', 'active')
                ->where('id', '!=', $post->id)
                ->whereHas('tipeKategori', function ($q) use ($post) {
                    $q->where('id', $post->tipeKategori->id);
                })
                ->withCount(['likes', 'comments'])
                ->inRandomOrder()
                ->limit(10)
                ->get();
        }

        return view('user.post-detail', compact('post', 'relatedPosts'));
    }

    //ini buat nampilin semua postingan di halaman dashboard user
    public function index(Request $request, $slug = null)
    {
        $search = $request->search;

        $tipeKategori = TypeCategories::all();

        $user = Auth::user();

        $posts = Posts::with([
            'photos',
            'user',
            'likes',
            'comments.user',
            'comments.replies.user',
            'tipeKategori'
        ])
        ->where('status', 'active')

        ->when($slug, function ($query) use ($slug) {
            $query->whereHas('tipeKategori', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        })

        ->withCount(['likes', 'comments'])
        ->orderByRaw('(likes_count + comments_count * 2) DESC')
        ->inRandomOrder()
        ->get();

        return view('user.dashboard', compact('posts', 'user', 'search', 'tipeKategori', 'slug'));
    }

}
