<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ── Halaman utama — list semua conversation ──
    public function index(Request $request)
{
    $conversations = Auth::user()
        ->conversations()
        ->with(['users', 'lastMessage.sender'])
        ->get()
        ->map(function ($conv) {
            $other = $conv->users->where('id', '!=', Auth::id())->first();

            if (!$other) {
                return null;
            }

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
        ->filter()
        ->values();

    // Jika ada ?user=id di URL, buat/cari conversation lalu auto-open
    $openConvId = null;
    if ($request->user) {
        $other = User::findOrFail($request->user);
        $conv  = Auth::user()->conversations()
            ->whereHas('users', fn($q) => $q->where('users.id', $other->id))
            ->first();

        if (!$conv) {
            $conv = Conversation::create([]);
            $conv->users()->attach([Auth::id(), $other->id]);
        }

        $openConvId = $conv->id;
    }

    return view('user.chat.index', compact('conversations', 'openConvId'));
}

    // ── Ambil messages ──
    public function messages($conversationId)
    {
        $conversation = Conversation::whereHas(
            'users', fn($q) => $q->where('users.id', Auth::id())
        )->findOrFail($conversationId);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    // ── Kirim pesan ──
    public function send(Request $request, $conversationId)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $conversation = Conversation::whereHas(
            'users', fn($q) => $q->where('users.id', Auth::id())
        )->findOrFail($conversationId);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message'   => $request->message,
            'is_read'   => false,
        ]);

        $message->load('sender');

        // Broadcast realtime (Pusher/Reverb)
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    // ── Tandai dibaca ──
    public function read($conversationId)
    {
        Conversation::whereHas(
            'users', fn($q) => $q->where('users.id', Auth::id())
        )->findOrFail($conversationId);

        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    }
}
