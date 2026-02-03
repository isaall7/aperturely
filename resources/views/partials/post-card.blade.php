{{-- resources/views/user/partials/post-card.blade.php --}}
<div class="post-card">
    <div class="post-image-container" data-bs-toggle="modal" data-bs-target="#detailModal{{ $post->id }}">
        @if($post->photos && $post->photos->first())
            <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post" loading="lazy">
        @else
            <img src="https://via.placeholder.com/300x400?text=No+Image" alt="No Image">
        @endif
    </div>
    
    @if($post->caption || $post->user)
        <div class="post-info">
            <div class="post-user">
                <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}">
                    <img src="{{ $post->user->avatar_display }}" alt="Avatar" class="user-avatar">
                </a>
                <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="user-name">
                    {{ $post->user->username ?? $post->user->name }}
                </a>
            </div>  
            @if($post->caption)
                <div class="post-caption">{{ $post->caption }}</div>
            @endif
            <div class="post-stats">
                <span>❤️ {{ $post->likes->count() }}</span>
                <span>💬 {{ number_format($post->comments->count() ?? 0) }}</span>
            </div>
        </div>
    @endif
</div>