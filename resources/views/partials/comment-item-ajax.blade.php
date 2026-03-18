{{-- resources/views/partials/comment-item-ajax.blade.php --}}

@if(isset($isReply) && $isReply)
{{-- ── Reply item ── --}}
<div class="ap-comment" id="comment-{{ $comment->id }}" style="margin-bottom:10px;">
    <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}">
        <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
             alt="{{ $comment->user->name ?? 'User' }}"
             class="ap-comment-avatar">
    </a>
    <div class="ap-comment-body">
        <div>
            <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="ap-comment-author">{{ $comment->user->username ?? $comment->user->name }}</a>
            <span class="ap-comment-text">{{ $comment->comment }}</span>
        </div>
        <div class="ap-comment-meta">
            <span class="ap-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
            @auth
                <button class="ap-comment-action-btn reply-btn"
                        data-id="{{ $comment->id }}"
                        data-username="{{ $comment->user->username ?? $comment->user->name }}">Balas</button>
                @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                    <button class="ap-comment-action-btn danger delete-comment-btn"
                            data-id="{{ $comment->id }}"
                            data-url="{{ route('user.comments.destroy', $comment->id) }}">Hapus</button>
                @endif
                @if(auth()->id() !== $comment->user_id)
                    <button class="ap-comment-action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                @endif
            @else
                <button class="ap-comment-action-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
            @endauth
        </div>
    </div>
</div>

@else
{{-- ── Parent comment with wrapper ── --}}
<div class="comment-wrapper" id="comment-wrapper-{{ $comment->id }}">
    <div class="ap-comment" id="comment-{{ $comment->id }}">
        <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}">
            <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                 alt="{{ $comment->user->name ?? 'User' }}"
                 class="ap-comment-avatar">
        </a>
        <div class="ap-comment-body">
            <div>
                <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="ap-comment-author">{{ $comment->user->username ?? $comment->user->name }}</a>
                <span class="ap-comment-text">{{ $comment->comment }}</span>
            </div>
            <div class="ap-comment-meta">
                <span class="ap-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                @auth
                    <button class="ap-comment-action-btn reply-btn"
                            data-id="{{ $comment->id }}"
                            data-username="{{ $comment->user->username ?? $comment->user->name }}">Balas</button>
                    @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                        <button class="ap-comment-action-btn danger delete-comment-btn"
                                data-id="{{ $comment->id }}"
                                data-url="{{ route('user.comments.destroy', $comment->id) }}">Hapus</button>
                    @endif
                    @if(auth()->id() !== $comment->user_id)
                        <button class="ap-comment-action-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                    @endif
                @else
                    <button class="ap-comment-action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                @endauth
            </div>
        </div>
    </div>
</div>
@endif