@extends('layouts.index')

@section('content')

<div class="container-fluid px-4 py-4 mt-4">

    {{-- HEADER --}}
    <div class="header-section mb-4">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h2 class="page-title mb-0">
                    <span class="icon-wrapper">📸</span>
                    Kelola Postingan
                </h2>
                <p class="text-muted small mb-0">Total {{ $totalPosts ?? 0 }} postingan</p>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.user.posts') }}" class="search-form">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control border-start-0 ps-0"
                               placeholder="Cari berdasarkan caption atau username..."
                               value="{{ $search ?? '' }}">
                        @if($search ?? false)
                            <a href="{{ route('admin.user.posts') }}" class="btn btn-outline-secondary">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="filter-tabs mb-4">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="filter" id="filterAll" checked>
            <label class="btn btn-outline-primary" for="filterAll" data-filter="all">
                Semua
            </label>

            <input type="radio" class="btn-check" name="filter" id="filterActive">
            <label class="btn btn-outline-success" for="filterActive" data-filter="active">
                Aktif
            </label>

            <input type="radio" class="btn-check" name="filter" id="filterBanned">
            <label class="btn btn-outline-danger" for="filterBanned" data-filter="banned">
                Banned
            </label>

            <input type="radio" class="btn-check" name="filter" id="filterRejected">
            <label class="btn btn-outline-warning" for="filterRejected" data-filter="rejected_ai">
                AI Reject
            </label>
        </div>
    </div>

    {{-- GRID POST --}}
    <div class="posts-grid" id="postsGrid">
        @forelse($posts as $post)
        <div class="post-item" data-status="{{ $post->status }}">
            <div class="post-card">
                
                {{-- Image Thumbnail --}}
                <div class="post-image" 
                     data-bs-toggle="modal" 
                     data-bs-target="#postModal{{ $post->id }}">
                    <img src="{{ asset('storage/'.$post->photos->first()->photo) }}" 
                         alt="Post image"
                         loading="lazy">
                    
                    @if($post->photos->count() > 1)
                        <div class="photo-count">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                            </svg>
                            {{ $post->photos->count() }}
                        </div>
                    @endif

                    <div class="post-overlay">
                        <div class="overlay-stats">
                            <span>
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                </svg>
                                {{ $post->likes->count() }}
                            </span>
                            <span>
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                </svg>
                                {{ $post->comments->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Post Info --}}
                <div class="post-info">
                    <div class="user-info">
                        <img src="{{ $post->user->avatar_display ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&size=32' }}" 
                             alt="{{ $post->user->name }}"
                             class="user-avatar">
                        <span class="user-name">{{ $post->user->name }}</span>
                    </div>

                    <p class="post-caption">{{ Str::limit($post->caption, 40) }}</p>

                    <div class="post-footer">
                        <span class="post-time">{{ $post->created_at->diffForHumans() }}</span>
                        
                        @if($post->status === 'banned')
                            <span class="status-badge status-banned">Banned</span>
                        @elseif($post->status === 'rejected_ai')
                            <span class="status-badge status-rejected">AI Reject</span>
                        @else
                            <span class="status-badge status-active">Aktif</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= MODAL DETAIL POST ================= --}}
        <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content modal-modern">
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </button>

                    <div class="modal-body p-0">
                        <div class="row g-0">
                            
                            {{-- Photos Section --}}
                            <div class="col-lg-8 modal-photos">
                                @if($post->photos->count() > 1)
                                    <div id="carousel{{ $post->id }}" class="carousel slide h-100">
                                        <div class="carousel-inner h-100">
                                            @foreach($post->photos as $index => $photo)
                                                <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/'.$photo->photo) }}" 
                                                         class="d-block w-100 h-100" 
                                                         style="object-fit: contain;">
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        @if($post->photos->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $post->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $post->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        @endif

                                        <div class="carousel-indicators">
                                            @foreach($post->photos as $index => $photo)
                                                <button type="button" 
                                                        data-bs-target="#carousel{{ $post->id }}" 
                                                        data-bs-slide-to="{{ $index }}" 
                                                        class="{{ $index === 0 ? 'active' : '' }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/'.$post->photos->first()->photo) }}" 
                                         class="w-100 h-100" 
                                         style="object-fit: contain;">
                                @endif
                            </div>

                            {{-- Details Section --}}
                            <div class="col-lg-4 modal-details">
                                <div class="details-content">
                                    
                                    {{-- User Header --}}
                                    <div class="detail-header">
                                        <img src="{{ $post->user->avatar_display ?? 'https://ui-avatars.com/api/?name='.urlencode($post->user->name).'&size=48' }}" 
                                             alt="{{ $post->user->name }}"
                                             class="detail-avatar">
                                        <div class="detail-user-info">
                                            <strong class="detail-username">{{ $post->user->name }}</strong>
                                            <small class="detail-email">{{ $post->user->email }}</small>
                                        </div>
                                    </div>

                                    {{-- Caption --}}
                                    <div class="detail-caption">
                                        <p>{{ $post->caption }}</p>
                                    </div>

                                    {{-- Stats --}}
                                    <div class="detail-stats">
                                        <div class="stat-item">
                                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                            </svg>
                                            <span>{{ $post->likes->count() }} likes</span>
                                        </div>
                                        <div class="stat-item">
                                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                            </svg>
                                            <span>{{ $post->comments->count() }} komentar</span>
                                        </div>
                                    </div>

                                    <div class="detail-time">
                                        {{ $post->created_at->format('d M Y, H:i') }}
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="detail-actions">
                                        @if($post->status !== 'banned')
                                            <button class="btn btn-danger-modern w-100"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#banModal{{ $post->id }}">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M11.354 4.646a.5.5 0 0 0-.708 0l-6 6a.5.5 0 0 0 .708.708l6-6a.5.5 0 0 0 0-.708z"/>
                                                </svg>
                                                Ban Postingan
                                            </button>
                                        @else
                                            <div class="alert alert-danger mb-0">
                                                <strong>Postingan Sudah Dibanned</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= MODAL BAN ================= --}}
        <div class="modal fade" id="banModal{{ $post->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form method="POST" 
                      action="{{ route('admin.post.ban', $post->id) }}" 
                      class="modal-content modal-modern">
                    @csrf
                    @method('PATCH')
                    
                    <div class="modal-header border-0">
                        <h5 class="modal-title">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16" class="text-danger">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M11.354 4.646a.5.5 0 0 0-.708 0l-6 6a.5.5 0 0 0 .708.708l6-6a.5.5 0 0 0 0-.708z"/>
                            </svg>
                            Ban Postingan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan Ban <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="reason" 
                                   class="form-control" 
                                   placeholder="Contoh: Konten tidak pantas"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="notes" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Tambahan informasi (opsional)"></textarea>
                        </div>

                        <div class="alert alert-warning">
                            <small>
                                <strong>⚠️ Perhatian:</strong> Tindakan ini akan memban postingan dan user tidak akan dapat melihatnya lagi.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Ya, Ban Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @empty
        <div class="col-12">
            <div class="empty-state">
                <svg width="64" height="64" fill="currentColor" viewBox="0 0 16 16" class="mb-3 text-muted">
                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                    <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                </svg>
                <h5>Tidak Ada Postingan</h5>
                <p class="text-muted">Belum ada postingan yang tersedia saat ini</p>
            </div>
        </div>
        @endforelse
    </div>



