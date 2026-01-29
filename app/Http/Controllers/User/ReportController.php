<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Posts;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function reportPost(Request $request, Posts $post)
    {
        $request->validate([
            'reason' => 'required|string',
            'description' => 'nullable|string|max:1000'
        ]);

        // Cek apakah user sudah pernah melaporkan post ini
        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('post_id', $post->id)
            ->whereNull('comment_id')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'Anda sudah melaporkan postingan ini sebelumnya.');
        }

        // Buat laporan baru
        Report::create([
            'reporter_id' => Auth::id(),
            'reported_user_id' => $post->user_id,
            'post_id' => $post->id,
            'comment_id' => null,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Laporan Anda telah dikirim. Tim kami akan meninjaunya segera.');
    }

    public function reportComment(Request $request, Comment $comment)
    {
        $request->validate([
            'reason' => 'required|string',
            'description' => 'nullable|string|max:1000'
        ]);

        // Cek apakah user sudah pernah melaporkan comment ini
        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('comment_id', $comment->id)
            ->whereNull('post_id')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'Anda sudah melaporkan komentar ini sebelumnya.');
        }

        // Buat laporan baru
        Report::create([
            'reporter_id' => Auth::id(),
            'reported_user_id' => $comment->user_id,
            'post_id' => null,
            'comment_id' => $comment->id,
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Laporan Anda telah dikirim. Tim kami akan meninjaunya segera.');
    }
}