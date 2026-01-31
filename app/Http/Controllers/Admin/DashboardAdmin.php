<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use App\Models\Banned;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function userPosts(Request $request)
    {
        $totalPosts = Posts::count();

        $search = $request->search;
        $userId = $request->user_id;

        $posts = Posts::with(['photos', 'likes', 'comments', 'user'])
            ->when($userId, function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('caption', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->get();

        return view('admin.user.posts', compact('posts', 'search', 'totalPosts', 'userId'));
    }

    public function userAccount(Request $request)
    {
        $search = request()->search;

        $users = User::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        })
        ->where('role', 'user')
        ->latest()
        ->get();
        return view('admin.user.index', compact('users', 'search'));
    }

    public function reportPosts(Request $request)
    {
        $search = $request->search;

        $reports = Report::with([
                'reporter',
                'reportedUser',
                'post'
            ])
            ->whereNotNull('post_id')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('reporter', fn ($qr) =>
                        $qr->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas('reportedUser', fn ($qu) =>
                        $qu->where('name', 'like', "%{$search}%")
                    )
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.report.posts', compact('reports', 'search'));
    }

    /**
     * Halaman laporan komentar
     */
    public function reportComments(Request $request)
    {
        $search = $request->search;

        $reports = Report::with([
                'reporter',
                'reportedUser',
                'comment'
            ])
            ->whereNotNull('comment_id')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('reporter', fn ($qr) =>
                        $qr->where('name', 'like', "%{$search}%")
                    )
                    ->orWhereHas('reportedUser', fn ($qu) =>
                        $qu->where('name', 'like', "%{$search}%")
                    )
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('admin.report.comment', compact('reports', 'search'));
    }


    public function index()
    {
        return view('admin.dashboard');
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
    public function destroyUser(string $id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->route('admin.user.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function banPost(Request $request, Posts $post)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($post, $request) {

            // update status post
            $post->update([
                'status' => 'banned'
            ]);

            // simpan histori ban
            Banned::create([
                'admin_id' => auth()->id(),
                'user_id' => $post->user_id,
                'post_id' => $post->id,
                'reason' => $request->reason,
                'notes' => $request->notes,
            ]);
        });

        return back()->with('success', 'Postingan berhasil dibanned 🚫');
    }

    public function banComment(Request $request, Comment $comment)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($comment, $request) {

            // update status comment
            $comment->update([
                'status' => 'banned'
            ]);

            // simpan histori ban
            Banned::create([
                'admin_id' => auth()->id(),
                'user_id' => $comment->user_id,
                'comment_id' => $comment->id,
                'reason' => $request->reason,
                'notes' => $request->notes,
            ]);
        });

        return back()->with('success', 'Komentar berhasil dibanned 🚫');
    }

}
