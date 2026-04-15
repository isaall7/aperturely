@extends('layouts.index2')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --black:       #0a0a0a;
        --white:       #ffffff;
        --cream:       #f9f7f4;
        --warm-gray:   #e8e4df;
        --mid-gray:    #b8b3ac;
        --muted:       #888077;
        --accent:      #c8533a;
        --accent-h:    #a83f28;
        --accent-soft: #f5ece9;
        --shadow-sm:   0 1px 3px rgba(10,10,10,0.07);
        --shadow-md:   0 4px 16px rgba(10,10,10,0.10);
        --shadow-lg:   0 12px 40px rgba(10,10,10,0.14);
        --r-sm:  8px;
        --r-md:  14px;
        --r-lg:  20px;
        --r-xl:  28px;
        font-family: 'DM Sans', sans-serif;
    }

    body { background: var(--cream); }

    /* ===================== BACK BAR ===================== */
    .pd-topbar {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(249,247,244,0.9);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--warm-gray);
        height: 56px;
        display: flex;
        align-items: center;
        padding: 0 24px;
        gap: 14px;
    }

    .pd-back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--black);
        text-decoration: none;
        padding: 6px 12px 6px 8px;
        border-radius: 40px;
        transition: background 0.2s;
    }
    .pd-back-btn:hover { background: var(--warm-gray); color: var(--black); }

    /* ===================== MAIN LAYOUT ===================== */
    .pd-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 80px;
    }

    .pd-main {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 32px;
        align-items: start;
        margin-bottom: 64px;
    }

    /* ===================== LEFT — PHOTO ===================== */
    .pd-photo-wrap {
        position: sticky;
        top: 76px; /* topbar height + margin */
        border-radius: var(--r-xl);
        overflow: hidden;
        background: var(--black);
        box-shadow: var(--shadow-lg);
        width: 100%;
        min-height: 320px;
        max-height: min(90vh, 980px);
        padding: clamp(10px, 1.4vw, 18px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pd-photo-wrap img {
        width: auto;
        max-width: 100%;
        height: auto;
        max-height: calc(min(90vh, 980px) - clamp(20px, 2.8vw, 36px));
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    /* Carousel in detail page */
    .pd-photo-wrap .carousel {
        width: 100%;
        height: 100%;
    }

    .pd-photo-wrap .carousel-inner,
    .pd-photo-wrap .carousel-item {
        height: 100%;
    }

    .pd-photo-wrap .carousel-item {
        text-align: center;
    }

    .pd-photo-wrap .carousel-item img {
        width: auto;
        max-width: 100%;
        height: auto;
        max-height: calc(min(90vh, 980px) - clamp(20px, 2.8vw, 36px));
        object-fit: contain;
    }

    .pd-photo-wrap .carousel-control-prev,
    .pd-photo-wrap .carousel-control-next {
        width: 44px;
        height: 44px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        backdrop-filter: blur(6px);
        transition: background 0.2s;
    }
    .pd-photo-wrap .carousel-control-prev { left: 14px; }
    .pd-photo-wrap .carousel-control-next { right: 14px; }
    .pd-photo-wrap .carousel-control-prev:hover,
    .pd-photo-wrap .carousel-control-next:hover { background: rgba(255,255,255,0.28); }

    .pd-photo-wrap .carousel-indicators {
        bottom: 12px;
        margin: 0;
    }
    .pd-photo-wrap .carousel-indicators button {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.5);
        margin: 0 3px;
        padding: 0;
    }
    .pd-photo-wrap .carousel-indicators button.active { background: var(--white); }

    /* Multi-image badge */
    .pd-multi-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(10,10,10,0.6);
        color: #fff;
        font-size: 12px;
        font-weight: 500;
        padding: 4px 11px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        gap: 5px;
        z-index: 2;
    }

    /* ===================== RIGHT — SIDEBAR ===================== */
    .pd-sidebar {
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Header actions */
    .pd-sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .pd-header-left { display: flex; align-items: center; gap: 4px; }

    .pd-action-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background 0.2s;
        color: var(--black);
    }
    .pd-action-btn:hover { background: var(--warm-gray); }

    .pd-save-btn {
        height: 34px;
        padding: 0 20px;
        background: var(--accent);
        color: var(--white);
        border: none;
        border-radius: 34px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
    }
    .pd-save-btn:hover { background: var(--accent-h); transform: scale(1.04); }

    .ap-modal-save {
        height: 40px;
        padding: 0 18px;
        border: none;
        border-radius: 999px;
        background: #111111;
        color: var(--white);
        font-size: 13px;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(17, 17, 17, 0.18);
        transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
    }
    .ap-modal-save:hover {
        background: #000000;
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(17, 17, 17, 0.24);
        filter: none;
    }
    .ap-modal-save.dropdown-toggle::after {
        margin-left: 2px;
        vertical-align: middle;
    }

    .ap-download-menu {
        min-width: 260px;
        padding: 8px;
        border: 1px solid rgba(10,10,10,0.06);
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
    }

    .ap-download-menu .dropdown-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        border-radius: 12px;
        padding: 10px 12px;
        font-size: 13px;
        color: var(--black);
    }

    .ap-download-menu .dropdown-item span:last-child {
        flex-shrink: 0;
        min-width: 28px;
        padding: 4px 8px;
        border-radius: 999px;
        background: var(--accent-soft);
        color: var(--accent);
        font-size: 11px;
        font-weight: 700;
        text-align: center;
    }

    .ap-download-menu .dropdown-item:hover,
    .ap-download-menu .dropdown-item:focus {
        background: #f6f1eb;
        color: var(--black);
    }

    .ap-download-menu .dropdown-divider {
        margin: 8px 2px;
        border-top-color: var(--warm-gray);
    }

    /* Author */
    .pd-author {
        padding: 18px 20px 14px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .pd-author-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pd-author-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--warm-gray);
        flex-shrink: 0;
        transition: border-color 0.2s;
    }
    .pd-author-avatar:hover { border-color: var(--accent); }

    .pd-author-name {
        font-size: 14.5px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
        display: block;
        transition: color 0.2s;
    }
    .pd-author-name:hover { color: var(--accent); }

    .pd-author-time {
        font-size: 12px;
        color: var(--muted);
        display: block;
        margin-top: 1px;
    }

    .pd-caption {
        font-size: 14px;
        color: #444;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .pd-stats {
        display: flex;
        gap: 18px;
    }

    .pd-stat {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: var(--muted);
        font-weight: 500;
    }

    /* Category tag */
    .pd-category-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
        font-size: 12px;
        color: var(--accent);
        background: var(--accent-soft);
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }
    .pd-category-tag:hover { background: #ecd5cf; color: var(--accent); }

    /* Like button */
    .pd-like-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 34px;
        border: 1.5px solid var(--warm-gray);
        background: transparent;
        font-size: 13.5px;
        font-weight: 500;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 14px;
    }
    .pd-like-btn:hover { border-color: var(--accent); color: var(--accent); }
    .pd-like-btn.liked { background: var(--accent-soft); border-color: var(--accent); color: var(--accent); }

    /* ===================== COMMENTS ===================== */
    .pd-comments-wrap {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
        max-height: 340px;
        min-height: 100px;
    }

    .pd-comments-wrap::-webkit-scrollbar { width: 4px; }
    .pd-comments-wrap::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 4px; }

    .pd-no-comment {
        text-align: center;
        padding: 24px 0;
        font-size: 13.5px;
        color: var(--muted);
    }

    /* Comment item */
    .ap-comment {
        display: flex;
        gap: 10px;
        margin-bottom: 14px;
    }

    .ap-comment-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1.5px solid var(--warm-gray);
    }

    .ap-comment-body { flex: 1; min-width: 0; }

    .ap-comment-author {
        font-size: 13px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
        margin-right: 6px;
        transition: color 0.2s;
    }
    .ap-comment-author:hover { color: var(--accent); }

    .ap-comment-text {
        font-size: 13.5px;
        color: #444;
        line-height: 1.5;
        word-break: break-word;
    }

    .ap-comment-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 4px;
        flex-wrap: wrap;
    }

    .ap-comment-time {
        font-size: 11.5px;
        color: var(--muted);
    }

    .ap-comment-action-btn {
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: color 0.2s;
    }
    .ap-comment-action-btn:hover { color: var(--black); }
    .ap-comment-action-btn.danger:hover { color: var(--accent); }

    /* Replies */
    .ap-replies-nest {
        margin-top: 8px;
        padding-left: 14px;
        border-left: 2px solid var(--warm-gray);
    }

    /* Reply indicator */
    .ap-reply-indicator {
        display: none;
        align-items: center;
        justify-content: space-between;
        background: var(--accent-soft);
        border-radius: var(--r-sm);
        padding: 6px 12px;
        font-size: 12.5px;
        color: var(--accent);
        margin-bottom: 8px;
    }
    .ap-reply-indicator.show { display: flex; }
    .ap-cancel-reply {
        background: none;
        border: none;
        font-size: 12px;
        font-weight: 600;
        color: var(--accent);
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
    }

    /* Comment form */
    .pd-comment-form {
        border-top: 1px solid var(--warm-gray);
        padding: 14px 20px;
    }

    .pd-comment-input-row {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .pd-comment-input-row input {
        flex: 1;
        height: 40px;
        background: var(--warm-gray);
        border: none;
        border-radius: 40px;
        padding: 0 16px;
        font-size: 13.5px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .pd-comment-input-row input:focus {
        background: var(--white);
        box-shadow: 0 0 0 2px var(--accent);
    }
    .pd-comment-input-row input::placeholder { color: var(--muted); }

    .pd-comment-submit {
        height: 40px;
        padding: 0 18px;
        background: var(--accent);
        color: var(--white);
        border: none;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .pd-comment-submit:hover { background: var(--accent-h); }
    .pd-comment-submit:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ===================== RELATED POSTS ===================== */
    .pd-related { margin-top: 16px; }

    .pd-related-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 400;
        color: var(--black);
        margin-bottom: 24px;
    }

    .pd-related-title span {
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        color: var(--accent);
        background: var(--accent-soft);
        padding: 3px 10px;
        border-radius: 20px;
        margin-left: 10px;
        vertical-align: middle;
    }

    .pd-related-grid {
        columns: 5;
        column-gap: 18px;
    }

    @media (max-width: 1400px) { .pd-related-grid { columns: 4; } }
    @media (max-width: 1100px) { .pd-related-grid { columns: 3; } }

    .pd-rel-card {
        break-inside: avoid;
        margin-bottom: 18px;
        border-radius: var(--r-lg);
        overflow: hidden;
        background: var(--white);
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        transition: box-shadow 0.3s, transform 0.3s;
        text-decoration: none;
        display: block;
    }
    .pd-rel-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-3px); }

    .pd-rel-img {
        position: relative;
        overflow: hidden;
        background: var(--warm-gray);
    }
    .pd-rel-img img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    }
    .pd-rel-card:hover .pd-rel-img img { transform: scale(1.06); }

    .pd-rel-multi-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(10,10,10,0.6);
        color: #fff;
        font-size: 10.5px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .pd-rel-body {
        padding: 10px 12px 12px;
    }

    .pd-rel-user {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 6px;
    }

    .pd-rel-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid var(--warm-gray);
        flex-shrink: 0;
    }

    .pd-rel-username {
        font-size: 12px;
        font-weight: 600;
        color: var(--black);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pd-rel-caption {
        font-size: 12px;
        color: #666;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 7px;
    }

    .pd-rel-stats {
        display: flex;
        gap: 10px;
    }

    .pd-rel-stat {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        color: var(--muted);
        font-weight: 500;
    }

    /* ===================== TOAST ===================== */
    .ap-toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(12px);
        background: var(--black);
        color: var(--white);
        font-size: 13.5px;
        padding: 10px 22px;
        border-radius: 40px;
        z-index: 9999;
        pointer-events: none;
        animation: toastIn 0.3s ease forwards, toastOut 0.3s ease 2.9s forwards;
        box-shadow: var(--shadow-lg);
    }
    .ap-toast.success { background: #2d7a4f; }
    .ap-toast.error   { background: var(--accent); }

    @keyframes toastIn  { to   { transform: translateX(-50%) translateY(0); opacity: 1; } }
    @keyframes toastOut { from { opacity: 1; } to { opacity: 0; } }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 900px) {
        .pd-main {
            grid-template-columns: 1fr;
        }
        .pd-photo-wrap {
            position: static;
            min-height: 0;
            max-height: none;
            padding: 10px;
        }
        .pd-photo-wrap img,
        .pd-photo-wrap .carousel-item img {
            width: 100%;
            max-width: 100%;
            max-height: 75vh;
            object-fit: contain;
        }
        .pd-related-grid { columns: 2; column-gap: 12px; }
        .pd-related-grid { column-gap: 12px; }
        .ap-modal-save,
        .ap-download-menu {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .pd-page { padding: 20px 14px 60px; }
        .pd-related-grid { columns: 2; column-gap: 10px; }
        .pd-rel-body { display: none; }
    }
</style>

{{-- BACK BAR --}}
<div class="pd-topbar">
    <a href="{{ route('user.dashboard') }}" class="pd-back-btn">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M11 4L6 9l5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali
    </a>
</div>

<div class="pd-page">

    {{-- =================== MAIN SECTION =================== --}}
    <div class="pd-main">

        {{-- LEFT: PHOTO --}}
        <div class="pd-photo-wrap">
            @if($post->photos && $post->photos->count() > 1)
                {{-- Multi-photo badge --}}
                <div class="pd-multi-badge">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <rect x="1" y="3" width="7" height="8" rx="1.2" stroke="white" stroke-width="1.3"/>
                        <rect x="4" y="1" width="7" height="8" rx="1.2" stroke="white" stroke-width="1.3"/>
                    </svg>
                    {{ $post->photos->count() }}
                </div>
                <div id="pdCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        @foreach($post->photos as $i => $photo)
                            <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $photo->photo) }}" alt="Foto {{ $i + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#pdCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#pdCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <div class="carousel-indicators">
                        @foreach($post->photos as $i => $photo)
                            <button type="button" data-bs-target="#pdCarousel"
                                    data-bs-slide-to="{{ $i }}"
                                    class="{{ $i == 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                </div>
            @elseif($post->photos && $post->photos->first())
                <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="{{ $post->caption ?? 'Post' }}">
            @else
                <img src="https://via.placeholder.com/800x600/1a1a1a/444?text=No+Image" alt="No Image">
            @endif
        </div>

        {{-- RIGHT: SIDEBAR --}}
        <div class="pd-sidebar">

            {{-- Header actions --}}
            <div class="pd-sidebar-header">
                <div class="pd-header-left">
                    {{-- Like button --}}
                    <button class="pd-action-btn pd-like-icon-btn"
                            id="likeBtn"
                            data-post-id="{{ $post->id }}"
                            data-liked="{{ $post->isLikedBy(auth()->id()) ? '1' : '0' }}"
                            title="Suka">
                        @if($post->isLikedBy(auth()->id()))
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="#c8533a">
                                <path d="M10 17S2 12.5 2 7A5 5 0 0110 3.8 5 5 0 0118 7C18 12.5 10 17 10 17z"/>
                            </svg>
                        @else
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M10 17S2 12.5 2 7A5 5 0 0110 3.8 5 5 0 0118 7C18 12.5 10 17 10 17z" stroke="#888" stroke-width="1.7"/>
                            </svg>
                        @endif
                    </button>

                    {{-- More options --}}
                    <div class="dropdown">
                        <button class="pd-action-btn" type="button" data-bs-toggle="dropdown">
                            <svg width="18" height="4" viewBox="0 0 18 4" fill="#888">
                                <circle cx="2" cy="2" r="1.6"/><circle cx="9" cy="2" r="1.6"/><circle cx="16" cy="2" r="1.6"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @auth
                                @if(auth()->id() === $post->user_id)
                                    <li><a class="dropdown-item" href="{{ route('user.postingan.edit', $post) }}">✏️ Edit</a></li>
                                    <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <li>
                                            <button class="dropdown-item text-danger"
                                                    onclick="return confirm('Hapus postingan ini?')">
                                                🗑️ Hapus
                                            </button>
                                        </li>
                                    </form>
                                @else
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                           data-bs-toggle="modal"
                                           data-bs-target="#reportPostModal">
                                            🚩 Laporkan
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a class="dropdown-item text-danger" href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#reportPostModal">
                                        🚩 Laporkan
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
                @if($post->photos && $post->photos->count() > 1)
                    <div class="dropdown">
                        <button class="ap-modal-save dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Download
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end ap-download-menu">
                            @foreach($post->photos as $slideIndex => $photo)
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.postingan.download', ['post' => $post->id, 'photo' => $photo->id]) }}">
                                        <span>Download slide {{ $slideIndex + 1 }}</span>
                                        <span>#{{ $slideIndex + 1 }}</span>
                                    </a>
                                </li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button"
                                        class="dropdown-item fw-semibold download-all-btn"
                                        data-download-urls='@json($post->photos->map(fn ($photo) => route('user.postingan.download', ['post' => $post->id, 'photo' => $photo->id]))->values())'>
                                </button>
                            </li>
                        </ul>
                    </div>
                @elseif($post->photos && $post->photos->first())
                    <a href="{{ route('user.postingan.download', ['post' => $post->id]) }}" class="ap-modal-save">Download</a>
                @endif
            </div>

            {{-- Author + Caption --}}
            <div class="pd-author">
                <div class="pd-author-row">
                    <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}">
                        <img src="{{ $post->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                             alt="{{ $post->user->name }}"
                             class="pd-author-avatar">
                    </a>
                    <div>
                        <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}"
                           class="pd-author-name">
                            {{ $post->user->username ?? $post->user->name }}
                        </a>
                        <span class="pd-author-time">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                @if($post->caption)
                    <p class="pd-caption">{{ $post->caption }}</p>
                @endif

                <div class="pd-stats">
                    <span class="pd-stat" id="likeCount">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M7 12S1.5 9 1.5 5A3.5 3.5 0 017 2.2 3.5 3.5 0 0112.5 5C12.5 9 7 12 7 12z" stroke="#c8533a" stroke-width="1.5"/>
                        </svg>
                        {{ $post->likes->count() }} suka
                    </span>
                    <span class="pd-stat">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M11.5 1.5h-9a.5.5 0 00-.5.5v7a.5.5 0 00.5.5H4.5l2.5 3 2.5-3h2a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#888" stroke-width="1.4"/>
                        </svg>
                        {{ $post->comments->count() }} komentar
                    </span>
                </div>

                {{-- Category tag --}}
                @if($post->tipeKategori)
                    <a href="{{ route('user.dashboard.kategori', $post->tipeKategori->slug) }}"
                       class="pd-category-tag">
                        <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                            <path d="M1.5 1.5h3.6l4.4 4.4-3.6 3.6L1.5 5.1V1.5z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                            <circle cx="3.2" cy="3.2" r="0.7" fill="currentColor"/>
                        </svg>
                        {{ $post->tipeKategori->name }}
                    </a>
                @endif
            </div>

            {{-- Comments --}}
            <div class="pd-comments-wrap" id="commentsContainer">
                @forelse($post->comments->whereNull('reply_id') as $comment)
                    <div class="comment-wrapper" id="comment-wrapper-{{ $comment->id }}">
                        <div class="ap-comment" id="comment-{{ $comment->id }}">
                            <a href="{{ route('user.profile.username', ['name' => $comment->user->name]) }}">
                                <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                                     alt="{{ $comment->user->name }}"
                                     class="ap-comment-avatar">
                            </a>
                            <div class="ap-comment-body">
                                <div>
                                    <a href="{{ route('user.profile.username', ['name' => $comment->user->name]) }}"
                                       class="ap-comment-author">{{ $comment->user->username ?? $comment->user->name }}</a>
                                    <span class="ap-comment-text">{{ $comment->comment }}</span>
                                </div>
                                <div class="ap-comment-meta">
                                    <span class="ap-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                    @auth
                                        <button class="ap-comment-action-btn reply-btn"
                                                data-id="{{ $comment->id }}"
                                                data-username="{{ $comment->user->username ?? $comment->user->name }}">Balas</button>
                                        @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                            <button class="ap-comment-action-btn danger delete-comment-btn"
                                                    data-id="{{ $comment->id }}"
                                                    data-url="{{ route('user.comments.destroy', $comment->id) }}">Hapus</button>
                                        @endif
                                        @if(auth()->id() !== $comment->user_id)
                                            <button class="ap-comment-action-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                                        @endif
                                    @else
                                        <button class="ap-comment-action-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        {{-- Replies --}}
                        @if($comment->replies && $comment->replies->count())
                            <div class="ap-replies-nest">
                                @foreach($comment->replies as $reply)
                                    <div class="ap-comment" id="comment-{{ $reply->id }}">
                                        <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}">
                                            <img src="{{ $reply->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                                                 alt="{{ $reply->user->name }}"
                                                 class="ap-comment-avatar">
                                        </a>
                                        <div class="ap-comment-body">
                                            <div>
                                                <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}"
                                                   class="ap-comment-author">{{ $reply->user->username ?? $reply->user->name }}</a>
                                                <span class="ap-comment-text">{{ $reply->comment }}</span>
                                            </div>
                                            <div class="ap-comment-meta">
                                                <span class="ap-comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                                @auth
                                                    @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
                                                        <button class="ap-comment-action-btn danger delete-comment-btn"
                                                                data-id="{{ $reply->id }}"
                                                                data-url="{{ route('user.comments.destroy', $reply->id) }}">Hapus</button>
                                                    @endif
                                                    @if(auth()->id() !== $reply->user_id)
                                                        <button class="ap-comment-action-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#reportCommentModal{{ $reply->id }}">Laporkan</button>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="pd-no-comment" id="noComment">Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </div>

            {{-- Comment form --}}
            @auth
            <div class="pd-comment-form">
                <form id="commentForm" data-post-id="{{ $post->id }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="reply_id" id="replyIdInput" value="">

                    <div class="ap-reply-indicator" id="replyIndicator">
                        <span>Membalas: <strong id="replyToUsername"></strong></span>
                        <button type="button" id="cancelReply" class="ap-cancel-reply">Batal</button>
                    </div>

                    <div class="pd-comment-input-row">
                        <input type="text" name="comment" id="commentInput"
                               placeholder="Tulis komentar…" autocomplete="off" required>
                        <button type="submit" class="pd-comment-submit" id="commentSubmit" disabled>Kirim</button>
                    </div>
                </form>
            </div>
            @else
            <div style="padding:14px 20px;text-align:center;border-top:1px solid var(--warm-gray);">
                <a href="{{ route('login') }}" style="font-size:13.5px;color:var(--accent);font-weight:600;">
                    Masuk untuk berkomentar
                </a>
            </div>
            @endauth

        </div>{{-- end sidebar --}}
    </div>{{-- end pd-main --}}

    {{-- =================== RELATED POSTS =================== --}}
    @if($relatedPosts && $relatedPosts->count())
    <div class="pd-related">
        <h2 class="pd-related-title">
            Postingan Serupa
            @if($post->tipeKategori)
                <span>{{ $post->tipeKategori->name }}</span>
            @endif
        </h2>

        <div class="pd-related-grid">
            @foreach($relatedPosts as $rel)
                <a href="{{ route('user.post-detail', $rel->id) }}" class="pd-rel-card">
                    <div class="pd-rel-img">
                        @if($rel->photos && $rel->photos->first())
                            <img src="{{ asset('storage/' . $rel->photos->first()->photo) }}"
                                 alt="{{ $rel->caption ?? '' }}" loading="lazy">
                        @else
                            <img src="https://via.placeholder.com/300x300/e8e4df/b8b3ac?text=No+Image" alt="">
                        @endif

                        @if($rel->photos && $rel->photos->count() > 1)
                            <div class="pd-rel-multi-badge">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                    <rect x="1" y="2.5" width="5.5" height="6.5" rx="1" stroke="white" stroke-width="1.2"/>
                                    <rect x="3.5" y="1" width="5.5" height="6.5" rx="1" stroke="white" stroke-width="1.2"/>
                                </svg>
                                {{ $rel->photos->count() }}
                            </div>
                        @endif
                    </div>
                    <div class="pd-rel-body">
                        <div class="pd-rel-user">
                            <img src="{{ $rel->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                                 alt="" class="pd-rel-avatar">
                            <span class="pd-rel-username">{{ $rel->user->username ?? $rel->user->name }}</span>
                        </div>
                        @if($rel->caption)
                            <div class="pd-rel-caption">{{ $rel->caption }}</div>
                        @endif
                        <div class="pd-rel-stats">
                            <span class="pd-rel-stat">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 10.5S1 7.5 1 4A3 3 0 016 1.8 3 3 0 0111 4C11 7.5 6 10.5 6 10.5z" stroke="#c8533a" stroke-width="1.3"/>
                                </svg>
                                {{ $rel->likes_count ?? $rel->likes->count() }}
                            </span>
                            <span class="pd-rel-stat">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M9.5 1H2.5a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4L6 10l2-2h1.5a.5.5 0 00.5-.5v-6A.5.5 0 009.5 1z" stroke="#888" stroke-width="1.3"/>
                                </svg>
                                {{ $rel->comments_count ?? $rel->comments->count() }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

</div>{{-- end pd-page --}}


{{-- ===== REPORT POST MODAL ===== --}}
<div class="modal fade" id="reportPostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Laporkan Postingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.report.post', $post->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan <span style="color:var(--accent)">*</span></label>
                        <select class="form-select" name="reason" required>
                            <option value="">Pilih alasan…</option>
                            <option value="spam">Spam</option>
                            <option value="bullying">Bullying / Pelecehan</option>
                            <option value="hate_speech">Ujaran Kebencian</option>
                            <option value="pornography">Konten Pornografi</option>
                            <option value="violence">Kekerasan</option>
                            <option value="scam">Penipuan</option>
                            <option value="copyright">Pelanggaran Hak Cipta</option>
                            <option value="misinformation">Informasi Menyesatkan</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Keterangan <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Jelaskan lebih lanjut…"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== REPORT COMMENT MODALS ===== --}}
@include('partials.comment-report-modals', ['comments' => $post->comments])
{{--
@foreach($post->comments as $comment)
    <div class="modal fade" id="reportCommentModal{{ $comment->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Laporkan Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.report.comment', $comment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan <span style="color:var(--accent)">*</span></label>
                            <select class="form-select" name="reason" required>
                                <option value="">Pilih alasan…</option>
                                <option value="spam">Spam</option>
                                <option value="bullying">Bullying / Pelecehan</option>
                                <option value="hate_speech">Ujaran Kebencian</option>
                                <option value="pornography">Konten Pornografi</option>
                                <option value="violence">Kekerasan</option>
                                <option value="scam">Penipuan</option>
                                <option value="copyright">Pelanggaran Hak Cipta</option>
                                <option value="misinformation">Informasi Menyesatkan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Keterangan <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Jelaskan lebih lanjut…"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger btn-sm">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
--}}


<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Like button ─────────────────────────────────────────────
    const likeBtn  = document.getElementById('likeBtn');
    const likeCnt  = document.getElementById('likeCount');

    if (likeBtn) {
        likeBtn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`{{ route('user.post.like', ':id') }}`.replace(':id', postId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                const liked = data.liked;
                this.dataset.liked = liked ? '1' : '0';
                this.innerHTML = liked
                    ? `<svg width="20" height="20" viewBox="0 0 20 20" fill="#c8533a"><path d="M10 17S2 12.5 2 7A5 5 0 0110 3.8 5 5 0 0118 7C18 12.5 10 17 10 17z"/></svg>`
                    : `<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 17S2 12.5 2 7A5 5 0 0110 3.8 5 5 0 0118 7C18 12.5 10 17 10 17z" stroke="#888" stroke-width="1.7"/></svg>`;

                // Update count display
                if (likeCnt && data.likes_count !== undefined) {
                    likeCnt.innerHTML = `
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M7 12S1.5 9 1.5 5A3.5 3.5 0 017 2.2 3.5 3.5 0 0112.5 5C12.5 9 7 12 7 12z" stroke="#c8533a" stroke-width="1.5"/>
                        </svg>
                        ${data.likes_count} suka`;
                }
            })
            .catch(console.error);
        });
    }

    // ── Comment form ─────────────────────────────────────────────
    const form         = document.getElementById('commentForm');
    const commentInput = document.getElementById('commentInput');
    const submitBtn    = document.getElementById('commentSubmit');
    const replyInput   = document.getElementById('replyIdInput');
    const replyInd     = document.getElementById('replyIndicator');
    const replyName    = document.getElementById('replyToUsername');
    const cancelReply  = document.getElementById('cancelReply');
    const container    = document.getElementById('commentsContainer');

    if (commentInput) {
        commentInput.addEventListener('input', () => {
            submitBtn.disabled = !commentInput.value.trim();
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!commentInput.value.trim()) return;

            submitBtn.disabled   = true;
            submitBtn.textContent = '…';

            fetch('{{ route("user.comments.store") }}', {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const noMsg = document.getElementById('noComment');
                    if (noMsg) noMsg.remove();

                    if (data.comment.reply_id) {
                        let pw = document.getElementById('comment-wrapper-' + data.comment.reply_id);
                        if (pw) {
                            let nest = pw.querySelector('.ap-replies-nest');
                            if (!nest) {
                                nest = document.createElement('div');
                                nest.className = 'ap-replies-nest';
                                pw.appendChild(nest);
                            }
                            nest.insertAdjacentHTML('beforeend', data.html);
                        }
                    } else {
                        container.insertAdjacentHTML('afterbegin', data.html);
                    }

                    commentInput.value = '';
                    replyInput.value   = '';
                    if (replyInd) replyInd.classList.remove('show');
                    showToast('success', 'Komentar ditambahkan!');
                } else {
                    showToast('error', data.message || 'Terjadi kesalahan');
                }
            })
            .catch(() => showToast('error', 'Gagal mengirim komentar'))
            .finally(() => {
                submitBtn.disabled    = false;
                submitBtn.textContent = 'Kirim';
            });
        });
    }

    // ── Reply ────────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('reply-btn')) {
            const id       = e.target.dataset.id;
            const username = e.target.dataset.username;
            replyInput.value     = id;
            replyName.textContent = username;
            if (replyInd) replyInd.classList.add('show');
            if (commentInput) commentInput.focus();
        }
    });

    if (cancelReply) {
        cancelReply.addEventListener('click', function () {
            replyInput.value = '';
            replyInd.classList.remove('show');
        });
    }

    // ── Delete comment ───────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('delete-comment-btn')) return;
        if (!confirm('Hapus komentar ini?')) return;

        const id  = e.target.dataset.id;
        const url = e.target.dataset.url;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const cw = document.getElementById('comment-wrapper-' + id);
                if (cw) cw.remove();
                else {
                    const c = document.getElementById('comment-' + id);
                    if (c) c.closest('.ap-comment')?.remove();
                }
                showToast('success', 'Komentar dihapus');
            } else {
                showToast('error', data.message || 'Gagal menghapus');
            }
        })
        .catch(() => showToast('error', 'Terjadi kesalahan'));
    });

    // ── Toast helper ─────────────────────────────────────────────
    function showToast(type, msg) {
        const t = document.createElement('div');
        t.className   = 'ap-toast ' + type;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 3200);
    }

    // ── Bootstrap carousel ───────────────────────────────────────
    const carousel = document.getElementById('pdCarousel');
    if (carousel) {
        new bootstrap.Carousel(carousel, { interval: false, wrap: true, touch: true });
    }
});
</script>

@endsection
