@extends('layouts.index2')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

<style>
    /* ===================== RESET ===================== */
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

    /* ===================== LAYOUT ===================== */
    .pr-page {
        background: var(--cream);
        min-height: calc(100vh - 64px);
        padding-bottom: 80px;
    }

    /* ===================== BANNER ===================== */
    .pr-banner {
        height: 200px;
        background: var(--black);
        position: relative;
        overflow: hidden;
    }

    /* Subtle grain pattern */
    .pr-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.015) 0px,
                rgba(255,255,255,0.015) 1px,
                transparent 1px,
                transparent 12px
            );
    }

    .pr-banner-inner {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2420 50%, #1a1a1a 100%);
    }

    /* decorative lines */
    .pr-banner-lines {
        position: absolute;
        inset: 0;
        overflow: hidden;
        opacity: 0.06;
    }

    .pr-banner-lines::before,
    .pr-banner-lines::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        border: 1px solid var(--white);
    }

    .pr-banner-lines::before {
        width: 500px; height: 500px;
        top: -250px; right: -100px;
    }

    .pr-banner-lines::after {
        width: 300px; height: 300px;
        bottom: -150px; left: 10%;
    }
    /* ── Reset layout dari index2 ── */
    .container-fluid { padding: 0 !important; max-width: 100% !important; }
    .body-wrapper { margin-top: 0 !important; }

    /* ── Profile tweaks ── */
    .pr-banner { height: 160px; }
    .pr-card-wrap, .pr-posts { max-width: 1300px; padding: 0 40px; }
    /* ===================== PROFILE CARD ===================== */
    .pr-card-wrap {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .pr-card {
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-lg);
        margin-top: -56px;
        position: relative;
        z-index: 2;
        overflow: hidden;
    }

    /* Top strip — accent bar */
    .pr-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), #e07a5f, var(--accent));
    }

    .pr-card-body {
        padding: 32px 36px 28px;
        display: flex;
        gap: 28px;
        align-items: flex-start;
    }

    /* ── Avatar ── */
    .pr-avatar-wrap {
        flex-shrink: 0;
        position: relative;
        margin-top: 20px;
    }

    .pr-avatar {
        width: 140px;
        height: 140px;
        border-radius: var(--r-lg);
        object-fit: cover;
        border: 4px solid var(--white);
        box-shadow: var(--shadow-md);
        display: block;
    }

    /* ── Info ── */
    .pr-info { flex: 1; min-width: 0; }

    .pr-info-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .pr-name {
        font-size: 26px;
        font-weight: 600;
        color: var(--black);
        letter-spacing: -0.4px;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .pr-handle {
        font-size: 14px;
        color: var(--muted);
        font-weight: 400;
    }

    /* ── Action buttons ── */
    .pr-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .pr-btn {
        height: 38px;
        padding: 0 22px;
        border-radius: 38px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        white-space: nowrap;
    }

    .pr-btn-primary {
        background: var(--black);
        color: var(--white);
    }

    .pr-btn-primary:hover {
        background: #222;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(10,10,10,0.2);
        color: var(--white);
    }

    .pr-btn-follow {
        background: var(--accent);
        color: var(--white);
    }

    .pr-btn-follow:hover {
        background: var(--accent-h);
        transform: translateY(-1px);
        color: var(--white);
    }

    .pr-btn-following {
        background: var(--cream);
        color: var(--black);
        border: 1.5px solid var(--warm-gray);
    }

    .pr-btn-following:hover {
        background: #fdf2f2;
        color: #c0392b;
        border-color: #c0392b;
    }

    .pr-btn-secondary {
        background: var(--cream);
        color: var(--black);
        border: 1.5px solid var(--warm-gray);
    }

    .pr-btn-secondary:hover {
        background: var(--warm-gray);
        transform: translateY(-1px);
        color: var(--black);
    }

    /* ── Stats ── */
    .pr-stats {
        display: flex;
        gap: 0;
        border-top: 1px solid var(--warm-gray);
        border-bottom: 1px solid var(--warm-gray);
        margin-bottom: 20px;
    }

    .pr-stat {
        flex: 1;
        text-align: center;
        padding: 16px 8px;
        position: relative;
    }

    .pr-stat + .pr-stat::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 1px;
        background: var(--warm-gray);
    }

    .pr-stat-num {
        font-size: 22px;
        font-weight: 600;
        color: var(--black);
        display: block;
        letter-spacing: -0.5px;
        line-height: 1;
        margin-bottom: 4px;
    }

    .pr-stat-label {
        font-size: 11.5px;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 500;
    }

    /* ── Bio ── */
    .pr-bio p {
        font-size: 14px;
        color: #555;
        line-height: 1.7;
        margin-bottom: 10px;
    }

    .pr-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
    }

    .pr-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--muted);
    }

    /* ===================== POSTS SECTION ===================== */
    .pr-posts {
        max-width: 1300px;
        margin: 28px auto 0;
        padding: 0 32px;
    }

    .pr-posts-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .pr-posts-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 400;
        color: var(--black);
    }

    .pr-view-toggle {
        display: flex;
        gap: 4px;
        background: var(--white);
        border: 1px solid var(--warm-gray);
        border-radius: var(--r-sm);
        padding: 4px;
    }

    .pr-toggle-btn {
        height: 30px;
        padding: 0 14px;
        border: none;
        background: transparent;
        color: var(--muted);
        font-size: 13px;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        border-radius: 5px;
        transition: all 0.2s;
    }

    .pr-toggle-btn.active {
        background: var(--black);
        color: var(--white);
    }

    /* ===================== POSTS GRID ===================== */
    .pr-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    @media (max-width: 900px)  { .pr-grid { grid-template-columns: repeat(3,1fr); } }
    @media (max-width: 640px)  { .pr-grid { grid-template-columns: repeat(2,1fr); gap: 10px; } }

    .pr-post-item {
        position: relative;
        aspect-ratio: 1;
        cursor: pointer;
        border-radius: var(--r-md);
        overflow: hidden;
        background: var(--warm-gray);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .pr-post-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .pr-post-item img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s cubic-bezier(0.4,0,0.2,1);
    }

    .pr-post-item:hover img { transform: scale(1.05); }

    .pr-post-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(10,10,10,0.05), rgba(10,10,10,0.6));
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        opacity: 0;
        transition: opacity 0.3s;
        color: var(--white);
        font-weight: 600;
        font-size: 15px;
    }

    .pr-post-item:hover .pr-post-overlay { opacity: 1; }

    .pr-overlay-stat {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .pr-multi-badge {
        position: absolute;
        top: 8px; right: 8px;
        background: rgba(10,10,10,0.6);
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

    /* ===================== EMPTY STATE ===================== */
    .pr-empty {
        text-align: center;
        padding: 80px 24px;
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-sm);
    }

    .pr-empty-icon {
        width: 64px; height: 64px;
        background: var(--cream);
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin: 0 auto 20px;
    }

    .pr-empty h4 {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 400;
        color: var(--black);
        margin-bottom: 8px;
    }

    .pr-empty p {
        font-size: 14px;
        color: var(--muted);
        margin-bottom: 24px;
    }

    /* ===================== DETAIL MODAL ===================== */
    .ap-detail-modal .modal-dialog {
        width: min(1180px, calc(100vw - 24px));
        max-width: none;
        margin: min(3vh, 24px) auto;
        height: min(94vh, 960px);
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
        min-height: 0;
        overflow: hidden;
        display: flex;
    }

    .ap-modal-media {
        flex: 1 1 auto;
        min-width: 0;
        min-height: clamp(320px, 58vh, 860px);
        padding: clamp(12px, 1.8vw, 22px);
        background: var(--black);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .ap-modal-media > img,
    .ap-modal-media .carousel-item img {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .ap-modal-media .carousel { width: 100%; height: 100%; }
    .ap-modal-media .carousel-inner { height: 100%; }
    .ap-modal-media .carousel-item {
        height: 100%;
        display: flex !important;
        align-items: center;
        justify-content: center;
        position: absolute; top: 0; left: 0; width: 100%;
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
        opacity: 1; z-index: 10;
        transition: background 0.2s, transform 0.2s;
    }
    .ap-modal-media .carousel-control-prev { left: 16px; }
    .ap-modal-media .carousel-control-next { right: 16px; }
    .ap-modal-media .carousel-control-prev:hover,
    .ap-modal-media .carousel-control-next:hover {
        background: var(--white);
        transform: translateY(-50%) scale(1.1);
    }
    .ap-modal-media .carousel-control-prev-icon,
    .ap-modal-media .carousel-control-next-icon { width: 20px; height: 20px; filter: invert(1); }
    .ap-modal-media .carousel-indicators { bottom: 16px; gap: 6px; margin: 0; }
    .ap-modal-media .carousel-indicators button {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        border: none; transition: all 0.2s; padding: 0; margin: 0;
    }
    .ap-modal-media .carousel-indicators button.active { background: var(--white); transform: scale(1.4); }

    /* Sidebar */
    .ap-modal-sidebar {
        width: min(400px, 38vw);
        min-width: 320px;
        min-height: 0;
        flex-shrink: 0;
        background: var(--white);
        display: flex; flex-direction: column;
        border-left: 1px solid var(--warm-gray);
    }

    .ap-modal-header {
        padding: 16px 18px;
        border-bottom: 1px solid var(--warm-gray);
        display: flex; align-items: center;
        justify-content: space-between; gap: 10px;
    }

    .ap-modal-header-left { display: flex; align-items: center; gap: 6px; }

    .ap-modal-action {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: var(--cream);
        border: none; cursor: pointer;
        display: grid; place-items: center;
        transition: background 0.2s, transform 0.2s;
    }
    .ap-modal-action:hover { background: var(--warm-gray); transform: scale(1.08); }

    .ap-modal-save {
        height: 40px;
        padding: 0 18px;
        border: none;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-h) 100%);
        color: var(--white);
        font-size: 13px;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(200, 83, 58, 0.22);
        transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        cursor: pointer;
    }
    .ap-modal-save:hover {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-h) 100%);
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(200, 83, 58, 0.28);
        filter: saturate(1.05);
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

    .ap-modal-author {
        padding: 16px 18px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .ap-author-row { display: flex; align-items: center; gap: 11px; margin-bottom: 10px; }

    .ap-author-avatar {
        width: 42px; height: 42px;
        border-radius: 50%; object-fit: cover;
        border: 2px solid var(--warm-gray); flex-shrink: 0;
    }

    .ap-author-name {
        font-size: 14.5px; font-weight: 600;
        color: var(--black); text-decoration: none;
    }
    .ap-author-name:hover { color: var(--accent); }
    .ap-author-time { font-size: 12px; color: var(--muted); display: block; margin-top: 1px; }

    .ap-modal-caption { font-size: 14px; color: #444; line-height: 1.6; margin-bottom: 10px; }

    .ap-modal-stats { display: flex; gap: 16px; }
    .ap-modal-stat {
        display: flex; align-items: center; gap: 5px;
        font-size: 13px; font-weight: 600; color: var(--muted);
    }

    /* Comments */
    .ap-modal-comments {
        flex: 1; overflow-y: auto; padding: 14px 18px;
    }
    .ap-modal-comments::-webkit-scrollbar { width: 4px; }
    .ap-modal-comments::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 10px; }

    .ap-comment { display: flex; gap: 10px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid var(--cream); }
    .ap-comment:last-child { border-bottom: none; }

    .ap-comment-avatar {
        width: 32px; height: 32px;
        border-radius: 50%; object-fit: cover;
        flex-shrink: 0; border: 1.5px solid var(--warm-gray);
    }

    .ap-comment-body { flex: 1; }

    .ap-comment-author { font-size: 13px; font-weight: 600; color: var(--black); text-decoration: none; }
    .ap-comment-author:hover { color: var(--accent); }

    .ap-comment-text { font-size: 13px; color: #444; line-height: 1.5; margin-top: 2px; display: block; }

    .ap-comment-meta { display: flex; align-items: center; gap: 12px; margin-top: 5px; }
    .ap-comment-time { font-size: 11px; color: var(--muted); }

    .ap-comment-action-btn {
        background: none; border: none;
        font-size: 11.5px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        color: var(--muted); cursor: pointer; padding: 0;
        transition: color 0.2s;
    }
    .ap-comment-action-btn:hover { color: var(--black); }
    .ap-comment-action-btn.danger { color: #c0392b; }

    .ap-replies-nest {
        margin-left: 42px; margin-top: 8px;
        padding-left: 12px;
        border-left: 2px solid var(--warm-gray);
    }

    /* Comment input */
    .ap-comment-form-wrap {
        padding: 12px 18px;
        border-top: 1px solid var(--warm-gray);
    }

    .ap-reply-indicator {
        display: none;
        background: var(--accent-soft);
        border-radius: var(--r-sm);
        padding: 5px 11px;
        margin-bottom: 8px;
        font-size: 12px; color: var(--accent); font-weight: 500;
        align-items: center; justify-content: space-between;
    }
    .ap-reply-indicator.show { display: flex; }
    .ap-cancel-reply { background: none; border: none; font-size: 11.5px; color: var(--accent); cursor: pointer; font-family: 'DM Sans', sans-serif; font-weight: 600; }

    .ap-comment-input-row { display: flex; align-items: center; gap: 8px; }
    .ap-comment-input-row input {
        flex: 1; height: 38px;
        background: var(--cream);
        border: 1.5px solid transparent;
        border-radius: 38px;
        padding: 0 16px;
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        color: var(--black);
    }
    .ap-comment-input-row input::placeholder { color: var(--muted); }
    .ap-comment-input-row input:focus { background: var(--white); border-color: var(--accent); }

    .ap-comment-submit {
        height: 38px; padding: 0 16px;
        background: var(--accent); color: var(--white);
        border: none; border-radius: 38px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; transition: background 0.2s;
        white-space: nowrap;
    }
    .ap-comment-submit:hover:not(:disabled) { background: var(--accent-h); }
    .ap-comment-submit:disabled { opacity: 0.4; cursor: not-allowed; }

    /* Dropdown */
    .dropdown-menu {
        border: 1px solid var(--warm-gray);
        border-radius: var(--r-md);
        box-shadow: var(--shadow-md);
        padding: 6px;
        font-family: 'DM Sans', sans-serif;
    }
    .dropdown-item { border-radius: var(--r-sm); padding: 8px 13px; font-size: 13.5px; color: var(--black); transition: background 0.15s; }
    .dropdown-item:hover { background: var(--cream); }
    .dropdown-item.text-danger { color: #c0392b !important; }
    .dropdown-item.text-danger:hover { background: #fdf2f2; }

    /* Toast */
    .ap-toast {
        position: fixed; top: 80px; right: 24px;
        z-index: 99999; padding: 12px 18px;
        border-radius: var(--r-md); font-size: 13.5px;
        font-weight: 500; font-family: 'DM Sans', sans-serif;
        box-shadow: var(--shadow-lg);
        animation: toastIn 0.3s ease; max-width: 300px;
    }
    .ap-toast.success { background: #1a7431; color: var(--white); }
    .ap-toast.error   { background: #c0392b; color: var(--white); }

    @keyframes toastIn {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .pr-card-wrap, .pr-posts { padding: 0 16px; }
        .pr-card-body { flex-direction: column; align-items: center; text-align: center; padding: 24px 20px 20px; gap: 16px; }
        .pr-avatar-wrap { margin-top: 0; }
        .pr-avatar { width: 96px; height: 96px; }
        .pr-info-top { flex-direction: column; align-items: center; }
        .pr-actions { justify-content: center; }
        .pr-stats { justify-content: center; }
        .ap-detail-modal .modal-dialog {
            width: 100%;
            height: 100dvh;
            margin: 0;
        }
        .ap-detail-modal .modal-content { border-radius: 0; }
        .ap-detail-modal .modal-body {
            flex-direction: column;
            overflow-y: auto;
            background: var(--white);
        }
        .ap-modal-media {
            flex: none;
            width: 100%;
            height: min(58dvh, 460px);
            min-height: 280px;
            padding: 12px;
        }
        .ap-modal-sidebar {
            width: 100%;
            min-width: 0;
            min-height: auto;
            border-left: none;
            border-top: 1px solid var(--warm-gray);
        }
        .ap-modal-header {
            position: sticky;
            top: 0;
            z-index: 4;
            background: var(--white);
        }
        .ap-modal-comments {
            overflow: visible;
            max-height: none;
        }
    }

    @media (max-width: 480px) {
        .ap-modal-header,
        .ap-modal-author,
        .ap-modal-comments,
        .ap-comment-form-wrap {
            padding-left: 14px;
            padding-right: 14px;
        }
        .ap-modal-header {
            flex-wrap: wrap;
            align-items: flex-start;
        }
        .ap-modal-header-left { flex-wrap: wrap; }
        .ap-modal-save { width: 100%; }
        .ap-modal-media .carousel-control-prev,
        .ap-modal-media .carousel-control-next {
            width: 38px;
            height: 38px;
        }
    }
</style>

<div class="pr-page">

    {{-- ── Banner ── --}}
    <div class="pr-banner">
        <div class="pr-banner-inner"></div>
        <div class="pr-banner-lines"></div>
    </div>

    {{-- ── Profile Card ── --}}
    <div class="pr-card-wrap">
        <div class="pr-card">
            <div class="pr-card-body">

                {{-- Avatar --}}
                <div class="pr-avatar-wrap">
                    <img src="{{ $user?->avatar_display ?? 'https://ui-avatars.com/api/?name=User&background=0a0a0a&color=fff' }}"
                         alt="Avatar" class="pr-avatar">
                </div>

                {{-- Info --}}
                <div class="pr-info">
                    <div class="pr-info-top">
                        <div>
                            <div class="pr-name">{{ $user->name ?? $user->username }}</div>
                            <div class="pr-handle">@<i>{{ strtolower(str_replace('', '', $user->username ?? $user->name)) }}</i></div>
                        </div>

                        <div class="pr-actions">
                            @auth
                                @if(auth()->id() === $user->id)
                                    <a href="{{ route('user.postingan.create') }}" class="pr-btn pr-btn-primary">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                            <path d="M6.5 2v9M2 6.5h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                        Buat Postingan
                                    </a>
                                    <a href="{{ route('user.avatar.create') }}" class="pr-btn pr-btn-secondary">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                            <path d="M9.5 2.5l1 1-7 7H2.5v-1l7-7z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Edit Profil
                                    </a>
                                @else
                                    <button class="pr-btn pr-btn-follow btn-follow-ajax" data-user-id="{{ $user->id }}">
                                        @if(auth()->user()->isFollowing($user->id))
                                            Berhenti Mengikuti
                                        @else
                                            Ikuti
                                        @endif
                                    </button>
                                    <a href="{{ route('user.chat.index', ['user' => $user->id]) }}" class="pr-btn pr-btn-secondary">Pesan</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="pr-btn pr-btn-follow">Masuk untuk Mengikuti</a>
                            @endauth
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="pr-stats">
                        <div class="pr-stat">
                            <span class="pr-stat-num">{{ $totalPost }}</span>
                            <span class="pr-stat-label">Postingan</span>
                        </div>
                        <div class="pr-stat">
                            <span class="pr-stat-num">{{ $user->followers->count() }}</span>
                            <span class="pr-stat-label">Pengikut</span>
                        </div>
                        <div class="pr-stat">
                            <span class="pr-stat-num">{{ $user->following->count() }}</span>
                            <span class="pr-stat-label">Mengikuti</span>
                        </div>
                        <div class="pr-stat">
                            <span class="pr-stat-num">{{ $totalLike }}</span>
                            <span class="pr-stat-label">Disukai</span>
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div class="pr-bio">
                        <p>{{ $user->profile->bio ?? 'Belum ada bio.' }}</p>
                        <div class="pr-meta">
                            <div class="pr-meta-item">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <rect x="1.5" y="2" width="10" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                    <path d="M1.5 5h10M4 1v2M9 1v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                </svg>
                                Bergabung {{ optional($user->created_at)->format('F Y') ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Posts Section ── --}}
    <div class="pr-posts">
        <div class="pr-posts-header">
            <h2 class="pr-posts-title">Postingan</h2>
            <!-- <div class="pr-view-toggle">
                <button class="pr-toggle-btn active">Grid</button>
                <button class="pr-toggle-btn">List</button>
            </div> -->
        </div>

        @if($posts->count() > 0)
            <div class="pr-grid">
                @foreach($posts as $post)
                    <div class="pr-post-item" data-bs-toggle="modal" data-bs-target="#postModal{{ $post->id }}">
                        @if($post->photos && $post->photos->first())
                            <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="" loading="lazy">
                        @else
                            <img src="https://via.placeholder.com/300x300/e8e4df/b8b3ac?text=No+Image" alt="">
                        @endif

                        @if($post->photos && $post->photos->count() > 1)
                            <div class="pr-multi-badge">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                    <rect x="1" y="3" width="6" height="6" rx="1" stroke="white" stroke-width="1.2"/>
                                    <path d="M3 3V2a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H7" stroke="white" stroke-width="1.2"/>
                                </svg>
                                {{ $post->photos->count() }}
                            </div>
                        @endif

                        <div class="pr-post-overlay">
                            <div class="pr-overlay-stat">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                    <path d="M7.5 12.5S2 9.5 2 5.5A3.5 3.5 0 017.5 3 3.5 3.5 0 0113 5.5C13 9.5 7.5 12.5 7.5 12.5z" stroke="white" stroke-width="1.4" fill="white"/>
                                </svg>
                                {{ $post->likes->count() }}
                            </div>
                            <div class="pr-overlay-stat">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                    <path d="M12 1.5H3a.5.5 0 00-.5.5v7a.5.5 0 00.5.5H5l2.5 2.5L10 9.5h2a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="white" stroke-width="1.4" fill="white"/>
                                </svg>
                                {{ $post->comments->count() }}
                            </div>
                        </div>
                    </div>

                    {{-- ── Detail Modal ── --}}
                    <div class="modal fade ap-detail-modal" id="postModal{{ $post->id }}" tabindex="-1">
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
                                        <div class="ap-modal-header">
                                            <div class="ap-modal-header-left">
                                                <button class="ap-modal-action like-modal-btn"
                                                        data-post-id="{{ $post->id }}"
                                                        data-liked="{{ $post->isLikedBy(auth()->id()) ? '1' : '0' }}">
                                                    @if($post->isLikedBy(auth()->id()))
                                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="#c8533a"><path d="M8.5 14.5S2 10.5 2 6A4 4 0 018.5 2.8 4 4 0 0115 6C15 10.5 8.5 14.5 8.5 14.5z"/></svg>
                                                    @else
                                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"><path d="M8.5 14.5S2 10.5 2 6A4 4 0 018.5 2.8 4 4 0 0115 6C15 10.5 8.5 14.5 8.5 14.5z" stroke="#888" stroke-width="1.6"/></svg>
                                                    @endif
                                                </button>
                                                @auth
                                                    @if(auth()->id() === $post->user_id)
                                                        <div class="dropdown">
                                                            <button class="ap-modal-action" type="button" data-bs-toggle="dropdown">
                                                                <svg width="14" height="4" viewBox="0 0 14 4" fill="#888">
                                                                    <circle cx="2" cy="2" r="1.3"/><circle cx="7" cy="2" r="1.3"/><circle cx="12" cy="2" r="1.3"/>
                                                                </svg>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="{{ route('user.postingan.edit', $post) }}">✏️ Edit</a></li>
                                                                <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                                                    @csrf @method('DELETE')
                                                                    <li><button class="dropdown-item text-danger" onclick="return confirm('Hapus postingan?')">🗑️ Hapus</button></li>
                                                                </form>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endauth
                                                <button class="ap-modal-action" data-bs-dismiss="modal">
                                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                        <path d="M1 1l11 11M12 1L1 12" stroke="#888" stroke-width="1.7" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
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
                                                                <span>Download semua foto</span>
                                                                <span>{{ $post->photos->count() }}</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @elseif($post->photos && $post->photos->first())
                                                <a href="{{ route('user.postingan.download', ['post' => $post->id]) }}" class="ap-modal-save">Download</a>
                                            @endif
                                        </div>

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
                                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                        <path d="M6.5 11S1.5 8 1.5 4.5A2.5 2.5 0 016.5 2.7 2.5 2.5 0 0111.5 4.5C11.5 8 6.5 11 6.5 11z" stroke="#c8533a" stroke-width="1.4"/>
                                                    </svg>
                                                    {{ $post->likes->count() }} suka
                                                </span>
                                                <span class="ap-modal-stat">
                                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                        <path d="M10.5 1.5h-8a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4l2.5 2.5 2.5-2.5h1.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#888" stroke-width="1.3"/>
                                                    </svg>
                                                    {{ $post->comments->count() }} komentar
                                                </span>
                                            </div>
                                        </div>

                                        <div class="ap-modal-comments" id="comments-container-{{ $post->id }}">
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
                                                                        <button class="ap-comment-action-btn danger delete-comment-btn" data-id="{{ $comment->id }}" data-url="{{ route('user.comments.destroy', $comment->id) }}">Hapus</button>
                                                                    @endif
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
                                                                                    <button class="ap-comment-action-btn danger delete-comment-btn" data-id="{{ $reply->id }}" data-url="{{ route('user.comments.destroy', $reply->id) }}">Hapus</button>
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
                                                <p class="text-center" style="color:var(--muted);font-size:13.5px;padding:28px 0;" id="nc-{{ $post->id }}">Belum ada komentar.</p>
                                            @endforelse
                                        </div>

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
                                                    <input type="text" name="comment" class="comment-input" placeholder="Tulis komentar…" autocomplete="off" required>
                                                    <button type="submit" class="ap-comment-submit" disabled>Kirim</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div style="padding:12px 18px;text-align:center;border-top:1px solid var(--warm-gray);">
                                            <a href="{{ route('login') }}" style="font-size:13px;color:var(--accent);font-weight:600;">Masuk untuk berkomentar</a>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="pr-empty">
                <div class="pr-empty-icon">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                        <rect x="2" y="4" width="22" height="18" rx="3" stroke="#b8b3ac" stroke-width="1.6"/>
                        <circle cx="13" cy="13" r="4" stroke="#b8b3ac" stroke-width="1.6"/>
                        <circle cx="19.5" cy="8" r="1.2" fill="#b8b3ac"/>
                    </svg>
                </div>
                <h4>Belum Ada Postingan</h4>
                <p>{{ auth()->check() && auth()->id() === $user->id ? 'Mulai bagikan momen pertamamu!' : 'User ini belum membuat postingan.' }}</p>
                @auth @if(auth()->id() === $user->id)
                    <a href="{{ route('user.postingan.create') }}" class="pr-btn pr-btn-primary" style="margin:0 auto;">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M6.5 2v9M2 6.5h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Unggah Foto
                    </a>
                @endif @endauth
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── View toggle ──────────────────────────────────────────────────
    document.querySelectorAll('.pr-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.pr-toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // ── Follow AJAX ──────────────────────────────────────────────────
    document.querySelectorAll('.btn-follow-ajax').forEach(btn => {
        btn.addEventListener('click', function () {
            const userId = this.dataset.userId;
            fetch(`{{ route('user.profile.follow', ':id') }}`.replace(':id', userId), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                this.textContent = data.following ? 'Berhenti Mengikuti' : 'Ikuti';
                this.classList.toggle('pr-btn-follow', !data.following);
                this.classList.toggle('pr-btn-following', data.following);
            })
            .catch(console.error);
        });
    });

    // ── Like AJAX ────────────────────────────────────────────────────
    document.querySelectorAll('.like-modal-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`{{ route('user.post.like', ':id') }}`.replace(':id', postId), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                this.innerHTML = data.liked
                    ? `<svg width="17" height="17" viewBox="0 0 17 17" fill="#c8533a"><path d="M8.5 14.5S2 10.5 2 6A4 4 0 018.5 2.8 4 4 0 0115 6C15 10.5 8.5 14.5 8.5 14.5z"/></svg>`
                    : `<svg width="17" height="17" viewBox="0 0 17 17" fill="none"><path d="M8.5 14.5S2 10.5 2 6A4 4 0 018.5 2.8 4 4 0 0115 6C15 10.5 8.5 14.5 8.5 14.5z" stroke="#888" stroke-width="1.6"/></svg>`;
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
            btn.disabled = true; btn.textContent = '…';

            fetch('{{ route("user.comments.store") }}', {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const postId = this.dataset.postId;
                    const container = document.getElementById('comments-container-' + postId);
                    const noMsg = document.getElementById('nc-' + postId);
                    if (noMsg) noMsg.remove();

                    if (data.comment.reply_id) {
                        let pw = document.getElementById('cw-' + data.comment.reply_id);
                        if (pw) {
                            let nest = pw.querySelector('.ap-replies-nest');
                            if (!nest) { nest = document.createElement('div'); nest.className = 'ap-replies-nest'; pw.appendChild(nest); }
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
            .catch(() => showToast('error', 'Gagal mengirim'))
            .finally(() => { btn.disabled = false; btn.textContent = 'Kirim'; });
        });
    });

    // ── Reply ────────────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('reply-btn')) {
            const id = e.target.dataset.id, username = e.target.dataset.username;
            const modal = e.target.closest('.ap-detail-modal');
            if (!modal) return;
            const form = modal.querySelector('.comment-form-ajax');
            const postId = form.dataset.postId;
            form.querySelector('.reply-id-input').value = id;
            form.querySelector('.reply-to-username').textContent = username;
            document.getElementById('ri-' + postId)?.classList.add('show');
            form.querySelector('.comment-input').focus();
        }
        if (e.target.classList.contains('ap-cancel-reply')) {
            const form = e.target.closest('.comment-form-ajax');
            form.querySelector('.reply-id-input').value = '';
            document.getElementById('ri-' + form.dataset.postId)?.classList.remove('show');
        }
    });

    // ── Delete comment ───────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (!e.target.classList.contains('delete-comment-btn')) return;
        if (!confirm('Hapus komentar ini?')) return;
        const id = e.target.dataset.id, url = e.target.dataset.url;
        fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const cw = document.getElementById('cw-' + id);
                if (cw) cw.remove();
                else document.getElementById('c-' + id)?.remove();
                showToast('success', 'Komentar dihapus');
            } else showToast('error', 'Gagal menghapus');
        });
    });

    // ── Toast ────────────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        const trigger = e.target.closest('.download-all-btn');
        if (!trigger) return;

        e.preventDefault();

        let urls = [];
        try {
            urls = JSON.parse(trigger.dataset.downloadUrls || '[]');
        } catch (error) {
            urls = [];
        }

        if (!urls.length) {
            showToast('error', 'Foto tidak ditemukan');
            return;
        }

        showToast('success', 'Menyiapkan download semua foto...');

        urls.forEach((url, index) => {
            setTimeout(() => {
                const frame = document.createElement('iframe');
                frame.style.display = 'none';
                frame.src = url;
                document.body.appendChild(frame);
                setTimeout(() => frame.remove(), 20000);
            }, index * 700);
        });
    });

    function showToast(type, msg) {
        const t = document.createElement('div');
        t.className = 'ap-toast ' + type;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 3200);
    }

    // ── Carousels ────────────────────────────────────────────────────
    document.querySelectorAll('.carousel').forEach(el => {
        new bootstrap.Carousel(el, { interval: false, wrap: true, touch: true });
    });
});
</script>

@endsection
