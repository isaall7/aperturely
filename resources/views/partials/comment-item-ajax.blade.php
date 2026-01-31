{{-- resources/views/partials/comment-item-ajax.blade.php --}}
@if(isset($isReply) && $isReply)
    {{-- Reply item (no wrapper needed, will be inside replies-container) --}}
    <div class="comment-item reply-item" id="comment-{{ $comment->id }}" style="margin-bottom: 12px;">
        <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="comment-avatar-link">
            <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                alt="{{ $comment->user->name ?? 'User' }}" 
                class="comment-avatar">
        </a>
        <div class="comment-content">
            <div>
                <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="comment-username-link">
                    <span class="comment-username">{{ $comment->user->username ?? $comment->user->name }}</span>
                </a>
                <span class="comment-text">{{ $comment->comment }}</span>
            </div>
            <div class="comment-actions">
                <span>{{ $comment->created_at->diffForHumans() }}</span>
                
                @auth
                    <button type="button" 
                            class="reply-btn" 
                            data-id="{{ $comment->id }}"
                            data-username="{{ $comment->user->username ?? $comment->user->name }}">
                        Reply
                    </button>
                    
                    {{-- Tombol hapus hanya untuk pemilik komentar atau admin --}}
                    @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                        <button type="button" 
                                class="delete-comment-btn" 
                                data-id="{{ $comment->id }}"
                                data-url="{{ route('user.comments.destroy', $comment->id) }}">
                            Hapus
                        </button>
                    @endif
                    
                    {{-- Tombol report hanya untuk user lain --}}
                    @if(auth()->id() !== $comment->user_id)
                        <button data-bs-toggle="modal" 
                                data-bs-target="#reportCommentModal{{ $comment->id }}">
                            Report
                        </button>
                    @endif
                @else
                    <button data-bs-toggle="modal" 
                            data-bs-target="#reportCommentModal{{ $comment->id }}">
                        Report
                    </button>
                @endauth
            </div>
        </div>
    </div>
@else
    {{-- Parent comment (needs wrapper) --}}
    <div class="comment-wrapper" id="comment-wrapper-{{ $comment->id }}">
        <div class="comment-item" id="comment-{{ $comment->id }}">
            <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="comment-avatar-link">
                <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                    alt="{{ $comment->user->name ?? 'User' }}" 
                    class="comment-avatar">
            </a>
            <div class="comment-content">
                <div>
                    <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="comment-username-link">
                        <span class="comment-username">{{ $comment->user->username ?? $comment->user->name }}</span>
                    </a>
                    <span class="comment-text">{{ $comment->comment }}</span>
                </div>
                <div class="comment-actions">
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    
                    @auth
                        <button type="button" 
                                class="reply-btn" 
                                data-id="{{ $comment->id }}"
                                data-username="{{ $comment->user->username ?? $comment->user->name }}">
                            Reply
                        </button>
                        
                        {{-- Tombol hapus hanya untuk pemilik komentar atau admin --}}
                        @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                            <button type="button" 
                                    class="delete-comment-btn" 
                                    data-id="{{ $comment->id }}"
                                    data-url="{{ route('user.comments.destroy', $comment->id) }}">
                                Hapus
                            </button>
                        @endif
                        
                        {{-- Tombol report hanya untuk user lain --}}
                        @if(auth()->id() !== $comment->user_id)
                            <button data-bs-toggle="modal" 
                                    data-bs-target="#reportCommentModal{{ $comment->id }}">
                                Report
                            </button>
                        @endif
                    @else
                        <button data-bs-toggle="modal" 
                                data-bs-target="#reportCommentModal{{ $comment->id }}">
                            Report
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endif