</div>

<style>
    :root {
        --primary-color: #0d6efd;
        --success-color: #198754;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --dark-color: #212529;
        --light-color: #f8f9fa;
        --border-radius: 12px;
        --transition: all 0.3s ease;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.16);
    }

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.icon-wrapper {
    font-size: 2rem;
}

/* ============ SEARCH FORM ============ */
.search-form .input-group {
    box-shadow: var(--shadow-sm);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.search-form .form-control {
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
}

.search-form .form-control:focus {
    box-shadow: none;
    border-color: var(--primary-color);
}

.search-form .input-group-text {
    border: 1px solid #e0e0e0;
}

/* ============ FILTER TABS ============ */
.filter-tabs .btn-group {
    box-shadow: var(--shadow-sm);
    border-radius: var(--border-radius);
    overflow: hidden;
}

.filter-tabs .btn {
    padding: 0.6rem 1.5rem;
    font-weight: 500;
    border: none;
}

/* ============ POSTS GRID ============ */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

@media (max-width: 1200px) {
    .posts-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
}

@media (max-width: 480px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }
}

/* ============ POST CARD ============ */
.post-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.post-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-4px);
}

/* ============ POST IMAGE ============ */
.post-image {
    position: relative;
    aspect-ratio: 1;
    overflow: hidden;
    cursor: pointer;
    background: var(--light-color);
}

