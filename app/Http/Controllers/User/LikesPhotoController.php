<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Likes_photo;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikesPhotoController extends Controller
{
    // LIKE PHOTO
    public function likePhoto($postId)
    {
        $userId = Auth::id();

        $like = Likes_photo::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            return response()->json([
                'liked' => false
            ]);
        }

        Likes_photo::create([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);

        // ajax response
        return response()->json([
            'liked' => true,
            'total' => Likes_photo::where('post_id', $postId)->count()
        ]);

        return response()->json([
            'liked' => false,
            'total' => Likes_photo::where('post_id', $postId)->count()
        ]);

    }

}
