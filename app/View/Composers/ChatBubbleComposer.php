<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ChatBubbleComposer
{
    public function compose(View $view): void
    {
        if (!Auth::check()) return;

        $conversations = Auth::user()
            ->conversations()
            ->with(['users', 'lastMessage'])
            ->get()
            ->map(function ($conv) {
                $other = $conv->users->where('id', '!=', Auth::id())->first();
                if (!$other) return null;

                return [
                    'conversation_id' => $conv->id,
                    'user'            => $other,
                    'last_message'    => $conv->lastMessage,
                    'unread_count'    => $conv->messages()
                        ->where('sender_id', '!=', Auth::id())
                        ->where('is_read', false)
                        ->count(),
                ];
            })
            ->filter() // hapus null
            ->values();

        $view->with('bubbleConversations', $conversations);
        $view->with('bubbleTotalUnread', $conversations->sum('unread_count'));
    }
}