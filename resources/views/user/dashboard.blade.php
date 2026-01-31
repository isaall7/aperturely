@extends('layouts.index2')

@section('content')
<style>

    .navbar-search {
    position: fixed; /* supaya tidak terpengaruh padding container */
    top: 70px;       /* sesuaikan dengan tinggi navbar Anda */
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 500px;
    padding: 0 20px;
    z-index: 1;
    }

    .search-form {
    width: 100%;
    }

    .search-input-wrapper {
    position: relative;
    width: 100%;
    }

    .search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #8e8e8e;
    pointer-events: none;
    z-index: 1;
    }

    .search-input {
    width: 100%;
    padding: 12px 20px 12px 50px;
    border: 2px solid #efefef;
    border-radius: 28px;
    font-size: 15px;
    outline: none;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #262626;
    }

    .search-input:focus {
    border-color: #5d87ff;
    background: white;
    box-shadow: 0 4px 12px rgba(93, 135, 255, 0.15);
    }

    .search-input::placeholder {
    color: #8e8e8e;
    }

    /* Logo tetap di kiri */
    .navbar-brand {
    margin-right: auto;
    }

    /* Profile tetap di kanan */
    .navbar-profile {
    margin-left: 20px;
    }

    /* Responsive Search */
    @media (max-width: 1200px) {
    .navbar-search {
        max-width: 400px;
    }
    }

    @media (max-width: 992px) {
    .navbar-search {
        display: none; /* Hide search on mobile, bisa diganti dengan button toggle */
    }
    
    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }
    }

    @media (max-width: 768px) {
    .navbar-brand img {
        max-height: 32px !important;
    }

    .navbar-center .navbar-nav {
        gap: 4px;
    }

    .navbar-center .nav-link {
        width: 40px;
        height: 40px;
    }

    .navbar-profile img {
        width: 32px !important;
        height: 32px !important;
    }
    }
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Feed Container - Optimized untuk Navbar Baru */
    .feed-container {
        background: transparent;
        min-height: calc(100vh - 60px);
        padding: 15px 0;
    }

    .feed-container .container-fluid {
        max-width: 1600px;
        padding: 0 40px;
    }
    
    /* Masonry Grid - Lebih Responsif */
    .masonry-grid {
        column-count: 5;
        column-gap: 24px;
        padding: 0;
    }
    
    @media (max-width: 1600px) {
        .masonry-grid {
            column-count: 4;
        }
    }

    @media (max-width: 1200px) {
        .masonry-grid {
            column-count: 3;
        }
        .feed-container .container-fluid {
            padding: 0 30px;
        }
    }
    
    @media (max-width: 900px) {
        .masonry-grid {
            column-count: 2;
            column-gap: 16px;
        }
        .feed-container .container-fluid {
            padding: 0 20px;
        }
    }
    
    @media (max-width: 600px) {
        .masonry-grid {
            column-count: 1;
        }
        .feed-container {
            padding: 20px 0;
        }
        .feed-container .container-fluid {
            padding: 0 15px;
        }
    }
    
    /* Post Card - Lebih Modern */
    .post-card {
        background: white;
        border-radius: 20px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        break-inside: avoid;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
    }
    
    .post-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        transform: translateY(-4px);
    }
    
    .post-card:hover .post-overlay {
        opacity: 1;
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
    
    /* Overlay - Lebih Smooth */
    .post-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.05), rgba(0,0,0,0.5));
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        border-radius: 20px 20px 0 0;
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
    
    /* Buttons - Lebih Modern */
    .overlay-btn {
        background: white;
        border: none;
        border-radius: 28px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .overlay-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 16px rgba(0,0,0,0.3);
    }
    
    .save-btn {
        background: linear-gradient(135deg, #e60023, #c4001d);
        color: white;
    }

    .save-btn:hover {
        background: linear-gradient(135deg, #ff0a37, #e60023);
    }
    
    .action-btns {
        display: flex;
        gap: 10px;
    }
    
    .icon-btn {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .icon-btn:hover {
        transform: scale(1.15) rotate(5deg);
        background: white;
        box-shadow: 0 6px 16px rgba(0,0,0,0.3);
    }
    
    /* Post Info - Lebih Rapi */
    .post-info {
        padding: 16px 18px;
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
    }

    .user-name:hover {
        color: #5d87ff;
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

    /* Empty State - Lebih Menarik */
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
    
    /* Modal - Optimized */
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

    /* Modal Carousel - Improved */
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
    
    .comment-username {
        font-weight: 700;
        color: #262626;
        font-size: 15px;
        margin-right: 10px;
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

    /* Dropdown Menu - Enhanced */
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

    /* Report Modal - Enhanced */
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
    
    /* Scrollbar - Custom */
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

    /* Pagination - Modern */
    .pagination {
        gap: 8px;
    }

    .pagination .page-link {
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        color: #262626;
        font-weight: 600;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .pagination .page-link:hover {
        background: #5d87ff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: #5d87ff;
        color: white;
        box-shadow: 0 4px 12px rgba(93, 135, 255, 0.3);
    }

    /* Responsive Optimizations */
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

        .feed-container {
            padding: 20px 0;
        }
    }

    @media (max-width: 768px) {
        .post-card {
            border-radius: 16px;
            margin-bottom: 16px;
        }

        .post-overlay {
            padding: 16px;
        }

        .overlay-btn {
            padding: 8px 20px;
            font-size: 14px;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            font-size: 18px;
        }

        .detail-modal .modal-dialog {
            margin: 0;
            height: 100vh;
            max-width: 100%;
        }

        .detail-modal .modal-content {
            border-radius: 0;
        }
    }

    /* Smooth Animations */
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

    .post-card {
        animation: fadeIn 0.5s ease;
    }

    /* Loading States */
    .post-card.loading {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

<!-- search -->
 <div class="navbar-search">
      <form action="{{ route('user.dashboard') }}" method="GET" class="search-form">
        <div class="search-input-wrapper">
          <iconify-icon icon="solar:magnifer-linear" class="search-icon"></iconify-icon>
          <input 
            type="text" 
            name="search" 
            class="search-input" 
            placeholder="Cari postingan, pengguna..."
            value="{{ request('search') }}"
            autocomplete="off"
          >
        </div>
      </form>
    </div>
<!-- feed -->
<div class="feed-container">
    <div class="container px-0">
        @if($posts->count() > 0)
            <div class="masonry-grid">
                @foreach($posts as $post)
                    <div class="post-card" data-bs-toggle="modal" data-bs-target="#detailModal{{ $post->id }}">
                        <div class="post-image-container">
                            @if($post->photos && $post->photos->first())
                                <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post" loading="lazy">
                            @else
                                <img src="https://via.placeholder.com/300x400?text=No+Image" alt="No Image">
                            @endif
                            
                            <div class="post-overlay">
                                <div class="post-overlay-top">
                                    <button class="overlay-btn save-btn" onclick="event.stopPropagation();">Simpan</button>
                                </div>
                                <div class="post-overlay-bottom">
                                    <div class="action-btns">
                                        <button class="icon-btn" onclick="event.stopPropagation(); toggleLike(this);" title="Like">🤍</button>
                                        <button class="icon-btn" onclick="event.stopPropagation();" title="Comment">💬</button>
                                        <button class="icon-btn" onclick="event.stopPropagation();" title="Share">📤</button>
                                    </div>
                                    <div class="dropdown" onclick="event.stopPropagation();">
                                        <button class="icon-btn" type="button" data-bs-toggle="dropdown" title="More">
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
                                        src="{{ $post->user?->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                        alt="Avatar" 
                                        class="user-avatar"
                                    >
                                    <span class="user-name">{{ $post->user->username ?? $post->user->name }}</span>
                                </div>  
                                @if($post->caption)
                                    <div class="post-caption">{{ $post->caption }}</div>
                                @endif
                                <div class="post-stats">
                                    <span>❤️ {{ number_format($post->likes->count() ?? 0) }}</span>
                                    <span>💬 {{ number_format($post->comments->count() ?? 0) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
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
                                                    <button class="modal-action-btn" type="button" data-bs-dismiss="modal">✖️</button>
                                                    <div class="dropdown">
                                                        <button class="modal-action-btn" type="button" data-bs-toggle="dropdown">
                                                            ⋯
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            @auth
                                                                @if(auth()->id() === $post->user_id)
                                                                    <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                                                <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <li><button class="dropdown-item text-danger" onclick="return confirm('Yakin ingin hapus postingan ini?')">🗑️ Hapus</button></li>
                                                                </form>
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
                                                <button class="modal-save-btn">Simpan</button>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="modal">✖️</button>
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
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">✖️</button>
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
            <div class="d-flex justify-content-center mt-5 mb-4">
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

document.addEventListener('DOMContentLoaded', function() {
    // Comment input functionality
    document.querySelectorAll('.modal-comment-input input').forEach(input => {
        input.addEventListener('input', function() {
            const button = this.nextElementSibling;
            button.disabled = this.value.trim().length === 0;
        });
    });

    // Initialize carousels
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

    // Lazy loading images
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
});
</script>

@endsection