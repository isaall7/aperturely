@extends('layouts.index2')

@section('content')
<style>
    /* Preserve all dashboard styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Explore specific - Sidebar & Search */
    .explore-container {
        background: transparent;
        min-height: calc(100vh - 60px);
        padding: 15px 0;
    }

    .explore-sidebar {
        position: sticky;
        top: 80px;
        height: calc(100vh - 100px);
        overflow-y: auto;
    }

    .explore-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .explore-sidebar::-webkit-scrollbar-track {
        background: #f8f8f8;
    }

    .explore-sidebar::-webkit-scrollbar-thumb {
        background: #dbdbdb;
        border-radius: 10px;
    }

    .category-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .category-card-header {
        padding: 20px;
        border-bottom: 1px solid #efefef;
        font-weight: 700;
        font-size: 17px;
        color: #262626;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-item {
        border: none;
        padding: 14px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #262626;
        font-weight: 500;
    }

    .category-item:hover {
        background: #f8f8f8;
        padding-left: 25px;
    }

    .category-item.active {
        background: #5d87ff;
        color: white;
        font-weight: 600;
    }

    .search-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
        padding: 20px;
    }

    .search-input-wrapper {
        position: relative;
        width: 100%;
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #8e8e8e;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 14px 20px 14px 52px;
        border: 2px solid #efefef;
        border-radius: 28px;
        font-size: 15px;
        outline: none;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .search-input:focus {
        border-color: #5d87ff;
        background: white;
        box-shadow: 0 0 0 4px rgba(93, 135, 255, 0.1);
    }

    .search-btn {
        background: #5d87ff;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 28px;
        font-weight: 700;
        margin-left: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #4a7de8;
        transform: scale(1.05);
    }

    /* Feed Container - From Dashboard */
    .feed-container {
        background: transparent;
        min-height: calc(100vh - 60px);
        padding: 0;
    }

    /* Masonry Grid */
    .masonry-grid {
        column-count: 4;
        column-gap: 24px;
        padding: 0;
    }

    @media (max-width: 1400px) {
        .masonry-grid {
            column-count: 3;
        }
    }

    @media (max-width: 992px) {
        .masonry-grid {
            column-count: 2;
            column-gap: 16px;
        }
    }

    @media (max-width: 600px) {
        .masonry-grid {
            column-count: 1;
        }
    }

    /* Post Card - From Dashboard */
    .post-card {
        background: white;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        break-inside: avoid;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .post-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        transform: translateY(-4px);
    }

    .post-image-container {
        position: relative;
        width: 100%;
        background: #f8f8f8;
        overflow: hidden;
    }

    .post-image-container img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 20px 20px 0 0;
        transition: transform 0.4s ease;
    }

    .post-card:hover .post-image-container img {
        transform: scale(1.05);
    }

    /* Post Info */
    .post-info {
        padding: 16px 18px;
    }

    .post-user {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        border-color: #5d87ff;
        transform: scale(1.1);
    }

    .user-name {
        font-size: 14px;
        color: #262626;
        font-weight: 600;
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .user-name:hover {
        color: #5d87ff;
    }

    .post-caption {
        font-size: 15px;
        color: #262626;
        margin-bottom: 12px;
        font-weight: 500;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .post-stats {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: #8e8e8e;
        margin-top: 10px;
        font-weight: 500;
    }

    .post-stats span {
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.3s ease;
    }

    .post-stats span:hover {
        color: #262626;
    }

    /* Modal - From Dashboard */
    .detail-modal .modal-dialog {
        max-width: 1200px;
        height: 92vh;
        margin: 4vh auto;
    }

    .detail-modal .modal-content {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
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
        flex: 1.5;
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
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
    }

    .modal-carousel .carousel-control-prev:hover,
    .modal-carousel .carousel-control-next:hover {
        background: white;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }

    .modal-carousel .carousel-control-prev {
        left: 24px;
    }

    .modal-carousel .carousel-control-next {
        right: 24px;
    }

    .modal-carousel .carousel-control-prev-icon,
    .modal-carousel .carousel-control-next-icon {
        width: 28px;
        height: 28px;
        filter: invert(1);
    }

    .modal-carousel .carousel-indicators {
        bottom: 24px;
    }

    .modal-carousel .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.6);
        border: none;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .modal-carousel .carousel-indicators button.active {
        background-color: #fff;
        transform: scale(1.3);
    }

    /* Modal Details Section */
    .modal-details-section {
        width: 480px;
        background: white;
        display: flex;
        flex-direction: column;
        border-left: 1px solid #efefef;
    }

    .modal-header-custom {
        padding: 24px;
        border-bottom: 1px solid #efefef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-actions {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .modal-action-btn {
        background: #f8f8f8;
        border: none;
        cursor: pointer;
        font-size: 26px;
        padding: 10px;
        border-radius: 50%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-action-btn:hover {
        background: #e8e8e8;
        transform: scale(1.1) rotate(5deg);
    }

    .modal-save-btn {
        background: linear-gradient(135deg, #e60023, #c4001d);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 28px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(230, 0, 35, 0.3);
    }

    .modal-save-btn:hover {
        background: linear-gradient(135deg, #ff0a37, #e60023);
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(230, 0, 35, 0.4);
    }

    .modal-user-section {
        padding: 24px;
        border-bottom: 1px solid #efefef;
    }

    .modal-user-info {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }

    .modal-user-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .modal-user-avatar:hover {
        border-color: #5d87ff;
        transform: scale(1.05);
    }

    .modal-user-details h6 {
        margin: 0;
        font-weight: 700;
        color: #262626;
        font-size: 17px;
        transition: color 0.3s ease;
    }

    .modal-user-details h6 a:hover {
        color: #5d87ff;
    }

    .modal-user-details span {
        font-size: 14px;
        color: #8e8e8e;
    }

    .modal-caption {
        font-size: 15px;
        color: #262626;
        line-height: 1.6;
        margin-bottom: 14px;
    }

    .modal-stats {
        display: flex;
        gap: 24px;
        font-size: 15px;
        color: #8e8e8e;
        font-weight: 600;
    }

    .modal-stats span {
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
    }

    .modal-stats span:hover {
        color: #262626;
    }

    /* Comments Section */
    .modal-comments-section {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
    }

    .comment-item {
        display: flex;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f5f5f5;
    }

    .comment-item:last-child {
        border-bottom: none;
    }

    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #f0f0f0;
    }

    .comment-content {
        flex: 1;
    }

    .comment-avatar-link {
        display: block;
        line-height: 0;
        transition: opacity 0.2s ease;
    }

    .comment-avatar-link:hover {
        opacity: 0.7;
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
        font-weight: 700;
        color: #262626;
        font-size: 15px;
        margin-right: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .comment-text {
        color: #262626;
        font-size: 15px;
        line-height: 1.5;
    }

    .comment-actions {
        display: flex;
        gap: 20px;
        margin-top: 10px;
        font-size: 13px;
        color: #8e8e8e;
        font-weight: 600;
    }

    .comment-actions button {
        background: none;
        border: none;
        color: #8e8e8e;
        cursor: pointer;
        padding: 0;
        font-weight: 600;
        font-size: 13px;
        transition: color 0.3s ease;
    }

    .comment-actions button:hover {
        color: #262626;
    }

    .replies-container {
        margin-left: 52px;
        margin-top: 12px;
        padding-left: 12px;
        border-left: 2px solid #efefef;
    }

    /* Comment Input */
    .modal-comment-input-section {
        padding: 24px;
        border-top: 1px solid #efefef;
    }

    .modal-comment-input {
        display: flex;
        gap: 14px;
        align-items: center;
    }

    .modal-comment-input input {
        flex: 1;
        border: 2px solid #efefef;
        border-radius: 28px;
        padding: 14px 24px;
        outline: none;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .modal-comment-input input:focus {
        border-color: #5d87ff;
        background: white;
        box-shadow: 0 0 0 4px rgba(93, 135, 255, 0.1);
    }

    .modal-comment-input button {
        background: #5d87ff;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 28px;
        font-weight: 700;
        cursor: pointer;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-comment-input button:hover:not(:disabled) {
        background: #4a7de8;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.3);
    }

    .modal-comment-input button:disabled {
        background: #dbdbdb;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .reply-info {
        padding: 8px 12px;
        background: #f0f7ff;
        border-radius: 8px;
        margin-top: 8px;
        display: none;
    }

    .reply-info small {
        color: #5d87ff;
        font-weight: 600;
    }

    .cancel-reply {
        background: none;
        border: none;
        color: #8e8e8e;
        cursor: pointer;
        margin-left: 10px;
        font-size: 14px;
    }

    .cancel-reply:hover {
        color: #262626;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        border-radius: 16px;
        padding: 10px;
        min-width: 220px;
        margin-top: 8px;
    }

    .dropdown-item {
        padding: 12px 18px;
        font-size: 15px;
        color: #262626;
        transition: all 0.2s ease;
        border-radius: 10px;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background: #f0f7ff;
        color: #5d87ff;
        transform: translateX(4px);
    }

    .dropdown-item.text-danger:hover {
        background: #fff0f0;
        color: #e74c3c;
    }

    /* Report Modal */
    .report-modal .modal-dialog {
        max-width: 560px;
    }

    .report-modal .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .report-modal .modal-header {
        border-bottom: 1px solid #f0f0f0;
        padding: 28px;
    }

    .report-modal .modal-title {
        font-weight: 700;
        font-size: 20px;
        color: #262626;
    }

    .report-modal .modal-body {
        padding: 28px;
    }

    .report-modal .form-label {
        font-weight: 700;
        color: #262626;
        margin-bottom: 10px;
        font-size: 15px;
    }

    .report-modal .form-select,
    .report-modal .form-control {
        border: 2px solid #efefef;
        border-radius: 14px;
        padding: 14px 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .report-modal .form-select:focus,
    .report-modal .form-control:focus {
        border-color: #e74c3c;
        background: white;
        box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
    }

    .report-modal .modal-footer {
        border-top: 1px solid #f0f0f0;
        padding: 24px 28px;
        gap: 12px;
    }

    .report-modal .btn-submit-report {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex: 1;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .report-modal .btn-submit-report:hover {
        background: linear-gradient(135deg, #ff5a4a, #e74c3c);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(231, 76, 60, 0.4);
    }

    .report-modal .btn-cancel {
        background: #f0f5f9;
        color: #262626;
        border: none;
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s ease;
        flex: 1;
    }

    .report-modal .btn-cancel:hover {
        background: #e0e7ed;
    }

    /* Scrollbar */
    .modal-comments-section::-webkit-scrollbar {
        width: 8px;
    }

    .modal-comments-section::-webkit-scrollbar-track {
        background: #f8f8f8;
        border-radius: 10px;
    }

    .modal-comments-section::-webkit-scrollbar-thumb {
        background: #dbdbdb;
        border-radius: 10px;
    }

    .modal-comments-section::-webkit-scrollbar-thumb:hover {
        background: #b8b8b8;
    }

    /* Empty State */
    .empty-feed {
        text-align: center;
        padding: 120px 40px;
        background: white;
        border-radius: 24px;
        margin: 40px auto;
        max-width: 600px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .empty-feed i {
        font-size: 80px;
        margin-bottom: 24px;
        display: block;
        opacity: 0.7;
    }

    .empty-feed h4 {
        color: #262626;
        margin-bottom: 12px;
        font-weight: 700;
        font-size: 24px;
    }

    .empty-feed p {
        color: #8e8e8e;
        font-size: 16px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .modal-details-section {
            width: 100%;
        }

        .modal-container {
            flex-direction: column;
        }

        .modal-image-section {
            height: 55vh;
        }

        .modal-comments-section {
            max-height: 30vh;
        }

        .explore-sidebar {
            position: relative;
            height: auto;
            margin-bottom: 20px;
        }
    }
</style>

<div class="explore-container py-1 mt-1">
    <div class="container">
        <div class="row">
            <!-- Sidebar: Kategori saja -->
            <div class="col-lg-3 mb-4">
                <div class="explore-sidebar">
                    <!-- Search Card (Mobile) -->
                    <div class="search-card d-lg-none">
                        <form action="{{ route('user.explore.search') }}" method="GET">
                            <div class="search-input-wrapper">
                                <iconify-icon icon="solar:magnifer-linear" class="search-icon"></iconify-icon>
                                <input type="text" 
                                       name="q" 
                                       class="search-input" 
                                       placeholder="Cari postingan..." 
                                       value="{{ $searchQuery ?? '' }}">
                            </div>
                            <button type="submit" class="search-btn mt-2 w-100">Cari</button>
                        </form>
                    </div>

                    <!-- Kategori -->
                    <div class="category-card">
                        <div class="category-card-header">
                            <i class="fas fa-filter"></i> Kategori
                        </div>
                        <div class="category-list">
                            <a href="{{ route('user.explore.halaman') }}" 
                               class="category-item {{ !isset($selectedCategory) ? 'active' : '' }}">
                                <i class="fas fa-th"></i> Semua Kategori
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('user.explore.category', $category->id) }}" 
                               class="category-item {{ isset($selectedCategory) && $selectedCategory->id === $category->id ? 'active' : '' }}">
                                <i class="fas fa-folder"></i> {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Search Card (Desktop) -->
                <div class="search-card d-none d-lg-block">
                    <form action="{{ route('user.explore.search') }}" method="GET" class="d-flex align-items-center">
                        <div class="search-input-wrapper flex-grow-1">
                            <iconify-icon icon="solar:magnifer-linear" class="search-icon"></iconify-icon>
                            <input type="text" 
                                   name="q" 
                                   class="search-input" 
                                   placeholder="Cari postingan, pengguna, atau kategori..." 
                                   value="{{ $searchQuery ?? '' }}">
                        </div>
                        <button type="submit" class="search-btn">Cari</button>
                    </form>
                </div>

                <!-- Feed Container -->
                <div class="feed-container">
                    @if($posts->count() > 0)
                        <div class="masonry-grid">
                            @foreach($posts as $post)
                                @include('partials.post-card', ['post' => $post])
                                @include('partials.post-modal', ['post' => $post])
                            @endforeach
                        </div>
                    @else
                        <div class="empty-feed">
                            <i>📷</i>
                            <h4>Tidak ada postingan ditemukan</h4>
                            <p>Coba cari dengan kata kunci yang berbeda atau jelajahi kategori lain</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Like functionality
    document.querySelectorAll('.modal-action-btn[data-post-id]').forEach(button => {
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
                this.innerHTML = data.liked ? '❤️' : '🤍';
                this.dataset.liked = data.liked ? '1' : '0';

                const countEl = document.querySelector(`.like-count[data-post-id="${postId}"]`);
                if (countEl) {
                    countEl.textContent = data.total;
                }
            })
            .catch(err => console.error(err));
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Comment form submit dengan AJAX
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
                                    repliesContainer.style.marginLeft = '52px';
                                    repliesContainer.style.marginTop = '12px';
                                    repliesContainer.style.paddingLeft = '12px';
                                    repliesContainer.style.borderLeft = '2px solid #efefef';
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

        // Reply button click
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

        // Cancel reply
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('cancel-reply')) {
                const form = e.target.closest('.comment-form-ajax');
                const replyIdInput = form.querySelector('.reply-id-input');
                const replyInfo = form.querySelector('.reply-info');
                
                replyIdInput.value = '';
                replyInfo.style.display = 'none';
            }
        });

        // Delete comment
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
                                    commentsContainer.innerHTML = '<p class="text-center text-muted no-comments-msg" id="no-comments-' + postId + '">Belum ada komentar</p>';
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

        // Helper function untuk alert
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

        // Initialize carousels
        const carousels = document.querySelectorAll('.carousel');
        carousels.forEach(carousel => {
            new bootstrap.Carousel(carousel, {
                interval: false,
                wrap: true,
                touch: true
            });
        });
    });
</script>

@endsection