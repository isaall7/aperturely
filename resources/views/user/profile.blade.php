@extends('layouts.index2')

@section('content')
<style>
    .profile-container {
        background: #ffffff;
        min-height: 80vh;
        padding: 0;
        margin-top: -25px;
    }

    .profile-banner {
        height: 140px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        border-radius: 5px 5px 0 0;
    }

    .profile-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,181.3C960,181,1056,139,1152,133.3C1248,128,1344,160,1392,176L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
    }

    .profile-main-info {
        max-width: 1200px;
        margin: -80px auto 0;
        padding: 0 40px;
        position: relative;
        z-index: 1;
    }

    .profile-card-top {
        background: white;
        border-radius: 20px;
        padding: 40px 40px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        display: flex;
        align-items: flex-start;
        gap: 30px;
        margin-bottom: 30px;
    }

    .profile-avatar-wrapper {
        flex-shrink: 0;
        position: relative;
    }

    .profile-avatar {
        width: 180px;
        height: 180px;
        border-radius: 20px;
        object-fit: cover;
        border: 5px solid white;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    .profile-avatar-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #4a90e2;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .profile-info-main {
        flex: 1;
        padding-top: 0px;
    }

    .profile-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .profile-name-section h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 5px 0;
    }

    .profile-username {
        font-size: 16px;
        color: #666;
        margin: 0;
    }

    .profile-action-buttons {
        display: flex;
        gap: 12px;
    }

    .btn-primary-action {
        background: #4a90e2;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary-action:hover {
        background: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        color: white;
    }

    .btn-secondary-action {
        background: #f0f5f9;
        color: #1a1a1a;
        border: 2px solid #e0e7ed;
        padding: 12px 32px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-secondary-action:hover {
        background: #e0e7ed;
        border-color: #d0d7dd;
        transform: translateY(-2px);
        color: #1a1a1a;
    }

    .btn-follow {
        background: #e60023;
        color: white;
    }

    .btn-follow:hover {
        background: #ad081b;
        color: white;
    }

    .btn-following {
        background: #f0f5f9;
        color: #4a90e2;
        border-color: #4a90e2;
    }

    .btn-following:hover {
        background: #ffe8e8;
        color: #e74c3c;
        border-color: #e74c3c;
    }

    .profile-stats-row {
        display: flex;
        gap: 40px;
        padding: 20px 0;
        border-top: 2px solid #f0f5f9;
        border-bottom: 2px solid #f0f5f9;
        margin-bottom: 20px;
    }

    .stat-box {
        text-align: center;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        display: block;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 5px;
    }

    .profile-bio {
        line-height: 1.8;
    }

    .profile-bio p {
        color: #4a4a4a;
        font-size: 15px;
        margin: 0;
    }

    .profile-meta {
        display: flex;
        gap: 25px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-size: 14px;
    }

    .meta-item i {
        font-size: 16px;
    }

    .posts-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px 40px;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .view-toggle {
        display: flex;
        gap: 8px;
        background: #f0f5f9;
        padding: 4px;
        border-radius: 10px;
    }

    .toggle-btn {
        padding: 8px 16px;
        border: none;
        background: transparent;
        color: #666;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .toggle-btn.active {
        background: white;
        color: #4a90e2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .posts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }

    .post-item {
        position: relative;
        aspect-ratio: 1;
        cursor: pointer;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        background: #f0f0f0;
    }

    .post-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    .post-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .post-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.6));
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        opacity: 0;
        transition: opacity 0.3s;
        color: white;
        font-weight: 600;
    }

    .post-item:hover .post-overlay {
        opacity: 1;
    }

    .overlay-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
    }

    .multi-photo-indicator {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .empty-posts {
        text-align: center;
        padding: 100px 20px;
        background: #f8f9fa;
        border-radius: 20px;
    }

    .empty-posts i {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .empty-posts h4 {
        color: #1a1a1a;
        font-size: 20px;
        margin-bottom: 10px;
    }

    .empty-posts p {
        color: #8e8e8e;
        font-size: 15px;
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
    
    /* Comment Styles with Profile Links */
    .comment-wrapper {
        margin-bottom: 20px;
    }

    .comment-item {
        display: flex;
        gap: 12px;
        margin-bottom: 0;
    }
    
    .comment-avatar-link {
        display: block;
        line-height: 0;
        transition: opacity 0.2s ease;
        flex-shrink: 0;
    }
    
    .comment-avatar-link:hover {
        opacity: 0.7;
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
    
    .comment-username-link {
        text-decoration: none;
        color: inherit;
    }
    
    .comment-username-link:hover .comment-username {
        text-decoration: underline;
        color: #000;
    }
    
    .comment-username {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14px;
        margin-right: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
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
        transition: color 0.2s ease;
    }
    
    .comment-actions button:hover {
        color: #000;
    }

    .comment-actions .delete-comment-btn {
        color: #ed4956;
    }

    .comment-actions .delete-comment-btn:hover {
        color: #c91f2e;
    }

    /* Replies Container */
    .replies-container {
        margin-left: 48px;
        margin-top: 12px;
        padding-left: 12px;
        border-left: 2px solid #efefef;
    }

    .reply-item {
        margin-bottom: 12px;
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

    /* Reply Info Banner */
    .reply-info {
        display: none;
        padding: 8px 12px;
        background: #f0f5f9;
        border-radius: 8px;
        margin-top: 8px;
        font-size: 13px;
        color: #666;
    }

    .reply-info small {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cancel-reply {
        background: none;
        border: none;
        color: #e74c3c;
        cursor: pointer;
        font-weight: 600;
        padding: 0;
        margin-left: 10px;
    }

    .cancel-reply:hover {
        color: #c0392b;
    }

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

    /* Responsive */
    @media (max-width: 1200px) {
        .posts-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .profile-banner {
            height: 200px;
        }

        .profile-main-info {
            padding: 0 20px;
            margin-top: -60px;
        }

        .profile-card-top {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 30px 20px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
        }

        .profile-header-row {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .profile-action-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn-primary-action,
        .btn-secondary-action {
            width: 100%;
            justify-content: center;
        }

        .profile-stats-row {
            justify-content: center;
            gap: 30px;
        }

        .posts-section {
            padding: 0 20px 40px;
        }

        .posts-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .modal-container {
            flex-direction: column;
        }
        
        .modal-details-section {
            width: 100%;
        }
        
        .modal-image-section {
            height: 50vh;
        }
    }
</style>

<div class="profile-container">
    <!-- Banner Section -->
    <div class="profile-banner">

    </div>
    <!-- Main Profile Info -->
    <div class="profile-main-info">
        <div class="profile-card-top">
            <div class="profile-avatar-wrapper">
          <img
            src="{{ $user?->avatar_display
                ?? 'https://ui-avatars.com/api/?name=User' }}"
            alt="Avatar"
            class="profile-avatar"
        />

                <!-- gunakan ini jika follower lebih dari 100 follower -->
                <!-- <div class="profile-avatar-badge">✓</div> -->
            </div>

            <div class="profile-info-main">
                <div class="profile-header-row">
                    <div class="profile-name-section">
                        <h1>{{ $user->name ?? 'username' }}</h1>
                    </div>

                    <div class="profile-action-buttons">
                        @auth
                            @if(auth()->id() === $user->id)
                                <!-- Own Profile -->
                                <a href="{{ route('user.postingan.create') }}" class="btn-primary-action">
                                    <span>Buat Postingan</span> 
                                </a>
                                <a href="{{ route('user.avatar.create') }}" class="btn-secondary-action">
                                    <span>Edit Profile</span> 
                                </a>
                            @else
                                <!-- Other's Profile -->
                                <button class="btn-primary-action btn-follow" id="followBtn" onclick="toggleFollow()">
                                    <span>Mengikuti</span> 
                                </button>
                                <button class="btn-secondary-action">
                                    <span>Pesan</span> 
                                </button>
                            @endif
                        @else
                            <!-- Not Logged In -->
                            <a href="{{ route('login') }}" class="btn-primary-action btn-follow">
                                <span>Login</span> 
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="profile-stats-row">
                    <div class="stat-box">
                        <span class="stat-number">{{ $totalPost }}</span>
                        <span class="stat-label">Postingan</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">0</span>
                        <span class="stat-label">Mengikuti</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">0</span>
                        <span class="stat-label">Diikuti</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number">{{ $totalLike }}</span>
                        <span class="stat-label">Menyukai</span>
                    </div>
                </div>

                <div class="profile-bio">
                    <p>{{ $user->profile->bio ?? 'Belum ada bio.' }}</p>
                    
                    <div class="profile-meta">

                        <div class="meta-item">
                            <i>📅</i>
                            <span>Bergabung {{ optional($user->created_at)->format('F Y') ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="posts-section">
        <div class="section-header">
            <h2 class="section-title">Postingan</h2>
            <div class="view-toggle">
                <button class="toggle-btn active">Grid</button>
                <button class="toggle-btn">List</button>
            </div>
        </div>

        @if($posts->count() > 0)
            <div class="posts-grid">
                @foreach($posts as $post)
                    <div class="post-item" data-bs-toggle="modal" data-bs-target="#postModal{{ $post->id }}">
                        @if($post->photos && $post->photos->first())
                            <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post">
                        @else
                            <img src="https://via.placeholder.com/300x300?text=No+Image" alt="No Image">
                        @endif
                        
                        @if($post->photos && $post->photos->count() > 1)
                            <div class="multi-photo-indicator">
                                <span>📸</span> {{ $post->photos->count() }}
                            </div>
                        @endif
                        
                        <div class="post-overlay">
                            <div class="overlay-stat">
                                <span>❤️</span>
                                <span>{{ $post->likes->count() ?? 0 }}</span>
                            </div>
                            <div class="overlay-stat">
                                <span>💬</span>
                                <span>{{ $post->comments->count() ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Post Detail Modal -->
                    <div class="modal fade detail-modal" id="postModal{{ $post->id }}" tabindex="-1">
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
                                                    <button class="modal-action-btn" type="button" data-bs-dismiss="modal">✖️</button>
                                                    @auth
                                                        @if(auth()->id() === $post->user_id)
                                                            <form action="{{ route('user.postingan.destroy', $post) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="modal-action-btn" type="submit" onclick="return confirm('Yakin ingin hapus postingan ini?')">🗑️</button>
                                                            </form>
                                                        @endif
                                                    @endauth
                                                </div>
                                                <button class="modal-save-btn">Save</button>
                                            </div>
                                            
                                            <div class="modal-user-section">
                                                <div class="modal-user-info">
                                                    <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}">
                                                        <img 
                                                            src="{{ $post->user->avatar_display }}" 
                                                            alt="Avatar" 
                                                            class="modal-user-avatar"
                                                        >
                                                    </a>
                                                    <div class="modal-user-details">
                                                        <h6>
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
                                            
                                            <div class="modal-comments-section" id="comments-container-{{ $post->id }}">
                                                @forelse($post->comments->where('reply_id', null) as $comment)
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
                                                                        
                                                                        @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                                                            <button type="button" 
                                                                                    class="delete-comment-btn" 
                                                                                    data-id="{{ $comment->id }}"
                                                                                    data-url="{{ route('user.comments.destroy', $comment->id) }}">
                                                                                Hapus
                                                                            </button>
                                                                        @endif
                                                                        
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

                                                        @if($comment->replies->count() > 0)
                                                            <div class="replies-container">
                                                                @foreach($comment->replies as $reply)
                                                                    <div class="comment-item reply-item" id="comment-{{ $reply->id }}">
                                                                        <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}" class="comment-avatar-link">
                                                                            <img src="{{ $reply->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                                                                 alt="{{ $reply->user->name ?? 'User' }}" 
                                                                                 class="comment-avatar">
                                                                        </a>
                                                                        <div class="comment-content">
                                                                            <div>
                                                                                <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}" class="comment-username-link">
                                                                                    <span class="comment-username">{{ $reply->user->username ?? $reply->user->name }}</span>
                                                                                </a>
                                                                                <span class="comment-text">{{ $reply->comment }}</span>
                                                                            </div>
                                                                            <div class="comment-actions">
                                                                                <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                                                
                                                                                @auth
                                                                                    <button type="button" 
                                                                                            class="reply-btn" 
                                                                                            data-id="{{ $reply->id }}"
                                                                                            data-username="{{ $reply->user->username ?? $reply->user->name }}">
                                                                                        Reply
                                                                                    </button>
                                                                                    
                                                                                    @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
                                                                                        <button type="button" 
                                                                                                class="delete-comment-btn" 
                                                                                                data-id="{{ $reply->id }}"
                                                                                                data-url="{{ route('user.comments.destroy', $reply->id) }}">
                                                                                            Hapus
                                                                                        </button>
                                                                                    @endif
                                                                                    
                                                                                    @if(auth()->id() !== $reply->user_id)
                                                                                        <button data-bs-toggle="modal" 
                                                                                                data-bs-target="#reportCommentModal{{ $reply->id }}">
                                                                                            Report
                                                                                        </button>
                                                                                    @endif
                                                                                @else
                                                                                    <button data-bs-toggle="modal" 
                                                                                            data-bs-target="#reportCommentModal{{ $reply->id }}">
                                                                                        Report
                                                                                    </button>
                                                                                @endauth
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <p class="text-center text-muted" id="no-comments-{{ $post->id }}">Belum ada komentar</p>
                                                @endforelse
                                            </div>
                                            
                                            @auth
                                            <form class="comment-form-ajax" data-post-id="{{ $post->id }}">
                                                @csrf
                                                <div class="modal-comment-input-section">
                                                    <div class="modal-comment-input">
                                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                        <input type="hidden" name="reply_id" class="reply-id-input" value="">
                                                        <input type="text" name="comment" class="comment-input" placeholder="Tambah komentar...">
                                                        <button type="submit">Kirim</button>
                                                    </div>
                                                    <div class="reply-info">
                                                        <small>
                                                            Membalas: <span class="reply-to-username"></span>
                                                            <button type="button" class="cancel-reply">✕ Batal</button>
                                                        </small>
                                                    </div>
                                                </div>
                                            </form>
                                            @else
                                            <div class="modal-comment-input-section">
                                                <p class="text-center text-muted">Silakan login untuk berkomentar</p>
                                            </div>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-posts">
                <i>📷</i>
                <h4>Belum Ada Postingan</h4>
                <p>{{ auth()->check() && auth()->id() === $user->id ? 'Mulai berbagi momen Anda dengan membuat postingan pertama!' : 'User ini belum membuat postingan.' }}</p>
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

function toggleFollow() {
    const btn = document.getElementById('followBtn');
    
    if (btn.classList.contains('btn-follow')) {
        btn.classList.remove('btn-follow');
        btn.classList.add('btn-following');
        btn.innerHTML = '<span>✓</span> Following';
        
        const followersStat = document.querySelectorAll('.stat-number')[1];
        const currentCount = parseInt(followersStat.textContent);
        followersStat.textContent = currentCount + 1;
    } else {
        btn.classList.remove('btn-following');
        btn.classList.add('btn-follow');
        btn.innerHTML = '<span>➕</span> Follow';
        
        const followersStat = document.querySelectorAll('.stat-number')[1];
        const currentCount = parseInt(followersStat.textContent);
        followersStat.textContent = currentCount - 1;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // ==================== AJAX COMMENT FUNCTIONALITY ====================
    document.querySelectorAll('.comment-form-ajax').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const commentInput = this.querySelector('.comment-input');
            const postId = this.dataset.postId;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Mengirim...';

            fetch('{{ route("user.comments.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentsContainer = document.getElementById('comments-container-' + postId);
                    const noComments = document.getElementById('no-comments-' + postId);
                    
                    if (noComments) {
                        noComments.remove();
                    }

                    if (data.comment.reply_id) {
                        const parentWrapper = document.getElementById('comment-wrapper-' + data.comment.reply_id);
                        if (parentWrapper) {
                            let repliesContainer = parentWrapper.querySelector('.replies-container');
                            if (!repliesContainer) {
                                repliesContainer = document.createElement('div');
                                repliesContainer.className = 'replies-container';
                                parentWrapper.appendChild(repliesContainer);
                            }
                            repliesContainer.insertAdjacentHTML('beforeend', data.html);
                        }
                    } else {
                        commentsContainer.insertAdjacentHTML('afterbegin', data.html);
                    }

                    commentInput.value = '';
                    const replyIdInput = form.querySelector('.reply-id-input');
                    const replyInfo = form.querySelector('.reply-info');
                    replyIdInput.value = '';
                    replyInfo.style.display = 'none';
                    
                    showAlert('success', 'Komentar berhasil ditambahkan!');
                } else {
                    showAlert('error', data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat mengirim komentar');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Kirim';
            });
        });
    });

    // Handle reply button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('reply-btn')) {
            const commentId = e.target.getAttribute('data-id');
            const username = e.target.getAttribute('data-username');
            
            const modal = e.target.closest('.modal');
            if (modal) {
                const form = modal.querySelector('.comment-form-ajax');
                const replyIdInput = form.querySelector('.reply-id-input');
                const replyInfo = form.querySelector('.reply-info');
                const replyToUsername = form.querySelector('.reply-to-username');
                const commentInput = form.querySelector('.comment-input');
                
                replyIdInput.value = commentId;
                replyToUsername.textContent = username;
                replyInfo.style.display = 'block';
                commentInput.focus();
            }
        }
    });

    // Handle cancel reply
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('cancel-reply')) {
            const form = e.target.closest('.comment-form-ajax');
            const replyIdInput = form.querySelector('.reply-id-input');
            const replyInfo = form.querySelector('.reply-info');
            
            replyIdInput.value = '';
            replyInfo.style.display = 'none';
        }
    });

    // Handle delete comment
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-comment-btn')) {
            if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
                const commentId = e.target.getAttribute('data-id');
                const deleteUrl = e.target.getAttribute('data-url');
                
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentElement = document.getElementById('comment-' + commentId);
                        if (commentElement) {
                            const commentWrapper = document.getElementById('comment-wrapper-' + commentId);
                            if (commentWrapper) {
                                commentWrapper.remove();
                            } else {
                                commentElement.remove();
                            }
                            
                            const modal = e.target.closest('.modal');
                            const commentsContainer = modal.querySelector('[id^="comments-container-"]');
                            const remainingComments = commentsContainer.querySelectorAll('.comment-wrapper, .comment-item:not(.reply-item)');
                            
                            if (remainingComments.length === 0) {
                                const postId = commentsContainer.id.replace('comments-container-', '');
                                commentsContainer.innerHTML = '<p class="text-center text-muted" id="no-comments-' + postId + '">Belum ada komentar</p>';
                            }
                        }
                        showAlert('success', 'Komentar berhasil dihapus!');
                    } else {
                        showAlert('error', data.message || 'Gagal menghapus komentar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Terjadi kesalahan saat menghapus komentar');
                });
            }
        }
    });

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '80px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '99999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

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

    // View toggle functionality
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            toggleBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Fix carousel functionality
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        new bootstrap.Carousel(carousel, {
            interval: false,
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
});
</script>

@endsection