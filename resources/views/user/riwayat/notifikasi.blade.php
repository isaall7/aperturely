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
</style>

<div class="notification-container">
    <div class="notification-wrapper">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="sidebar-card">
                    <h5 class="sidebar-title">Riwayat Aktivitas</h5>
                    
                    <div class="nav-list">
                        <!-- Notifikasi (Active) -->
                        <a href="{{ route('user.riwayat.notifikasi') }}" class="nav-item active">
                            <div class="nav-icon">
                                🔔
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Notifikasi</span>
                                <span class="nav-desc">Postingan dibanned</span>
                            </div>
                            @if($posts->count() > 0)
                                <span class="nav-badge">{{ $posts->count() }}</span>
                            @endif
                        </a>

                        <!-- Komentar -->
                        <a href="#" class="nav-item">
                            <div class="nav-icon">
                                💬
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Komentar</span>
                                <span class="nav-desc">Riwayat komentar</span>
                            </div>
                        </a>

                        <!-- Menyukai -->
                        <a href="#" class="nav-item">
                            <div class="nav-icon">
                                ❤️
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Menyukai</span>
                                <span class="nav-desc">Postingan disukai</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="main-content">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">
                            <span>Notifikasi Pelanggaran</span>
                        </h1>
                        <p class="page-subtitle">Postingan Anda yang telah dibanned oleh admin</p>
                    </div>

                    <!-- Notifications List -->
                    <div class="notifications-list">
                        @forelse($posts as $post)
                            <div class="notification-card">
                                <!-- Card Header -->
                                <div class="card-header-custom">
                                    <div class="header-icon">
                                        ⛔
                                    </div>
                                    <div class="header-text">
                                        <h6>Postingan Dibanned</h6>
                                        <small>{{ $post->bans->first()->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body-custom">
                                    <div class="post-preview-section">
                                        <!-- Post Image -->
                                        <div class="post-image-wrapper">
                                            <img src="{{ asset('storage/'.$post->photos->first()->photo) }}" alt="Post image">
                                            @if($post->photos->count() > 1)
                                                <div class="photo-count-badge">
                                                    <span>📸</span>
                                                    <span>{{ $post->photos->count() }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Ban Details -->
                                        <div class="ban-details">
                                            <!-- Caption -->
                                            <div class="detail-item">
                                                <div class="detail-label">Caption</div>
                                                <div class="detail-value">{{ Str::limit($post->caption, 100) }}</div>
                                            </div>

                                            <!-- Ban Reason -->
                                            <div class="detail-item">
                                                <div class="detail-label">Alasan Ban</div>
                                                <div class="detail-value">
                                                    <span>{{ $post->bans->first()->reason }}</span>
                                                </div>
                                            </div>

                                            <!-- Admin Notes -->
                                            @if($post->bans->first()->notes)
                                                <div class="detail-item">
                                                    <div class="detail-label">Catatan Admin</div>
                                                    <div class="detail-value">{{ $post->bans->first()->notes }}</div>
                                                </div>
                                            @endif

                                            <!-- Banned By -->
                                            <div class="detail-item">
                                                <div class="detail-label">Dibanned Oleh</div>
                                                <div class="detail-value">
                                                    <div class="admin-badge">
                                                        <strong>{{ $post->bans->first()->admin->name }} Baik</strong>
                                                        <!-- <span class="badge-role">Admin</span> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Date -->
                                            <div class="detail-item">
                                                <div class="detail-label">Tanggal</div>
                                                <div class="detail-value">{{ $post->bans->first()->created_at->format('d M Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer-custom" style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                                    <form action="{{ route('user.postingan.destroy', $post) }}" method="post" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete-post" type="submit" onclick="return confirm('⚠️ Apakah Anda yakin ingin menghapus postingan ini secara permanen?');">
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                    <button class="btn-detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $post->id }}">
                                        <span>Lihat Detail</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Detail Modal -->
                            <div class="modal fade" id="detailModal{{ $post->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pelanggaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- All Photos -->
                                            <div class="modal-section">
                                                <div class="modal-section-label">Foto Postingan</div>
                                                <div class="modal-photos-grid">
                                                    @foreach($post->photos as $photo)
                                                        <div class="modal-photo-item">
                                                            <img src="{{ asset('storage/'.$photo->photo) }}" alt="Post photo">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <!-- Caption -->
                                            <div class="modal-section">
                                                <div class="modal-section-label">Caption</div>
                                                <div class="modal-caption-box">
                                                    <p>{{ $post->caption ?? 'Tidak ada caption' }}</p>
                                                </div>
                                            </div>

                                            <!-- Ban Info -->
                                            <div class="modal-section">
                                                <div class="ban-info-alert">
                                                    <div class="ban-info-title">
                                                        <span>Informasi Ban</span>
                                                    </div>
                                                    <div class="ban-info-item">
                                                        <strong>Alasan:</strong> {{ $post->bans->first()->reason }}
                                                    </div>
                                                    @if($post->bans->first()->notes)
                                                        <div class="ban-info-item">
                                                            <strong>Catatan:</strong> {{ $post->bans->first()->notes }}
                                                        </div>
                                                    @endif
                                                    <div class="ban-info-item">
                                                        <strong>Dibanned oleh:</strong> {{ $post->bans->first()->admin->name }}
                                                    </div>
                                                    <div class="ban-info-item">
                                                        <strong>Tanggal:</strong> {{ $post->bans->first()->created_at->format('d M Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <form action="{{ route('user.postingan.destroy', $post) }}" method="post" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('⚠️ Apakah Anda yakin ingin menghapus postingan ini secara permanen?');">
                                                    Hapus Postingan
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <h5 class="empty-title">Tidak Ada Notifikasi</h5>
                                <p class="empty-text">Tidak ada postingan yang dibanned</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection