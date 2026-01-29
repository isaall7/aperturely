@extends('layouts.index')

@section('content')
<style>
    .feed-container {
        background: #ffffff;
        min-height: 100vh;
        padding: 20px 0;
    }
    
    .masonry-grid {
        column-count: 4;
        column-gap: 20px;
        padding: 0 20px;
    }
    
    @media (max-width: 1200px) {
        .masonry-grid {
            column-count: 3;
        }
    }
    
    @media (max-width: 768px) {
        .masonry-grid {
            column-count: 2;
        }
    }
    
    @media (max-width: 480px) {
        .masonry-grid {
            column-count: 1;
        }
    }
    
    .post-card {
        background: white;
        border-radius: 16px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        overflow: hidden;
        break-inside: avoid;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    
    .post-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
    
    .post-card:hover .post-overlay {
        opacity: 1;
    }
    
    .post-image-container {
        position: relative;
        width: 100%;
        background: #f0f0f0;
    }
    
    .post-image-container img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 16px 16px 0 0;
    }
    
    .post-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.4));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 15px;
        border-radius: 16px 16px 0 0;
    }
    
    .post-overlay-top {
        display: flex;
        justify-content: flex-end;
    }
    
    .post-overlay-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .overlay-btn {
        background: white;
        border: none;
        border-radius: 24px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    
    .overlay-btn:hover {
        transform: scale(1.05);
    }
    
    .save-btn {
        background: #e60023;
        color: white;
    }
    
    .action-btns {
        display: flex;
        gap: 8px;
    }
    
    .icon-btn {
        background: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }
    
    .icon-btn:hover {
        transform: scale(1.1);
        background: #f0f0f0;
    }
    
    .post-info {
        padding: 12px 15px;
    }
    
    .post-caption {
        font-size: 14px;
        color: #333;
        margin-bottom: 8px;
        font-weight: 500;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .post-user {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .user-name {
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }
    
    .post-stats {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: #666;
        margin-top: 8px;
    }
    
    .post-stats span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .empty-feed {
        text-align: center;
        padding: 100px 20px;
        background: white;
        border-radius: 16px;
        margin: 20px;
    }

    .empty-feed i {
        font-size: 64px;
        margin-bottom: 20px;
        display: block;
    }

    .empty-feed h4 {
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .empty-feed p {
        color: #8e8e8e;
        font-size: 14px;
    }
    
    /* Modal Styles */
    .detail-modal .modal-dialog {
        max-width: 1200px;
        height: 90vh;
        margin: 5vh auto;
    }
    
    .detail-modal .modal-content {
        border-radius: 16px;
        overflow: hidden;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .detail-modal .modal-body {
        padding: 0;
        flex: 1;
        overflow: hidden;
    }
    
    .modal-container {
        display: flex;
        height: 100%;
    }
    
    .modal-image-section {
        flex: 1;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .modal-image-section img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Modal Carousel */
    .modal-carousel {
        width: 100%;
        height: 100%;
    }

    .modal-carousel .carousel-inner {
        height: 100%;
    }

    .modal-carousel .carousel-item {
        height: 100%;
        display: none !important;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .modal-carousel .carousel-item.active {
        display: flex !important;
        position: relative;
    }

    .modal-carousel .carousel-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .modal-carousel .carousel-control-prev,
    .modal-carousel .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: all 0.3s;
        z-index: 10;
    }

    .modal-carousel .carousel-control-prev:hover,
    .modal-carousel .carousel-control-next:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-50%) scale(1.1);
    }

    .modal-carousel .carousel-control-prev {
        left: 20px;
    }

    .modal-carousel .carousel-control-next {
        right: 20px;
    }

    .modal-carousel .carousel-control-prev:hover,
    .modal-carousel .carousel-control-next:hover {
        background: rgba(255, 255, 255, 1);
    }

    .modal-carousel .carousel-control-prev-icon,
    .modal-carousel .carousel-control-next-icon {
        width: 24px;
        height: 24px;
        filter: invert(1);
    }

    .modal-carousel .carousel-indicators {
        bottom: 20px;
    }

    .modal-carousel .carousel-indicators button {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        border: none;
        margin: 0 4px;
    }

    .modal-carousel .carousel-indicators button.active {
        background-color: #fff;
    }
    
    .modal-details-section {
        width: 450px;
        background: white;
        display: flex;
        flex-direction: column;
        border-left: 1px solid #e0e0e0;
    }
    
    .modal-header-custom {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .modal-action-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 24px;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.2s;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-action-btn:hover {
        background: #f0f0f0;
    }
    
    .modal-save-btn {
        background: #e60023;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 24px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .modal-save-btn:hover {
        background: #ad081b;
        transform: scale(1.05);
    }
    
    .modal-user-section {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .modal-user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .modal-user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .modal-user-details h6 {
        margin: 0;
        font-weight: 600;
        color: #1a1a1a;
        font-size: 16px;
    }
    
    .modal-user-details span {
        font-size: 13px;
        color: #666;
    }
    
    .modal-caption {
        font-size: 14px;
        color: #333;
        line-height: 1.6;
    }
    
    .modal-stats {
        display: flex;
        gap: 20px;
        margin-top: 12px;
        font-size: 14px;
        color: #666;
    }
    
    .modal-stats span {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .modal-comments-section {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
    }
    
    .comment-item {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .comment-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    .comment-content {
        flex: 1;
    }
    
    .comment-username {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14px;
        margin-right: 8px;
    }
    
    .comment-text {
        color: #333;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .comment-actions {
        display: flex;
        gap: 15px;
        margin-top: 8px;
        font-size: 12px;
        color: #666;
    }
    
    .comment-actions button {
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        padding: 0;
        font-weight: 600;
        font-size: 12px;
    }
    
    .comment-actions button:hover {
        color: #000;
    }
    
    .modal-comment-input-section {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
    }
    
    .modal-comment-input {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .modal-comment-input input {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 24px;
        padding: 12px 20px;
        outline: none;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .modal-comment-input input:focus {
        border-color: #4a90e2;
    }
    
    .modal-comment-input button {
        background: #4a90e2;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 24px;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .modal-comment-input button:hover {
        background: #357abd;
    }
    
    .modal-comment-input button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
        padding: 8px 0;
        min-width: 200px;
    }

    .dropdown-item {
        padding: 10px 20px;
        font-size: 14px;
        color: #1a1a1a;
        transition: all 0.2s;
    }

    .dropdown-item:hover {
        background: #f0f7ff;
        color: #4a90e2;
    }

    .dropdown-item.text-danger:hover {
        background: #ffe8e8;
        color: #e74c3c;
    }

    /* Report Modal */
    .report-modal .modal-dialog {
        max-width: 500px;
    }

    .report-modal .modal-content {
        border-radius: 12px;
        border: none;
    }

    .report-modal .modal-header {
        border-bottom: 1px solid #e8e8e8;
        padding: 20px;
    }

    .report-modal .modal-title {
        font-weight: 700;
        font-size: 18px;
        color: #1a1a1a;
    }

    .report-modal .modal-body {
        padding: 20px;
    }

    .report-modal .form-label {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .report-modal .form-select,
    .report-modal .form-control {
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .report-modal .form-select:focus,
    .report-modal .form-control:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .report-modal .btn-submit-report {
        background: #e74c3c;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        width: 100%;
    }

    .report-modal .btn-submit-report:hover {
        background: #c0392b;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
    }

    .report-modal .btn-cancel {
        background: #f0f5f9;
        color: #1a1a1a;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        width: 100%;
    }

    .report-modal .btn-cancel:hover {
        background: #e0e7ed;
    }
    
    /* Scrollbar */
    .modal-comments-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .modal-comments-section::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .modal-comments-section::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .modal-comments-section::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    @media (max-width: 992px) {
        .modal-details-section {
            width: 100%;
        }
        
        .modal-container {
            flex-direction: column;
        }
        
        .modal-image-section {
            height: 50vh;
        }
    }
</style>

<div class="feed-container">
    <div class="container-fluid">
        @if($posts->count() > 0)
            <div class="masonry-grid">
                @foreach($posts as $post)
                    <div class="post-card" data-bs-toggle="modal" data-bs-target="#detailModal{{ $post->id }}">
                        <div class="post-image-container">
                            @if($post->photos && $post->photos->first())
                                <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post">
                            @else
                                <img src="https://via.placeholder.com/300x400?text=No+Image" alt="No Image">
                            @endif
                            
                            <div class="post-overlay">
                                <div class="post-overlay-top">
                                    <button class="overlay-btn save-btn" onclick="event.stopPropagation();">Save</button>
                                </div>
                                <div class="post-overlay-bottom">
                                    <div class="action-btns">
                                        <button class="icon-btn" onclick="event.stopPropagation(); toggleLike(this);">🤍</button>
                                        <button class="icon-btn" onclick="event.stopPropagation();">💬</button>
                                        <button class="icon-btn" onclick="event.stopPropagation();">📤</button>
                                    </div>
                                    <div class="dropdown" onclick="event.stopPropagation();">
                                        <button class="icon-btn" type="button" data-bs-toggle="dropdown">
                                            ⋯
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @auth
                                                @if(auth()->id() === $post->user_id)
                                                    <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">🗑️ Hapus</a></li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" 
                                                           data-bs-toggle="modal" 
                                                           data-bs-target="#reportPostModal{{ $post->id }}">
                                                            🚩 Laporkan
                                                        </a>
                                                    </li>
                                                @endif
                                            @else
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#reportPostModal{{ $post->id }}">
                                                        🚩 Laporkan
                                                    </a>
                                                </li>
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($post->caption || $post->user)
                            <div class="post-info">
                                <div class="post-user">
                               <img 
                                    src="{{ $post->user?->avatar_display 
                                        ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                    alt="Avatar" 
                                    class="user-avatar"
                                >
                                    <span class="user-name">{{ $post->user->username ?? $post->user->name }}</span>
                                </div>  
                                @if($post->caption)
                                    <div class="post-caption">{{ $post->caption }}</div>
                                @endif
                                <div class="post-stats">
                                    <span>❤️ {{ $post->likes->count() ?? 0 }}</span>
                                    <span>💬 {{ $post->comments->count() ?? 0 }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Modal -->
                    <div class="modal fade detail-modal" id="detailModal{{ $post->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="modal-container">
                                        <div class="modal-image-section">
                                            @if($post->photos && $post->photos->count() > 1)
                                                <div id="modalCarousel{{ $post->id }}" class="carousel slide modal-carousel" data-bs-ride="false">
                                                    <div class="carousel-inner">
                                                        @foreach($post->photos as $index => $photo)
                                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                <img src="{{ asset('storage/' . $photo->photo) }}" alt="Post {{ $index + 1 }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if($post->photos->count() > 1)
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel{{ $post->id }}" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"></span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel{{ $post->id }}" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"></span>
                                                        </button>
                                                        <div class="carousel-indicators">
                                                            @foreach($post->photos as $index => $photo)
                                                                <button type="button" 
                                                                        data-bs-target="#modalCarousel{{ $post->id }}" 
                                                                        data-bs-slide-to="{{ $index }}" 
                                                                        class="{{ $index == 0 ? 'active' : '' }}">
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @elseif($post->photos && $post->photos->first())
                                                <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post">
                                            @else
                                                <img src="https://via.placeholder.com/600x600?text=No+Image" alt="No Image">
                                            @endif
                                        </div>
                                        
                                        <div class="modal-details-section">
                                            <div class="modal-header-custom">
                                                <div class="modal-header-actions">
                                                    <button class="modal-action-btn" onclick="toggleLike(this)">🤍</button>
                                                    <button class="modal-action-btn">📤</button>
                                                    <div class="dropdown">
                                                        <button class="modal-action-btn" type="button" data-bs-toggle="dropdown">
                                                            ⋯
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @auth
                                                                @if(auth()->id() === $post->user_id)
                                                                    <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                                                    <li><a class="dropdown-item text-danger" href="#">🗑️ Hapus</a></li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" href="#" 
                                                                           data-bs-toggle="modal" 
                                                                           data-bs-target="#reportPostModal{{ $post->id }}">
                                                                            🚩 Laporkan
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="#" 
                                                                       data-bs-toggle="modal" 
                                                                       data-bs-target="#reportPostModal{{ $post->id }}">
                                                                        🚩 Laporkan
                                                                    </a>
                                                                </li>
                                                            @endauth
                                                        </ul>
                                                    </div>
                                                </div>
                                                <button class="modal-save-btn">Save</button>
                                            </div>
                                            
                                            <div class="modal-user-section">
                                                <div class="modal-user-info">
                                                <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}">
                                                    <img src="{{ $post->user->avatar_display }}" alt="Avatar" class="user-avatar">
                                                </a>

                                                <div class="modal-user-details">
                                                <h6 class="username text-dark">
                                                    <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="text-dark text-decoration-none">
                                                        {{ $post->user->username ?? $post->user->name }}
                                                    </a>
                                                </h6>

                                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                
                                                @if($post->caption)
                                                    <div class="modal-caption">{{ $post->caption }}</div>
                                                @endif
                                                
                                                <div class="modal-stats">
                                                    <span>❤️ {{ $post->likes->count() ?? 0 }} likes</span>
                                                    <span>💬 {{ $post->comments->count() ?? 0 }} comments</span>
                                                </div>
                                            </div>
                                            
                                            <div class="modal-comments-section">
                                                @forelse($post->comments as $comment)
                                                    <div class="comment-item">
                                                        <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}" 
                                                             alt="{{ $comment->user->name }}" 
                                                             class="comment-avatar">
                                                        <div class="comment-content">
                                                            <div>
                                                                <span class="comment-username">{{ $comment->user->username ?? $comment->user->name }}</span>
                                                                <span class="comment-text">{{ $comment->comment }}</span>
                                                            </div>
                                                            <div class="comment-actions">
                                                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                                <button>Reply</button>
                                                                @auth
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
                                                @empty
                                                    <p class="text-center text-muted">Belum ada komentar</p>
                                                @endforelse
                                            </div>
                                            
                                            <div class="modal-comment-input-section">
                                                <div class="modal-comment-input">
                                                    <input type="text" placeholder="Add a comment...">
                                                    <button disabled>Post</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Report Post Modal -->
                    <div class="modal fade report-modal" id="reportPostModal{{ $post->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">🚩 Laporkan Postingan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('user.report.post', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Laporan <span class="text-danger">*</span></label>
                                            <select class="form-select" name="reason" required>
                                                <option value="">Pilih alasan...</option>
                                                <option value="spam">Spam</option>
                                                <option value="bullying">Bullying atau Pelecehan</option>
                                                <option value="hate_speech">Ujaran Kebencian (SARA)</option>
                                                <option value="pornography">Konten Pornografi</option>
                                                <option value="violence">Kekerasan</option>
                                                <option value="scam">Penipuan</option>
                                                <option value="copyright">Pelanggaran Hak Cipta</option>
                                                <option value="misinformation">Informasi Menyesatkan</option>
                                                <option value="other">Lainnya</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan Tambahan (Opsional)</label>
                                            <textarea class="form-control" 
                                                      name="description" 
                                                      rows="4" 
                                                      placeholder="Jelaskan lebih detail mengapa Anda melaporkan postingan ini..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn-submit-report">Kirim Laporan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @foreach($post->comments as $comment)
                        <!-- Report Comment Modal -->
                        <div class="modal fade report-modal" id="reportCommentModal{{ $comment->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">🚩 Laporkan Komentar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('user.report.comment', $comment->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Alasan Laporan <span class="text-danger">*</span></label>
                                                <select class="form-select" name="reason" required>
                                                    <option value="">Pilih alasan...</option>
                                                    <option value="spam">Spam</option>
                                                    <option value="bullying">Bullying atau Pelecehan</option>
                                                    <option value="hate_speech">Ujaran Kebencian (SARA)</option>
                                                    <option value="pornography">Konten Pornografi</option>
                                                    <option value="violence">Kekerasan</option>
                                                    <option value="scam">Penipuan</option>
                                                    <option value="copyright">Pelanggaran Hak Cipta</option>
                                                    <option value="misinformation">Informasi Menyesatkan</option>
                                                    <option value="other">Lainnya</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan Tambahan (Opsional)</label>
                                                <textarea class="form-control" 
                                                          name="description" 
                                                          rows="4" 
                                                          placeholder="Jelaskan lebih detail mengapa Anda melaporkan komentar ini..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn-submit-report">Kirim Laporan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4 mb-4">
                {{ $posts->links() }}
            </div>
        @else
            <div class="empty-feed">
                <i>📷</i>
                <h4>Belum Ada Postingan</h4>
                <p>Jadilah yang pertama membuat postingan!</p>
            </div>
        @endif
    </div>
</div>

<script>
function toggleLike(button) {
    if (button.classList.contains('liked')) {
        button.innerHTML = '🤍';
        button.classList.remove('liked');
    } else {
        button.innerHTML = '❤️';
        button.classList.add('liked');
    }
}

// Enable post button when input has text
document.addEventListener('DOMContentLoaded', function() {
    // Comment input functionality
    document.querySelectorAll('.modal-comment-input input').forEach(input => {
        input.addEventListener('input', function() {
            const button = this.nextElementSibling;
            if (this.value.trim().length > 0) {
                button.disabled = false;
            } else {
                button.disabled = true;
            }
        });
    });

    // Fix carousel functionality
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        const bsCarousel = new bootstrap.Carousel(carousel, {
            interval: false, // Don't auto-slide
            wrap: true,
            touch: true
        });
    });

    // Prevent modal close when clicking carousel controls
    document.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // Prevent card click when interacting with carousel in feed
    document.querySelectorAll('.post-card .carousel-control-prev, .post-card .carousel-control-next').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
});
</script>

@endsection