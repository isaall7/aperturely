@extends('layouts.index2')

@section('content')
<style>
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Card Footer - Updated */
    .card-footer-custom {
        padding: 16px 24px;
        background: #fafafa;
        border-top: 2px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }

    .btn-delete-post {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .btn-delete-post:hover {
        background: linear-gradient(135deg, #c0392b, #a93226);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(231, 76, 60, 0.4);
    }

    .btn-delete-post:active {
        transform: translateY(0);
    }

    .btn-detail {
        background: white;
        color: #4a90e2;
        border: 2px solid #4a90e2;
        padding: 10px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-detail:hover {
        background: #4a90e2;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .btn-detail:active {
        transform: translateY(0);
    }

    /* Responsive Footer */
    @media (max-width: 768px) {
        .card-footer-custom {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn-delete-post,
        .btn-detail {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Container */
    .notification-container {
        background: #fafafa;
        min-height: calc(100vh - 60px);
        padding: 20px 0;
        margin-top: -20px;
    }

    .notification-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
    }

    /* Sidebar Navigation */
    .sidebar-card {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 80px;
    }

    .sidebar-title {
        font-size: 18px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        letter-spacing: -0.3px;
    }

    .nav-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border-radius: 14px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: #4a4a4a;
        border: 2px solid transparent;
    }

    .nav-item:hover {
        background: #f8f8f8;
        color: #1a1a1a;
    }

    .nav-item.active {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        color: white;
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .nav-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-right: 14px;
        flex-shrink: 0;
    }

    .nav-item.active .nav-icon {
        background: rgba(255, 255, 255, 0.2);
    }

    .nav-item:not(.active) .nav-icon {
        background: #f0f0f0;
    }

    .nav-content {
        flex: 1;
    }

    .nav-label {
        font-size: 15px;
        font-weight: 700;
        display: block;
        margin-bottom: 2px;
    }

    .nav-desc {
        font-size: 12px;
        opacity: 0.8;
    }

    .nav-badge {
        background: #e74c3c;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-left: auto;
    }

    .main-content {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e8e8e8;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 6px;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-subtitle {
        font-size: 15px;
        color: #8e8e8e;
        font-weight: 500;
    }

    /* User Cards */
    .users-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .user-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .user-card:hover {
        border-color: #4a90e2;
        box-shadow: 0 8px 24px rgba(74, 144, 226, 0.15);
        transform: translateY(-4px);
    }

    .user-card-header {
        background: linear-gradient(135deg, #f0f7ff, #e8f2ff);
        padding: 24px;
        text-align: center;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin: 0 auto 16px;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        object-fit: cover;
    }

    .user-name {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .user-username {
        font-size: 14px;
        color: #8e8e8e;
        font-weight: 500;
    }

    .user-card-body {
        padding: 20px 24px;
    }

    .user-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        font-size: 14px;
        color: #4a4a4a;
    }

    .user-info-icon {
        width: 20px;
        text-align: center;
    }

    .user-card-footer {
        padding: 16px 24px;
        background: #fafafa;
        border-top: 2px solid #f0f0f0;
        display: flex;
        gap: 10px;
    }

    .btn-profile {
        flex: 1;
        background: white;
        color: #4a90e2;
        border: 2px solid #4a90e2;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-profile:hover {
        background: #4a90e2;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .btn-unfollow {
        flex: 1;
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-unfollow:hover {
        background: linear-gradient(135deg, #c0392b, #a93226);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 80px 40px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .empty-icon {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.4;
    }

    .empty-title {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .empty-text {
        font-size: 15px;
        color: #8e8e8e;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .notification-wrapper {
            padding: 0 30px;
        }

        .users-list {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 992px) {
        .notification-wrapper {
            padding: 0 20px;
        }

        .sidebar-card {
            position: static;
            margin-bottom: 20px;
        }

        .users-list {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .notification-container {
            padding: 15px 0;
        }

        .notification-wrapper {
            padding: 0 15px;
        }

        .page-title {
            font-size: 24px;
        }

        .users-list {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .user-card-footer {
            flex-direction: column;
        }

        .btn-profile,
        .btn-unfollow {
            width: 100%;
        }
    }

    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .user-card {
        animation: slideIn 0.5s ease;
    }
</style>

<div class="notification-container">
    <div class="notification-wrapper">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="sidebar-card">
                    <h5 class="sidebar-title">Riwayat Aktivitas</h5>
                    
                    <div class="nav-list">
                        <!-- Notifikasi -->
                        <a href="{{ route('user.riwayat.postingan') }}" class="nav-item">
                            <div class="nav-icon">
                                🔔
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Notifikasi</span>
                                <span class="nav-desc">Postingan dibanned</span>
                            </div>
                            @if(isset($totalPosts) && $totalPosts > 0)
                                <span class="nav-badge">{{ $totalPosts }}</span>
                            @endif
                        </a>

                        <!-- Komentar -->
                        <a href="{{ route('user.riwayat.komentar') }}" class="nav-item">
                            <div class="nav-icon">
                                💬
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Komentar</span>
                                <span class="nav-desc">Riwayat komentar</span>
                            </div>
                            @if(isset($totalComments) && $totalComments > 0)
                                <span class="nav-badge">{{ $totalComments }}</span>
                            @endif
                        </a>

                        <!-- Menyukai -->
                        <a href="{{ route('user.riwayat.like') }}" class="nav-item">
                            <div class="nav-icon">
                                ❤️
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Menyukai</span>
                                <span class="nav-desc">Postingan disukai</span>
                            </div>
                            @if($totalLikes > 0)
                                <span class="nav-badge">{{ $totalLikes }}</span>
                            @endif
                        </a>

                        <!-- Diikuti (Active) -->
                        <a href="{{ route('user.riwayat.diikuti') }}" class="nav-item active">
                            <div class="nav-icon">
                                👥
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Pengikut</span>
                                <span class="nav-desc">Pengguna yang diikuti</span>
                            </div>
                            @if($totalFollowing > 0)
                                <span class="nav-badge">{{ $totalFollowing }}</span>
                            @endif
                        </a>
                        
                        <!-- Mengikuti -->
                        <a href="{{ route('user.riwayat.mengikuti') }}" class="nav-item">
                            <div class="nav-icon">
                                👤
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Mengikuti</span>
                                <span class="nav-desc">Pengguna yang mengikuti</span>
                            </div>
                            @if($totalFollowers > 0)
                                <span class="nav-badge">{{ $totalFollowers }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="main-content">
                    <div class="page-header">
                        <h2 class="page-title">
                            Riwayat Diikuti
                        </h2>
                        <p class="page-subtitle">Lihat semua pengikut anda.</p>
                    </div>

                    @if($followedUsers->count() > 0)
                        <div class="users-list">
                            @foreach($followedUsers as $follow)
                                <div class="user-card">
                                    <div class="user-card-header">
                                        <a href="{{ route('user.profile.username', ['name' => $follow->follower->name]) }}">
                                            <img src="{{ $follow->follower->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                                alt="{{ $follow->follower->name }}" 
                                                class="user-avatar">
                                        </a>
                                        <a href="{{ route('user.profile.username', ['name' => $follow->follower->name]) }}">
                                            <h6 class="user-name">{{ $follow->follower->name }}</h6>
                                        </a>
                                        <p class="user-username">{{ '@' . $follow->follower->name }}</p>
                                    </div>

                                    <div class="user-card-body">
                                        <div class="user-info-item">
                                            <span class="user-info-icon">📅</span>
                                            <span>Diikuti sejak {{ $follow->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">👥</div>
                            <h3 class="empty-title">Belum Ada yang Diikuti</h3>
                            <p class="empty-text">Anda belum diikuti siapa pun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection