@extends('layouts.index2')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

<style>
    /* ===================== RESET & BASE ===================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --black: #0a0a0a;
        --white: #ffffff;
        --cream: #f9f7f4;
        --warm-gray: #e8e4df;
        --mid-gray: #b8b3ac;
        --text-muted: #888077;
        --accent: #c8533a;
        --accent-hover: #a83f28;
        --accent-soft: #f5ece9;
        --blue: #3a6bc8;
        --shadow-sm: 0 1px 3px rgba(10,10,10,0.08);
        --shadow-md: 0 4px 16px rgba(10,10,10,0.10);
        --shadow-lg: 0 12px 40px rgba(10,10,10,0.16);
        --r-sm: 8px;
        --r-md: 14px;
        --r-lg: 20px;
        --r-xl: 28px;
        font-family: 'DM Sans', sans-serif;
    }

    /* ===================== NAVBAR ===================== */
    .ap-navbar {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(249, 247, 244, 0.88);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-bottom: 1px solid var(--warm-gray);
        padding: 0 40px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }

    .ap-nav-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .ap-nav-brand .brand-icon {
        width: 34px;
        height: 34px;
        background: var(--black);
        border-radius: var(--r-sm);
        display: grid;
        place-items: center;
    }

    .ap-nav-brand .brand-icon svg { display: block; }

    .ap-nav-brand .brand-name {
        font-size: 17px;
        font-weight: 600;
        color: var(--black);
        letter-spacing: -0.3px;
    }

    .ap-nav-brand .brand-sub {
        font-size: 10px;
        color: var(--text-muted);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        display: block;
        margin-top: -3px;
    }

    .ap-nav-search {
        flex: 1;
        max-width: 420px;
        position: relative;
    }

    .ap-nav-search input {
        width: 100%;
        height: 40px;
        background: var(--warm-gray);
        border: none;
        border-radius: 40px;
        padding: 0 18px 0 42px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: background 0.2s, box-shadow 0.2s;
    }

    .ap-nav-search input:focus {
        background: var(--white);
        box-shadow: 0 0 0 2px var(--accent);
    }

    .ap-nav-search input::placeholder { color: var(--text-muted); }

    .ap-nav-search .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        pointer-events: none;
    }

    .ap-nav-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ap-nav-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background 0.2s;
        color: var(--black);
        text-decoration: none;
        position: relative;
    }

    .ap-nav-btn:hover { background: var(--warm-gray); }

    .ap-nav-btn .badge {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 8px;
        height: 8px;
        background: var(--accent);
        border-radius: 50%;
        border: 1.5px solid var(--cream);
    }

    .ap-upload-btn {
        height: 36px;
        padding: 0 18px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 36px;
        font-size: 14px;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        white-space: nowrap;
    }

    .ap-upload-btn:hover { background: #2a2a2a; transform: translateY(-1px); color: var(--white); }

    .ap-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--warm-gray);
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .ap-avatar:hover { border-color: var(--accent); }

    /* ===================== FEED ===================== */
    .ap-feed {
        background: var(--cream);
        min-height: calc(100vh - 64px);
        padding: 40px 0 80px;
    }

    .ap-feed-inner {
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 40px;
    }

    /* Category Filter */
    .ap-filters {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 36px;
        flex-wrap: wrap;
    }

    .ap-filter-btn {
        height: 36px;
        padding: 0 18px;
        border-radius: 36px;
        border: 1.5px solid var(--warm-gray);
        background: var(--white);
        font-size: 13.5px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .ap-filter-btn:hover, .ap-filter-btn.active {
        background: var(--black);
        border-color: var(--black);
        color: var(--white);
    }

    /* ===================== MASONRY GRID ===================== */
    .ap-grid {
        columns: 5;
        column-gap: 20px;
    }

    @media (max-width: 1400px) { .ap-grid { columns: 4; } }
    @media (max-width: 1100px) { .ap-grid { columns: 3; } }
    @media (max-width: 780px) { .ap-grid { columns: 2; column-gap: 14px; } }
    @media (max-width: 480px) { .ap-grid { columns: 1; } }

    /* ===================== POST CARD ===================== */
    .ap-card {
        break-inside: avoid;
        margin-bottom: 20px;
        border-radius: var(--r-lg);
        overflow: hidden;
        background: var(--white);
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        transition: box-shadow 0.3s, transform 0.3s;
        animation: cardReveal 0.5s ease both;
        position: relative;
    }

    .ap-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-3px);
    }

    @keyframes cardReveal {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Stagger animation */
    .ap-card:nth-child(1)  { animation-delay: 0.05s; }
    .ap-card:nth-child(2)  { animation-delay: 0.10s; }
    .ap-card:nth-child(3)  { animation-delay: 0.15s; }
    .ap-card:nth-child(4)  { animation-delay: 0.20s; }
    .ap-card:nth-child(5)  { animation-delay: 0.25s; }
    .ap-card:nth-child(6)  { animation-delay: 0.30s; }
    .ap-card:nth-child(7)  { animation-delay: 0.35s; }
    .ap-card:nth-child(8)  { animation-delay: 0.40s; }

    .ap-card-img-wrap {
        position: relative;
        overflow: hidden;
        background: var(--warm-gray);
    }

    .ap-card-img-wrap img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    }

    .ap-card:hover .ap-card-img-wrap img { transform: scale(1.06); }

    /* Overlay */
    .ap-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, transparent 40%, rgba(10,10,10,0.55));
        opacity: 0;
        transition: opacity 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 14px;
    }

    .ap-card:hover .ap-card-overlay { opacity: 1; }

    .ap-overlay-top { display: flex; justify-content: flex-end; }

    .ap-overlay-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ap-save-btn {
        height: 34px;
        padding: 0 18px;
        border-radius: 34px;
        border: none;
        background: var(--accent);
        color: var(--white);
        font-size: 13px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        letter-spacing: 0.2px;
    }

    .ap-save-btn:hover { background: var(--accent-hover); transform: scale(1.05); }

    .ap-overlay-actions { display: flex; gap: 8px; }

    .ap-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.92);
        border: none;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: transform 0.2s, background 0.2s;
        backdrop-filter: blur(4px);
    }

    .ap-icon-btn:hover { transform: scale(1.12); background: var(--white); }

    /* Multi-image badge */
    .ap-multi-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(10,10,10,0.65);
        color: var(--white);
        font-size: 11px;
        font-weight: 500;
        padding: 3px 9px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Card body */
    .ap-card-body { padding: 14px 16px 16px; }

    .ap-card-user {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 8px;
    }

    .ap-card-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 1.5px solid var(--warm-gray);
        flex-shrink: 0;
    }

    .ap-card-username {
        font-size: 13px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
        transition: color 0.2s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ap-card-username:hover { color: var(--accent); }

    .ap-card-caption {
        font-size: 13.5px;
        color: #555;
        line-height: 1.5;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ap-card-stats {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ap-stat {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12.5px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .ap-stat svg { flex-shrink: 0; }

    /* ===================== EMPTY STATE ===================== */
    .ap-empty {
        text-align: center;
        padding: 100px 40px;
    }

    .ap-empty-icon {
        width: 72px;
        height: 72px;
        background: var(--white);
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin: 0 auto 24px;
        box-shadow: var(--shadow-md);
    }

    .ap-empty h3 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        font-weight: 400;
        color: var(--black);
        margin-bottom: 10px;
    }

    .ap-empty p {
        font-size: 15px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }

    .ap-empty .ap-upload-btn { margin: 0 auto; }

    /* ===================== DETAIL MODAL ===================== */
    .ap-detail-modal .modal-dialog {
        max-width: 1080px;
        margin: 3vh auto;
        height: 94vh;
    }

    .ap-detail-modal .modal-content {
        border: none;
        border-radius: var(--r-xl);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 30px 80px rgba(10,10,10,0.3);
    }

    .ap-detail-modal .modal-body {
        padding: 0;
        flex: 1;
        overflow: hidden;
        display: flex;
    }

    .ap-modal-media {
        flex: 1;
        background: var(--black);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .ap-modal-media img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Carousel tweaks */
    .ap-modal-media .carousel { width: 100%; height: 100%; }
    .ap-modal-media .carousel-inner { height: 100%; }
    .ap-modal-media .carousel-item {
        height: 100%;
        display: flex !important;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        opacity: 0;
        transition: opacity 0.35s ease;
    }
    .ap-modal-media .carousel-item.active { position: relative; opacity: 1; }

    .ap-modal-media .carousel-control-prev,
    .ap-modal-media .carousel-control-next {
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(8px);
        border-radius: 50%;
        top: 50%; transform: translateY(-50%);
        opacity: 1;
        z-index: 10;
        transition: background 0.2s, transform 0.2s;
    }
    .ap-modal-media .carousel-control-prev { left: 16px; transform: translateY(-50%); }
    .ap-modal-media .carousel-control-next { right: 16px; transform: translateY(-50%); }
    .ap-modal-media .carousel-control-prev:hover,
    .ap-modal-media .carousel-control-next:hover {
        background: var(--white);
        transform: translateY(-50%) scale(1.1);
    }

    .ap-modal-media .carousel-control-prev-icon,
    .ap-modal-media .carousel-control-next-icon {
        width: 20px; height: 20px;
        filter: invert(1);
    }

    .ap-modal-media .carousel-indicators {
        bottom: 16px;
        gap: 6px;
        margin: 0;
    }

    .ap-modal-media .carousel-indicators button {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        border: none;
        transition: all 0.2s;
        padding: 0; margin: 0;
    }

    .ap-modal-media .carousel-indicators button.active {
        background: var(--white);
        transform: scale(1.4);
    }

    /* Sidebar */
    .ap-modal-sidebar {
        width: 400px;
        flex-shrink: 0;
        background: var(--white);
        display: flex;
        flex-direction: column;
        border-left: 1px solid var(--warm-gray);
    }

    .ap-modal-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--warm-gray);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .ap-modal-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ap-modal-action {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--cream);
        border: none;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: background 0.2s, transform 0.2s;
        color: var(--black);
    }

    .ap-modal-action:hover { background: var(--warm-gray); transform: scale(1.08); }

    .ap-modal-save {
        height: 36px;
        padding: 0 20px;
        background: var(--accent);
        color: var(--white);
        border: none;
        border-radius: 36px;
        font-size: 14px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s;
    }

    .ap-modal-save:hover { background: var(--accent-hover); }

    /* Author */
    .ap-modal-author {
        padding: 18px 20px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .ap-author-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .ap-author-avatar {
        width: 44px; height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--warm-gray);
        flex-shrink: 0;
    }

    .ap-author-name {
        font-size: 15px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
    }

    .ap-author-name:hover { color: var(--accent); }

    .ap-author-time {
        font-size: 12px;
        color: var(--text-muted);
        display: block;
        margin-top: 2px;
    }

    .ap-modal-caption {
        font-size: 14.5px;
        color: #444;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .ap-modal-stats {
        display: flex;
        gap: 18px;
    }

    .ap-modal-stat {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-muted);
    }

    /* Comments */
    .ap-modal-comments {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
    }

    .ap-modal-comments::-webkit-scrollbar { width: 5px; }
    .ap-modal-comments::-webkit-scrollbar-track { background: transparent; }
    .ap-modal-comments::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 10px; }

    .ap-comment {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--cream);
    }

    .ap-comment:last-child { border-bottom: none; }

    .ap-comment-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1.5px solid var(--warm-gray);
    }

    .ap-comment-body { flex: 1; }

    .ap-comment-author {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
    }

    .ap-comment-author:hover { color: var(--accent); }

    .ap-comment-text {
        font-size: 13.5px;
        color: #444;
        line-height: 1.5;
        margin-top: 2px;
        display: block;
    }

    .ap-comment-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 6px;
    }

    .ap-comment-time {
        font-size: 11.5px;
        color: var(--text-muted);
    }

    .ap-comment-action-btn {
        background: none;
        border: none;
        font-size: 12px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        transition: color 0.2s;
    }

    .ap-comment-action-btn:hover { color: var(--black); }

    .ap-replies-nest {
        margin-left: 44px;
        margin-top: 10px;
        padding-left: 12px;
        border-left: 2px solid var(--warm-gray);
    }

    /* Comment input */
    .ap-comment-form-wrap {
        padding: 14px 20px;
        border-top: 1px solid var(--warm-gray);
        background: var(--white);
    }

    .ap-reply-indicator {
        display: none;
        background: var(--accent-soft);
        border-radius: var(--r-sm);
        padding: 6px 12px;
        margin-bottom: 8px;
        font-size: 12.5px;
        color: var(--accent);
        font-weight: 500;
        align-items: center;
        justify-content: space-between;
    }

    .ap-reply-indicator.show { display: flex; }

    .ap-cancel-reply {
        background: none;
        border: none;
        font-size: 12px;
        color: var(--accent);
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        font-weight: 600;
    }

    .ap-comment-input-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ap-comment-input-row input {
        flex: 1;
        height: 40px;
        background: var(--cream);
        border: 1.5px solid transparent;
        border-radius: 40px;
        padding: 0 18px;
        font-size: 13.5px;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        color: var(--black);
    }

    .ap-comment-input-row input::placeholder { color: var(--text-muted); }

    .ap-comment-input-row input:focus {
        background: var(--white);
        border-color: var(--accent);
    }

    .ap-comment-submit {
        height: 40px;
        padding: 0 18px;
        background: var(--accent);
        color: var(--white);
        border: none;
        border-radius: 40px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .ap-comment-submit:hover:not(:disabled) { background: var(--accent-hover); }
    .ap-comment-submit:disabled { opacity: 0.45; cursor: not-allowed; }

    /* ===================== REPORT MODAL ===================== */
    .ap-report-modal .modal-dialog { max-width: 480px; }

    .ap-report-modal .modal-content {
        border: none;
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .ap-report-modal .modal-header {
        padding: 24px 28px 16px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .ap-report-modal .modal-title {
        font-size: 17px;
        font-weight: 600;
        color: var(--black);
    }

    .ap-report-modal .modal-body { padding: 20px 28px; }

    .ap-report-modal .form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--black);
        display: block;
        margin-bottom: 7px;
    }

    .ap-report-modal .form-select,
    .ap-report-modal .form-control {
        border: 1.5px solid var(--warm-gray);
        border-radius: var(--r-md);
        padding: 11px 16px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        background: var(--cream);
        outline: none;
        transition: border-color 0.2s;
        width: 100%;
        color: var(--black);
    }

    .ap-report-modal .form-select:focus,
    .ap-report-modal .form-control:focus {
        border-color: var(--accent);
        background: var(--white);
        box-shadow: 0 0 0 3px rgba(200,83,58,0.12);
    }

    .ap-report-modal .modal-footer {
        padding: 14px 28px 24px;
        border-top: 1px solid var(--warm-gray);
        display: flex;
        gap: 10px;
    }

    .ap-report-modal .btn-cancel {
        flex: 1;
        height: 42px;
        background: var(--cream);
        border: none;
        border-radius: var(--r-md);
        font-size: 14px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        cursor: pointer;
        transition: background 0.2s;
    }

    .ap-report-modal .btn-cancel:hover { background: var(--warm-gray); }

    .ap-report-modal .btn-submit-report {
        flex: 1;
        height: 42px;
        background: #c0392b;
        border: none;
        border-radius: var(--r-md);
        font-size: 14px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--white);
        cursor: pointer;
        transition: background 0.2s;
    }

    .ap-report-modal .btn-submit-report:hover { background: #a93226; }

    /* Dropdown */
    .dropdown-menu {
        border: 1px solid var(--warm-gray);
        border-radius: var(--r-md);
        box-shadow: var(--shadow-md);
        padding: 6px;
    }

    .dropdown-item {
        border-radius: var(--r-sm);
        padding: 9px 14px;
        font-size: 14px;
        color: var(--black);
        font-family: 'DM Sans', sans-serif;
        transition: background 0.15s;
    }

    .dropdown-item:hover { background: var(--cream); }
    .dropdown-item.text-danger { color: #c0392b !important; }
    .dropdown-item.text-danger:hover { background: #fdf2f2; }

    /* Alert toast */
    .ap-toast {
        position: fixed;
        top: 80px;
        right: 24px;
        z-index: 99999;
        padding: 14px 20px;
        border-radius: var(--r-md);
        font-size: 14px;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        box-shadow: var(--shadow-lg);
        animation: toastIn 0.3s ease;
        max-width: 320px;
    }

    .ap-toast.success { background: #1a7431; color: var(--white); }
    .ap-toast.error { background: #c0392b; color: var(--white); }

    @keyframes toastIn {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* Responsive modal */
    @media (max-width: 900px) {
        .ap-detail-modal .modal-body { flex-direction: column; }
        .ap-modal-media { height: 50vh; }
        .ap-modal-sidebar { width: 100%; flex: 1; }
        .ap-navbar { padding: 0 20px; }
        .ap-feed-inner { padding: 0 16px; }
    }

    @media (max-width: 600px) {
        .ap-detail-modal .modal-dialog { margin: 0; height: 100vh; max-width: 100%; }
        .ap-detail-modal .modal-content { border-radius: 0; }
        .ap-filters { display: none; }
    }
</style>


{{-- FEED --}}
<div class="ap-feed">
    <div class="ap-feed-inner">

        {{-- FILTERS --}}
        <div class="ap-filters">
            <a href="{{ route('user.dashboard') }}"
        class="ap-filter-btn {{ !isset($slug) ? 'active' : '' }}">
        Semua
        </a>

        @foreach($tipeKategori as $kategori)
            <a href="{{ route('user.dashboard.kategori', $kategori->slug) }}"
            class="ap-filter-btn {{ isset($slug) && $slug == $kategori->slug ? 'active' : '' }}">
                {{ $kategori->name }}
            </a>
        @endforeach
        </div>

        @if($posts->count() > 0)
            <div class="ap-grid">
                @foreach($posts as $post)
                    {{-- ===== CARD ===== --}}
                    <div class="ap-card" data-bs-toggle="modal" data-bs-target="#apModal{{ $post->id }}">
                        <div class="ap-card-img-wrap">
                            @if($post->photos && $post->photos->first())
                                <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="" loading="lazy">
                            @else
                                <img src="https://via.placeholder.com/300x400/e8e4df/b8b3ac?text=No+Image" alt="">
                            @endif

                            @if($post->photos && $post->photos->count() > 1)
                                <div class="ap-multi-badge">
                                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                                        <rect x="1" y="3" width="7" height="7" rx="1" stroke="white" stroke-width="1.3"/>
                                        <path d="M3 3V2a1 1 0 011-1h5a1 1 0 011 1v5a1 1 0 01-1 1H8" stroke="white" stroke-width="1.3"/>
                                    </svg>
                                    {{ $post->photos->count() }}
                                </div>
                            @endif

                            <div class="ap-card-overlay" onclick="event.stopPropagation()">
                                <div class="ap-overlay-top">
                                    <button class="ap-save-btn">Simpan</button>
                                </div>
                                <div class="ap-overlay-bottom">
                                    <div class="ap-overlay-actions">
                                        <button class="ap-icon-btn" title="Suka">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8 13.5S2 10 2 5.5A3.5 3.5 0 018 3.1 3.5 3.5 0 0114 5.5C14 10 8 13.5 8 13.5z" stroke="#c8533a" stroke-width="1.6"/>
                                            </svg>
                                        </button>
                                        <button class="ap-icon-btn" title="Komentar">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13 2H3a1 1 0 00-1 1v7a1 1 0 001 1h2l3 3 3-3h2a1 1 0 001-1V3a1 1 0 00-1-1z" stroke="#555" stroke-width="1.6"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="dropdown">
                                        <button class="ap-icon-btn" type="button" data-bs-toggle="dropdown" onclick="event.stopPropagation()">
                                            <svg width="16" height="4" viewBox="0 0 16 4" fill="currentColor">
                                                <circle cx="2" cy="2" r="1.5"/><circle cx="8" cy="2" r="1.5"/><circle cx="14" cy="2" r="1.5"/>
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @auth
                                                @if(auth()->id() === $post->user_id)
                                                    <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                                    <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <li><button class="dropdown-item text-danger" onclick="return confirm('Hapus postingan?')">🗑️ Hapus</button></li>
                                                    </form>
                                                @else
                                                    <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportPost{{ $post->id }}" onclick="event.stopPropagation()">🚩 Laporkan</a></li>
                                                @endif
                                            @else
                                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportPost{{ $post->id }}" onclick="event.stopPropagation()">🚩 Laporkan</a></li>
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($post->caption || $post->user)
                        <div class="ap-card-body">
                            <div class="ap-card-user">
                                <img src="{{ $post->user->avatar_display }}" alt="" class="ap-card-avatar">
                                <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="ap-card-username" onclick="event.stopPropagation()">
                                    {{ $post->user->username ?? $post->user->name }}
                                </a>
                            </div>
                            @if($post->caption)
                                <div class="ap-card-caption">{{ $post->caption }}</div>
                            @endif
                            <div class="ap-card-stats">
                                <span class="ap-stat">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <path d="M6.5 11S1.5 8 1.5 4.5A2.5 2.5 0 016.5 2.7 2.5 2.5 0 0111.5 4.5C11.5 8 6.5 11 6.5 11z" stroke="#c8533a" stroke-width="1.5" fill="none"/>
                                    </svg>
                                    {{ $post->likes->count() }}
                                </span>
                                <span class="ap-stat">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <path d="M10.5 1.5h-8a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4l2.5 2.5 2.5-2.5h1.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#888" stroke-width="1.4"/>
                                    </svg>
                                    {{ $post->comments->count() }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- ===== DETAIL MODAL ===== --}}
                    <div class="modal fade ap-detail-modal" id="apModal{{ $post->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">

                                    {{-- Media --}}
                                    <div class="ap-modal-media">
                                        @if($post->photos && $post->photos->count() > 1)
                                            <div id="apCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="false">
                                                <div class="carousel-inner">
                                                    @foreach($post->photos as $i => $photo)
                                                        <div class="carousel-item {{ $i==0?'active':'' }}">
                                                            <img src="{{ asset('storage/'.$photo->photo) }}" alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#apCarousel{{ $post->id }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#apCarousel{{ $post->id }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon"></span>
                                                </button>
                                                <div class="carousel-indicators">
                                                    @foreach($post->photos as $i => $photo)
                                                        <button type="button" data-bs-target="#apCarousel{{ $post->id }}" data-bs-slide-to="{{ $i }}" class="{{ $i==0?'active':'' }}"></button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($post->photos && $post->photos->first())
                                            <img src="{{ asset('storage/'.$post->photos->first()->photo) }}" alt="">
                                        @else
                                            <img src="https://via.placeholder.com/600x600/1a1a1a/444?text=No+Image" alt="">
                                        @endif
                                    </div>

                                    {{-- Sidebar --}}
                                    <div class="ap-modal-sidebar">
                                        {{-- Header --}}
                                        <div class="ap-modal-header">
                                            <div class="ap-modal-header-left">
                                                <button class="ap-modal-action like-modal-btn"
                                                        data-post-id="{{ $post->id }}"
                                                        data-liked="{{ $post->isLikedBy(auth()->id()) ? '1' : '0' }}"
                                                        title="Suka">
                                                    @if($post->isLikedBy(auth()->id()))
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="#c8533a"><path d="M9 15.5S2 11.5 2 6.5A4.5 4.5 0 019 3.2 4.5 4.5 0 0116 6.5C16 11.5 9 15.5 9 15.5z"/></svg>
                                                    @else
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 15.5S2 11.5 2 6.5A4.5 4.5 0 019 3.2 4.5 4.5 0 0116 6.5C16 11.5 9 15.5 9 15.5z" stroke="#888" stroke-width="1.6"/></svg>
                                                    @endif
                                                </button>
                                                <div class="dropdown">
                                                    <button class="ap-modal-action" type="button" data-bs-toggle="dropdown">
                                                        <svg width="16" height="4" viewBox="0 0 16 4" fill="#888">
                                                            <circle cx="2" cy="2" r="1.5"/><circle cx="8" cy="2" r="1.5"/><circle cx="14" cy="2" r="1.5"/>
                                                        </svg>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        @auth
                                                            @if(auth()->id() === $post->user_id)
                                                                <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                                                <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                                                    @csrf @method('DELETE')
                                                                    <li><button class="dropdown-item text-danger" onclick="return confirm('Hapus?')">🗑️ Hapus</button></li>
                                                                </form>
                                                            @else
                                                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportPost{{ $post->id }}">🚩 Laporkan</a></li>
                                                            @endif
                                                        @else
                                                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#reportPost{{ $post->id }}">🚩 Laporkan</a></li>
                                                        @endauth
                                                    </ul>
                                                </div>
                                                <button class="ap-modal-action" data-bs-dismiss="modal" title="Tutup">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                        <path d="M1 1l12 12M13 1L1 13" stroke="#888" stroke-width="1.8" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <button class="ap-modal-save">Simpan</button>
                                        </div>

                                        {{-- Author --}}
                                        <div class="ap-modal-author">
                                            <div class="ap-author-row">
                                                <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}">
                                                    <img src="{{ $post->user->avatar_display }}" alt="" class="ap-author-avatar">
                                                </a>
                                                <div>
                                                    <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="ap-author-name">
                                                        {{ $post->user->username ?? $post->user->name }}
                                                    </a>
                                                    <span class="ap-author-time">{{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            @if($post->caption)
                                                <p class="ap-modal-caption">{{ $post->caption }}</p>
                                            @endif
                                            <div class="ap-modal-stats">
                                                <span class="ap-modal-stat">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                        <path d="M7 12S1.5 9 1.5 5A3.5 3.5 0 017 2.2 3.5 3.5 0 0112.5 5C12.5 9 7 12 7 12z" stroke="#c8533a" stroke-width="1.5"/>
                                                    </svg>
                                                    {{ $post->likes->count() }} suka
                                                </span>
                                                <span class="ap-modal-stat">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                        <path d="M11.5 1.5H2.5a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4l3 3 3-3h1.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#888" stroke-width="1.4"/>
                                                    </svg>
                                                    {{ $post->comments->count() }} komentar
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Comments --}}
                                        <div class="ap-modal-comments" id="comments-{{ $post->id }}">
                                            @forelse($post->comments->where('reply_id', null) as $comment)
                                                <div class="comment-wrapper" id="cw-{{ $comment->id }}">
                                                    <div class="ap-comment" id="c-{{ $comment->id }}">
                                                        <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}">
                                                            <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" class="ap-comment-avatar" alt="">
                                                        </a>
                                                        <div class="ap-comment-body">
                                                            <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="ap-comment-author">{{ $comment->user->username ?? $comment->user->name }}</a>
                                                            <span class="ap-comment-text">{{ $comment->comment }}</span>
                                                            <div class="ap-comment-meta">
                                                                <span class="ap-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                                                @auth
                                                                    <button class="ap-comment-action-btn reply-btn" data-id="{{ $comment->id }}" data-username="{{ $comment->user->username ?? $comment->user->name }}">Balas</button>
                                                                    @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                                                        <button class="ap-comment-action-btn delete-comment-btn" data-id="{{ $comment->id }}" data-url="{{ route('user.comments.destroy', $comment->id) }}">Hapus</button>
                                                                    @endif
                                                                    @if(auth()->id() !== $comment->user_id)
                                                                        <button class="ap-comment-action-btn" data-bs-toggle="modal" data-bs-target="#rcModal{{ $comment->id }}">Laporkan</button>
                                                                    @endif
                                                                @else
                                                                    <button class="ap-comment-action-btn" data-bs-toggle="modal" data-bs-target="#rcModal{{ $comment->id }}">Laporkan</button>
                                                                @endauth
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($comment->replies->count() > 0)
                                                        <div class="ap-replies-nest">
                                                            @foreach($comment->replies as $reply)
                                                                <div class="ap-comment" id="c-{{ $reply->id }}">
                                                                    <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}">
                                                                        <img src="{{ $reply->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" class="ap-comment-avatar" alt="">
                                                                    </a>
                                                                    <div class="ap-comment-body">
                                                                        <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}" class="ap-comment-author">{{ $reply->user->username ?? $reply->user->name }}</a>
                                                                        <span class="ap-comment-text">{{ $reply->comment }}</span>
                                                                        <div class="ap-comment-meta">
                                                                            <span class="ap-comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                                                            @auth
                                                                                @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
                                                                                    <button class="ap-comment-action-btn delete-comment-btn" data-id="{{ $reply->id }}" data-url="{{ route('user.comments.destroy', $reply->id) }}">Hapus</button>
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
                                                <p class="text-center" style="color:var(--text-muted);font-size:14px;padding:32px 0;" id="nc-{{ $post->id }}">Belum ada komentar. Jadilah yang pertama!</p>
                                            @endforelse
                                        </div>

                                        {{-- Comment form --}}
                                        @auth
                                        <div class="ap-comment-form-wrap">
                                            <form class="comment-form-ajax" data-post-id="{{ $post->id }}">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <input type="hidden" name="reply_id" class="reply-id-input" value="">
                                                <div class="ap-reply-indicator" id="ri-{{ $post->id }}">
                                                    <span>Membalas: <strong class="reply-to-username"></strong></span>
                                                    <button type="button" class="ap-cancel-reply">Batal</button>
                                                </div>
                                                <div class="ap-comment-input-row">
                                                    <input type="text" name="comment" class="comment-input" placeholder="Tulis komentar…" required autocomplete="off">
                                                    <button type="submit" class="ap-comment-submit" disabled>Kirim</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div style="padding:14px 20px;text-align:center;border-top:1px solid var(--warm-gray);">
                                            <a href="{{ route('login') }}" style="font-size:13.5px;color:var(--accent);font-weight:600;">Masuk untuk berkomentar</a>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Report Post Modal --}}
                    <div class="modal fade ap-report-modal" id="reportPost{{ $post->id }}" tabindex="-1">
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
                                            <label class="form-label">Keterangan <span style="color:var(--text-muted);font-weight:400">(opsional)</span></label>
                                            <textarea class="form-control" name="description" rows="3" placeholder="Jelaskan lebih lanjut…"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn-submit-report">Kirim Laporan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Report Comment Modals --}}
                    @foreach($post->comments as $comment)
                        <div class="modal fade ap-report-modal" id="rcModal{{ $comment->id }}" tabindex="-1">
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
                                                <label class="form-label">Keterangan <span style="color:var(--text-muted);font-weight:400">(opsional)</span></label>
                                                <textarea class="form-control" name="description" rows="3" placeholder="Jelaskan lebih lanjut…"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
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
        @else
            <div class="ap-empty">
                <div class="ap-empty-icon">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <rect x="3" y="5" width="22" height="18" rx="3" stroke="#b8b3ac" stroke-width="1.8"/>
                        <circle cx="14" cy="14" r="4" stroke="#b8b3ac" stroke-width="1.8"/>
                        <circle cx="20" cy="9" r="1.2" fill="#b8b3ac"/>
                    </svg>
                </div>
                <h3>Belum Ada Foto</h3>
                <p>Jadilah yang pertama mengunggah karya terbaikmu</p>
                @auth
                    <a href="{{ route('user.postingan.create') ?? '#' }}" class="ap-upload-btn">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M6.5 2v9M2 6.5h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Unggah Foto
                    </a>
                @endauth
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Filter buttons ──────────────────────────────────────────────
    document.querySelectorAll('.ap-filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.ap-filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ── Like (AJAX) ─────────────────────────────────────────────────
    document.querySelectorAll('.like-modal-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`{{ route('user.post.like', ':id') }}`.replace(':id', postId), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                const liked = data.liked;
                this.innerHTML = liked
                    ? `<svg width="18" height="18" viewBox="0 0 18 18" fill="#c8533a"><path d="M9 15.5S2 11.5 2 6.5A4.5 4.5 0 019 3.2 4.5 4.5 0 0116 6.5C16 11.5 9 15.5 9 15.5z"/></svg>`
                    : `<svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 15.5S2 11.5 2 6.5A4.5 4.5 0 019 3.2 4.5 4.5 0 0116 6.5C16 11.5 9 15.5 9 15.5z" stroke="#888" stroke-width="1.6"/></svg>`;
            })
            .catch(console.error);
        });
    });

    // ── Comment submit ───────────────────────────────────────────────
    document.querySelectorAll('.comment-form-ajax').forEach(form => {
        const input = form.querySelector('.comment-input');
        const btn   = form.querySelector('.ap-comment-submit');

        input.addEventListener('input', () => { btn.disabled = !input.value.trim(); });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!input.value.trim()) return;

            btn.disabled = true;
            btn.textContent = '…';

            fetch('{{ route("user.comments.store") }}', {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const postId = this.dataset.postId;
                    const container = document.getElementById('comments-' + postId);
                    const noMsg = document.getElementById('nc-' + postId);
                    if (noMsg) noMsg.remove();

                    if (data.comment.reply_id) {
                        let pw = document.getElementById('cw-' + data.comment.reply_id);
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

                    input.value = '';
                    form.querySelector('.reply-id-input').value = '';
                    const ri = document.getElementById('ri-' + postId);
                    if (ri) ri.classList.remove('show');
                    showToast('success', 'Komentar ditambahkan!');
                } else {
                    showToast('error', data.message || 'Terjadi kesalahan');
                }
            })
            .catch(() => showToast('error', 'Gagal mengirim komentar'))
            .finally(() => { btn.disabled = false; btn.textContent = 'Kirim'; });
        });
    });

    // ── Reply ────────────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('reply-btn')) {
            const id = e.target.dataset.id;
            const username = e.target.dataset.username;
            const modal = e.target.closest('.ap-detail-modal');
            if (!modal) return;
            const form = modal.querySelector('.comment-form-ajax');
            const postId = form.dataset.postId;
            form.querySelector('.reply-id-input').value = id;
            form.querySelector('.reply-to-username').textContent = username;
            const ri = document.getElementById('ri-' + postId);
            if (ri) ri.classList.add('show');
            form.querySelector('.comment-input').focus();
        }

        if (e.target.classList.contains('ap-cancel-reply')) {
            const form = e.target.closest('.comment-form-ajax');
            const postId = form.dataset.postId;
            form.querySelector('.reply-id-input').value = '';
            const ri = document.getElementById('ri-' + postId);
            if (ri) ri.classList.remove('show');
        }
    });

    // ── Delete comment ───────────────────────────────────────────────
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
                const cw = document.getElementById('cw-' + id);
                if (cw) { cw.remove(); }
                else {
                    const c = document.getElementById('c-' + id);
                    if (c) c.remove();
                }
                showToast('success', 'Komentar dihapus');
            } else {
                showToast('error', data.message || 'Gagal menghapus');
            }
        })
        .catch(() => showToast('error', 'Terjadi kesalahan'));
    });

    // ── Toast helper ─────────────────────────────────────────────────
    function showToast(type, msg) {
        const t = document.createElement('div');
        t.className = 'ap-toast ' + type;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 3200);
    }

    // ── Bootstrap carousels ──────────────────────────────────────────
    document.querySelectorAll('.carousel').forEach(el => {
        new bootstrap.Carousel(el, { interval: false, wrap: true, touch: true });
    });
});
</script>

@endsection