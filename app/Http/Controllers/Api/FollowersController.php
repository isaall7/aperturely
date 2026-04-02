<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function followers()
    {
        $followers = Follow::with('follower')
            ->where('followed_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $followers
        ]);   
    }
}
