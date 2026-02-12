@extends('layouts.index2')

@section('content')
<style>
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Nav Badge */
    .nav-badge {
        background: #e74c3c;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        margin-left: auto;
    }

    /* Container */
    .comment-container {
        background: #fafafa;
        min-height: calc(100vh - 60px);
        padding: 20px 0;
        margin-top: -20px;
    }

    .comment-wrapper {
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
        font-size: 18px;
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

    /* Main Content */
    .main-content {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 2px solid #f0f0f0;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        color: #666;
        font-size: 15px;
        margin: 0;
    }

    /* Split Layout */
    .split-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .split-section {
        background: #fafafa;
        border-radius: 16px;
        padding: 20px;
        border: 2px solid #f0f0f0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e0e0e0;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 18px;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0;
    }

    .section-count {
        margin-left: auto;
        background: linear-gradient(135deg, #4a90e2, #357abd);
        color: white;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 700;
    }

    /* Comment List */
    .comments-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 600px;
        overflow-y: auto;
        padding-right: 8px;
    }

    /* Scrollbar */
    .comments-list::-webkit-scrollbar {
        width: 6px;
    }

    .comments-list::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .comments-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .comments-list::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    /* Comment Item */
    .comment-item {
        background: white;
        border-radius: 12px;
        padding: 14px 16px;
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
        position: relative;
    }

    .comment-item:hover {
        border-color: #4a90e2;
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.15);
    }

    .comment-item.banned-item {
        border-color: #ffcccc;
        background: #fff9f9;
    }

    .comment-item.banned-item:hover {
        border-color: #e74c3c;
    }

    /* Comment Header */
    .comment-item-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-badge.active {
        background: linear-gradient(135deg, #27ae60, #229954);
        color: white;
    }

    .status-badge.banned {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .comment-post-ref {
        font-size: 12px;
        color: #666;
        flex: 1;
    }

    .comment-time {
        font-size: 11px;
        color: #999;
    }

    /* Comment Text */
    .comment-text {
        font-size: 14px;
        color: #333;
        line-height: 1.5;
        margin-bottom: 10px;
        padding: 10px;
        background: #f8f8f8;
        border-radius: 8px;
        border-left: 3px solid #4a90e2;
    }

    .comment-item.banned-item .comment-text {
        border-left-color: #e74c3c;
    }

    /* Ban Info (untuk komentar yang di-ban) */
    .ban-info {
        background: #fff0f0;
        border: 1px solid #ffcccc;
        border-radius: 8px;
        padding: 10px 12px;
        margin-top: 10px;
        font-size: 12px;
    }

    .ban-info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .ban-info-row:last-child {
        margin-bottom: 0;
    }

    .ban-info-label {
        font-weight: 700;
        color: #666;
    }

    .ban-info-value {
        color: #e74c3c;
        font-weight: 600;
    }

    /* Comment Actions */
    .comment-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #f0f0f0;
    }

    .delete-comment-btn {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(231, 76, 60, 0.3);
    }

    .delete-comment-btn:hover {
        background: linear-gradient(135deg, #c0392b, #a93226);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(231, 76, 60, 0.4);
    }

    .delete-comment-btn:active {
        transform: translateY(0);
    }

    /* Reply Indicator */
    .reply-indicator {
        background: #e3f2fd;
        border-left: 3px solid #2196f3;
        padding: 6px 10px;
        border-radius: 6px;
        margin-top: 8px;
        font-size: 11px;
        color: #1976d2;
    }

    .reply-label {
        font-weight: 700;
        display: block;
        margin-bottom: 2px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: white;
        border-radius: 12px;
        border: 2px dashed #e0e0e0;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.4;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .empty-text {
        color: #888;
        font-size: 13px;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .split-container {
            grid-template-columns: 1fr;
        }

        .comment-wrapper {
            padding: 0 20px;
        }

        .main-content {
            padding: 24px 20px;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 24px;
        }

        .section-title {
            font-size: 14px;
        }

        .comment-item-header {
            flex-wrap: wrap;
        }
    }
</style>

<div class="comment-container">
    <div class="comment-wrapper">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar-card">
                    <h2 class="sidebar-title">Riwayat Aktivitas</h2>
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

                        <!-- Komentar (Active) -->
                        <a href="{{ route('user.riwayat.komentar') }}" class="nav-item active">
                            <div class="nav-icon">💬</div>
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
                                <span class="nav-badge">{{ $totalLikes ?? '-'}}</span>
                            @endif
                        </a>

                        <a href="{{ route('user.riwayat.diikuti') }}" class="nav-item">
                            <div class="nav-icon">
                                👥
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Pengikut</span>
                                <span class="nav-desc">Pengguna yang diikuti</span>
                            </div>
                            @if($totalFollowers > 0)
                                <span class="nav-badge">{{ $totalFollowers ?? '-'}}</span>
                            @endif
                        </a>
                        
                        <a href="{{ route('user.riwayat.mengikuti') }}" class="nav-item">
                            <div class="nav-icon">
                                👤
                            </div>
                            <div class="nav-content">
                                <span class="nav-label">Mengikuti</span>
                                <span class="nav-desc">Pengguna yang mengikuti</span>
                            </div>
                            @if($totalFollowing > 0)
                                <span class="nav-badge">{{ $totalFollowing ?? '-'}}</span>
                            @endif
                            
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="main-content">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-title">Riwayat Komentar</h1>
                        <p class="page-subtitle">Lihat semua komentar Anda dan komentar yang telah di-ban</p>
                    </div>

                    <!-- Split Layout -->
                    <div class="split-container">
                        <!-- Left: Riwayat Komentar Aktif -->
                        <div class="split-section">
                            <div class="section-header">
                                <div class="section-icon">📝</div>
                                <h3 class="section-title">Komentar Aktif</h3>
                                <span class="section-count">{{ $activeComments->count() }}</span>
                            </div>

                            <div class="comments-list">
                                @forelse($activeComments as $comment)
                                    <div class="comment-item">
                                        <div class="comment-item-header">
                                            <span class="status-badge active">Aktif</span>
                                            <span class="comment-post-ref">
                                                {{ Str::limit($comment->post->caption ?? 'Post', 25) }}
                                            </span>
                                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>

                                        <div class="comment-text">{{ $comment->comment }}</div>

                                        @if($comment->reply_id)
                                            <div class="reply-indicator">
                                                <span class="reply-label">↩️ Balasan:</span>
                                                {{ Str::limit($comment->parent->comment ?? '', 40) }}
                                            </div>
                                        @endif

                                        @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                            <div class="comment-actions">
                                                <button type="button" 
                                                        class="delete-comment-btn" 
                                                        data-id="{{ $comment->id }}"
                                                        data-url="{{ route('user.comments.destroy', $comment->id) }}"
                                                        onclick="deleteComment(this)">
                                                    Hapus
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        <div class="empty-icon">💭</div>
                                        <h5 class="empty-title">Belum Ada Komentar</h5>
                                        <p class="empty-text">Anda belum membuat komentar</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Right: Komentar Di-ban -->
                        <div class="split-section">
                            <div class="section-header">
                                <div class="section-icon">⛔</div>
                                <h3 class="section-title">Komentar Di-ban</h3>
                                <span class="section-count">{{ $bannedComments->count() }}</span>
                            </div>

                            <div class="comments-list">
                                @forelse($bannedComments as $comment)
                                    <div class="comment-item banned-item">
                                        <div class="comment-item-header">
                                            <span class="status-badge banned">Banned</span>
                                            <span class="comment-post-ref">
                                                {{ Str::limit($comment->post->caption ?? 'Post', 25) }}
                                            </span>
                                            <span class="comment-time">{{ $comment->bans->first()->created_at->diffForHumans() }}</span>
                                        </div>

                                        <div class="comment-text">{{ $comment->comment }}</div>

                                        <div class="ban-info">
                                            <div class="ban-info-row">
                                                <span class="ban-info-label">Alasan:</span>
                                                <span class="ban-info-value">{{ $comment->bans->first()->reason }}</span>
                                            </div>
                                            @if($comment->bans->first()->notes)
                                                <div class="ban-info-row">
                                                    <span class="ban-info-label">Catatan:</span>
                                                    <span class="ban-info-value">{{ $comment->bans->first()->notes }}</span>
                                                </div>
                                            @endif
                                            <div class="ban-info-row">
                                                <span class="ban-info-label">Admin:</span>
                                                <span class="ban-info-value">{{ $comment->bans->first()->admin->name }}</span>
                                            </div>
                                        </div>

                                        @if($comment->reply_id)
                                            <div class="reply-indicator">
                                                <span class="reply-label">↩️ Balasan:</span>
                                                {{ Str::limit($comment->parent->comment ?? '', 40) }}
                                            </div>
                                        @endif

                                        @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                            <div class="comment-actions">
                                                <button type="button" 
                                                        class="delete-comment-btn" 
                                                        data-id="{{ $comment->id }}"
                                                        data-url="{{ route('user.comments.destroy', $comment->id) }}"
                                                        onclick="deleteComment(this)">
                                                    Hapus
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <h5 class="empty-title">Tidak Ada Ban</h5>
                                        <p class="empty-text">Tidak ada komentar yang di-ban</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteComment(button) {
    const commentId = button.getAttribute('data-id');
    const deleteUrl = button.getAttribute('data-url');
    
    if (confirm('⚠️ Apakah Anda yakin ingin menghapus komentar ini?')) {
        // Create form untuk DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }
        
        // Method DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Append form ke body dan submit
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection