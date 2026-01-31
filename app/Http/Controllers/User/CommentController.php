<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        // untuk menampilkan komentar udah di DashboardUserController
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:1000',
            'reply_id' => 'nullable|exists:comments,id',     
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'reply_id' => $request->reply_id,
        ]);

        // Load relasi user untuk response
        $comment->load('user');

        // Jika request AJAX, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Render HTML untuk comment baru
            $isReply = $comment->reply_id ? true : false;
            $html = view('partials.comment-item-ajax', [
                'comment' => $comment,
                'isReply' => $isReply
            ])->render();

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil ditambahkan!',
                'comment' => $comment,
                'html' => $html
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Pastikan hanya pemilik komentar atau admin yang dapat menghapus
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk menghapus komentar ini.'
                ], 403);
            }
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $comment->delete();

        // Jika request AJAX, return JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus!'
            ]);
        }

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