.post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.post-card:hover .post-image img {
    transform: scale(1.05);
}

.photo-count {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.75);
    color: white;
    padding: 3px 8px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 3px;
}

.photo-count svg {
    width: 12px;
    height: 12px;
}

/* ============ POST OVERLAY ============ */
.post-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
}

.post-card:hover .post-overlay {
    opacity: 1;
}

.overlay-stats {
    display: flex;
    gap: 1rem;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

.overlay-stats span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.overlay-stats svg {
    width: 18px;
    height: 18px;
}

/* ============ POST INFO ============ */
.post-info {
    padding: 0.75rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 0.5rem;
}

.user-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
}

.user-name {
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--dark-color);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.post-caption {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0.5rem;
    flex: 1;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.post-time {
    font-size: 0.75rem;
    color: #999;
}

/* ============ STATUS BADGES ============ */
.status-badge {
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-banned {
    background: #f8d7da;
    color: #721c24;
}

.status-rejected {
    background: #fff3cd;
    color: #856404;
}

/* ============ MODAL ============ */
.modal-modern .modal-content {
    border: none;
    border-radius: var(--border-radius);
    overflow: hidden;
}

.btn-close-modal {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
}

.btn-close-modal:hover {
    background: white;
    transform: rotate(90deg);
}

/* ============ MODAL PHOTOS ============ */
.modal-photos {
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    width: 40px;
    height: 40px;
}

.carousel-indicators {
    margin-bottom: 1rem;
}

.carousel-indicators button {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin: 0 4px;
}

/* ============ MODAL DETAILS ============ */
.modal-details {
    background: white;
    max-height: 600px;
    overflow-y: auto;
}

.details-content {
    padding: 2rem;
}

.detail-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e0e0e0;
}

.detail-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.detail-user-info {
    flex: 1;
}

.detail-username {
    display: block;
    font-size: 1rem;
    color: var(--dark-color);
}

.detail-email {
    display: block;
    color: #999;
    font-size: 0.85rem;
}

.detail-caption {
    margin-bottom: 1.5rem;
}

.detail-caption p {
    font-size: 0.95rem;
    line-height: 1.6;
    color: var(--dark-color);
}

.detail-stats {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e0e0e0;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    color: var(--dark-color);
}

.detail-time {
    font-size: 0.85rem;
    color: #999;
    margin-bottom: 1.5rem;
}

.detail-actions {
    margin-top: 2rem;
}

/* ============ BUTTONS ============ */
.btn-danger-modern {
    background: var(--danger-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: var(--transition);
}

.btn-danger-modern:hover {
    background: #bb2d3b;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* ============ EMPTY STATE ============ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* ============ PAGINATION ============ */
.pagination-wrapper {
    display: flex;
    justify-content: center;
}

/* ============ ANIMATIONS ============ */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.post-item {
    animation: fadeIn 0.5s ease-out;
}

/* ============ RESPONSIVE ============ */
@media (max-width: 991px) {
    .modal-photos {
        min-height: 300px;
    }
    
    .details-content {
        padding: 1.5rem;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .filter-tabs .btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    
    .post-info {
        padding: 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ========== FILTER FUNCTIONALITY ==========
    const filterButtons = document.querySelectorAll('[data-filter]');
    const postItems = document.querySelectorAll('.post-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            postItems.forEach(item => {
                const status = item.getAttribute('data-status');
                
                if (filter === 'all' || status === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // ========== CAROUSEL INITIALIZATION ==========
    const carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        new bootstrap.Carousel(carousel, {
            interval: false,
            wrap: true,
            touch: true
        });
    });

    // ========== PREVENT MODAL CLOSE ON CAROUSEL CLICK ==========
    document.querySelectorAll('.carousel-control-prev, .carousel-control-next').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });

    // ========== SMOOTH SCROLL TO TOP ==========
    window.addEventListener('scroll', function() {
        const scrollBtn = document.getElementById('scrollToTop');
        if (scrollBtn) {
            if (window.pageYOffset > 300) {
                scrollBtn.style.display = 'flex';
            } else {
                scrollBtn.style.display = 'none';
            }
        }
    });

    // ========== LAZY LOADING IMAGES ==========
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ========== SEARCH ENHANCEMENT ==========
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }
});
</script>

@endsection