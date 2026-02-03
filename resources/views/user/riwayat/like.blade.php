@extends('layouts.index2')

@section('content')
<style>
    /* Existing styles... */
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

    /* Main Content */
    .main-content {
        flex: 1;
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

    /* Notification Cards */
    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .notification-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .notification-card:hover {
        border-color: #e74c3c;
        box-shadow: 0 8px 24px rgba(231, 76, 60, 0.15);
    }

    /* Card Header */
    .card-header-custom {
        background: linear-gradient(135deg, #fff0f0, #ffe8e8);
        padding: 20px 24px;
        border-bottom: 2px solid #ffe0e0;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .header-text h6 {
        font-size: 16px;
        font-weight: 700;
        color: #e74c3c;
        margin: 0 0 4px 0;
    }

    .header-text small {
        font-size: 13px;
        color: #8e8e8e;
        font-weight: 500;
    }

    /* Card Body */
    .card-body-custom {
        padding: 24px;
    }

    .post-preview-section {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 24px;
        align-items: start;
    }

    /* Post Image */
    .post-image-wrapper {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 1;
        background: #f0f0f0;
    }

    .post-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-count-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(10px);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Ban Details */
    .ban-details {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 700;
        color: #8e8e8e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: #262626;
        line-height: 1.5;
    }

    .detail-value.danger {
        color: #e74c3c;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-value.muted {
        color: #666;
        font-style: italic;
    }

    .admin-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .badge-role {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Card Footer */
    .card-footer-custom {
        padding: 16px 24px;
        background: #fafafa;
        border-top: 2px solid #f0f0f0;
        text-align: right;
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

    /* Modal Styles */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .modal-header {
        padding: 24px 28px;
        border-bottom: 2px solid #f0f0f0;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 800;
        color: #1a1a1a;
    }

    .modal-body {
        padding: 28px;
    }

    .modal-photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }

    .modal-photo-item {
        aspect-ratio: 1;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #e8e8e8;
    }

    .modal-photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-section {
        margin-bottom: 24px;
    }

    .modal-section-label {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .modal-caption-box {
        background: #fafafa;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid #e8e8e8;
    }

    .modal-caption-box p {
        margin: 0;
        color: #262626;
        line-height: 1.6;
        font-size: 15px;
    }

    .ban-info-alert {
        background: linear-gradient(135deg, #fff0f0, #ffe8e8);
        border: 2px solid #ffcccc;
        border-radius: 16px;
        padding: 20px;
    }

    .ban-info-title {
        font-size: 16px;
        font-weight: 700;
        color: #e74c3c;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ban-info-item {
        margin-bottom: 12px;
        font-size: 14px;
    }

    .ban-info-item:last-child {
        margin-bottom: 0;
    }

    .ban-info-item strong {
        color: #1a1a1a;
        font-weight: 700;
    }

    .modal-footer {
        padding: 20px 28px;
        border-top: 2px solid #f0f0f0;
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

        .post-preview-section {
            grid-template-columns: 160px 1fr;
            gap: 20px;
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

        .post-preview-section {
            grid-template-columns: 1fr;
        }

        .post-image-wrapper {
            max-width: 300px;
            margin: 0 auto;
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

        .card-header-custom {
            padding: 16px 20px;
        }

        .card-body-custom {
            padding: 20px;
        }

        .modal-photos-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 20px;
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-card {
            border-radius: 16px;
        }

        .card-footer-custom {
            text-align: center;
        }

        .btn-detail {
            width: 100%;
            justify-content: center;
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

    .notification-card {
        animation: slideIn 0.5s ease;
    }
    /* Like Button & Count */
    .post-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 12px;
    }

    .modal-action-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        transition: transform 0.2s ease;
        padding: 4px 8px;
    }

    .modal-action-btn:hover {
        transform: scale(1.2);
    }

    .modal-action-btn:active {
        transform: scale(0.9);
    }

    .like-count {
        font-size: 14px;
        font-weight: 600;
        color: #262626;
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
                            <div class="nav-icon">🔔</div>
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
                            <div class="nav-icon">💬</div>
                            <div class="nav-content">
                                <span class="nav-label">Komentar</span>
                                <span class="nav-desc">Riwayat komentar</span>
                            </div>
                            @if(isset($totalComments) && $totalComments > 0)
                                <span class="nav-badge">{{ $totalComments }}</span>
                            @endif
                        </a>

                        <!-- Menyukai (Active) -->
                        <a href="{{ route('user.riwayat.like') }}" class="nav-item active">
                            <div class="nav-icon">❤️</div>
                            <div class="nav-content">
                                <span class="nav-label">Menyukai</span>
                                <span class="nav-desc">Postingan disukai</span>
                            </div>
                            @if($totalLikes > 0)
                                <span class="nav-badge">{{ $totalLikes }}</span>
                            @endif
                        </a>

                        <!-- Diikuti -->
                        <a href="{{ route('user.riwayat.diikuti') }}" class="nav-item">
                            <div class="nav-icon">👥</div>
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
                            <div class="nav-icon">👤</div>
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
                            Riwayat Menyukai
                        </h2>
                        <p class="page-subtitle">Lihat postingan yang telah Anda sukai.</p>
                    </div>

                    @if($likesPhotos->count() > 0)
                    <div class="notifications-list">
                        @foreach($likesPhotos as $like)
                            @if($like->photo) {{-- Tambahkan pengecekan ini --}}
                                <div class="notification-card">
                                    <!-- Card Header -->
                                    <div class="card-header-custom">
                                        <div class="header-text">
                                            <h6>Postingan Disukai</h6>
                                            <small>{{ $like->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>

                                    <!-- Card Body -->
                                    <div class="card-body-custom">
                                        <div class="post-preview-section">
                                            <!-- Post Image -->
                                            <div class="post-image-wrapper">
                                                @if($like->photo->photo)
                                                    <img src="{{ asset('storage/' . $like->photo->photo) }}" 
                                                        alt="Post Image">
                                                @else
                                                    <img src="{{ asset('images/default-post.jpg') }}" 
                                                        alt="Default Image">
                                                @endif
                                            </div>

                                            <!-- Post Details -->
                                            <div class="post-details">
                                                <!-- Pemilik Postingan -->
                                                <div class="detail-item">
                                                    <span class="detail-label">Pemilik Postingan</span>
                                                    <div class="user-info">
                                                        @if($like->photo->user)
                                                            @if($like->profile->user)
                                                                <img src="{{ $likw->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                                                    alt="{{ $like->photo->user->name }}" 
                                                                    class="user-avatar">
                                                            @else
                                                                <img src="{{ asset('images/default-avatar.png') }}" 
                                                                    alt="Default Avatar" 
                                                                    class="user-avatar">
                                                            @endif
                                                            <span class="username">{{ $like->photo->user->name }}</span>
                                                        @else
                                                            <span class="detail-value muted">Pengguna tidak ditemukan</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Caption -->
                                                <div class="detail-item">
                                                    <span class="detail-label">Caption</span>
                                                    <p class="detail-value">
                                                        {{ $like->post->bio ?? 'Tidak ada caption' }}
                                                    </p>
                                                </div>

                                                <!-- Tanggal Disukai -->
                                                <div class="detail-item">
                                                    <span class="detail-label">Disukai Pada</span>
                                                    <p class="detail-value">
                                                        {{ $like->created_at->format('d M Y') }}
                                                    </p>
                                                </div>

                                                <!-- Like Actions -->
                                                <div class="post-actions">
                                                    <button type="button" 
                                                            class="modal-action-btn" 
                                                            data-post-id="{{ $like->photo->id }}" 
                                                            data-liked="{{ $like->photo->isLikedBy(auth()->id()) ? '1' : '0' }}">
                                                        {{ $like->photo->isLikedBy(auth()->id()) ? '❤️' : '🤍' }}
                                                    </button>
                                                    <span class="like-count" data-post-id="{{ $like->photo->id }}">
                                                        {{ $like->photo->likesCount() }}
                                                    </span>
                                                    <span style="font-size: 14px; color: #8e8e8e;">suka</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif {{-- Tutup pengecekan --}}
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">❤️</div>
                        <h3 class="empty-title">Belum Ada Postingan Disukai</h3>
                        <p class="empty-text">Anda belum menyukai postingan apapun.</p>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Like Button -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal-action-btn').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;

            fetch(`{{ route('user.post.like', ':id') }}`.replace(':id', postId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Ganti icon
                this.innerHTML = data.liked ? '❤️' : '🤍';
                this.dataset.liked = data.liked ? '1' : '0';

                // Update jumlah like
                const countEl = document.querySelector(
                    `.like-count[data-post-id="${postId}"]`
                );

                if (countEl) {
                    countEl.textContent = data.total;
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>

@endsection