<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $conversations = Auth::user()
            ->conversations()
            ->with('users')
            ->get()
            ->map(function ($conversation) {
                $otherUser = $conversation->users->firstWhere('id', '!=', Auth::id());

                if (! $otherUser) {
                    return null;
                }

                return [
                    'conversation_id' => $conversation->id,
                    'user' => $otherUser,
                ];
            })
            ->filter()
            ->values();

        $openConvId = null;

        if ($request->filled('user')) {
            $otherUser = User::findOrFail($request->integer('user'));

            $conversation = Auth::user()->conversations()
                ->whereHas('users', fn ($query) => $query->where('users.id', $otherUser->id))
                ->first();

            if (! $conversation) {
                $conversation = Conversation::create([]);
                $conversation->users()->attach([Auth::id(), $otherUser->id]);
            }

            $openConvId = $conversation->id;
        }

        return view('user.chat.index', compact('conversations', 'openConvId'));
    }
}
