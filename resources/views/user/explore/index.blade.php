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

    /* ── Override layout ── */
    .container-fluid { padding: 0 !important; max-width: 100% !important; }
    .body-wrapper    { margin-top: 0 !important; }

    /* ===================== PAGE ===================== */
    .ex-page {
        background: var(--cream);
        min-height: calc(100vh - 64px);
        padding: 32px 0 80px;
    }

    .ex-inner {
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 40px;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 1100px) { .ex-inner { grid-template-columns: 200px 1fr; gap: 20px; } }
    @media (max-width: 860px)  { .ex-inner { grid-template-columns: 1fr; } }
    @media (max-width: 600px)  { .ex-inner { padding: 0 16px; } }

    /* ===================== SIDEBAR ===================== */
    .ex-sidebar {
        position: sticky;
        top: 80px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Search box */
    .ex-search-box {
        background: var(--white);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
        padding: 16px;
    }

    .ex-search-wrap {
        position: relative;
        margin-bottom: 10px;
    }

    .ex-search-wrap input {
        width: 100%;
        height: 40px;
        background: var(--cream);
        border: 1.5px solid transparent;
        border-radius: 40px;
        padding: 0 16px 0 40px;
        font-size: 13.5px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: border-color .2s, background .2s;
    }

    .ex-search-wrap input:focus {
        background: var(--white);
        border-color: var(--accent);
    }

    .ex-search-wrap input::placeholder { color: var(--muted); }

    .ex-search-icon {
        position: absolute;
        left: 13px; top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
        display: flex;
    }

    .ex-search-btn {
        width: 100%;
        height: 36px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: 36px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background .2s;
    }

    .ex-search-btn:hover { background: #222; }

    /* Category card */
    .ex-cat-card {
        background: var(--white);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .ex-cat-header {
        padding: 16px 18px 12px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .ex-cat-list { padding: 8px; }

    .ex-cat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: var(--r-sm);
        font-size: 13.5px;
        font-weight: 500;
        color: var(--black);
        text-decoration: none;
        transition: background .15s, color .15s, padding-left .2s;
        cursor: pointer;
    }

    .ex-cat-item:hover {
        background: var(--cream);
        padding-left: 16px;
        color: var(--black);
    }

    .ex-cat-item.active {
        background: var(--black);
        color: var(--white);
        padding-left: 12px;
    }

    .ex-cat-item.active:hover {
        background: #222;
        color: var(--white);
        padding-left: 12px;
    }

    .ex-cat-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--mid-gray);
        flex-shrink: 0;
        transition: background .15s;
    }

    .ex-cat-item.active .ex-cat-dot { background: var(--accent); }
    .ex-cat-item:hover .ex-cat-dot  { background: var(--accent); }

    /* ===================== MAIN ===================== */
    .ex-main { min-width: 0; }

    /* Search bar desktop (top of main) */
    .ex-search-top {
        background: var(--white);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .ex-search-top .ex-search-wrap { flex: 1; margin: 0; }

    .ex-search-top .ex-search-btn {
        width: auto;
        padding: 0 24px;
        height: 40px;
        flex-shrink: 0;
    }

    /* Section heading */
    .ex-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .ex-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 400;
        color: var(--black);
    }

    .ex-count {
        font-size: 13px;
        color: var(--muted);
        font-weight: 500;
    }

    /* ===================== MASONRY ===================== */
    .ap-grid {
        columns: 4;
        column-gap: 18px;
    }

    @media (max-width: 1300px) { .ap-grid { columns: 3; } }
    @media (max-width: 900px)  { .ap-grid { columns: 2; column-gap: 14px; } }
    @media (max-width: 480px)  { .ap-grid { columns: 2; column-gap: 10px; } }

    /* ===================== POST CARD ===================== */
    .ap-card {
        break-inside: avoid;
        margin-bottom: 18px;
        border-radius: var(--r-lg);
        overflow: hidden;
        background: var(--white);
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        transition: box-shadow .3s, transform .3s;
        animation: cardReveal .5s ease both;
        position: relative;
    }

    .ap-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-3px);
    }

    @keyframes cardReveal {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ap-card:nth-child(1) { animation-delay:.05s; }
    .ap-card:nth-child(2) { animation-delay:.10s; }
    .ap-card:nth-child(3) { animation-delay:.15s; }
    .ap-card:nth-child(4) { animation-delay:.20s; }
    .ap-card:nth-child(5) { animation-delay:.25s; }
    .ap-card:nth-child(6) { animation-delay:.30s; }

    .ap-card-img-wrap {
        position: relative;
        overflow: hidden;
        background: var(--warm-gray);
    }

    .ap-card-img-wrap img {
        width: 100%; height: auto;
        display: block;
        transition: transform .5s cubic-bezier(.4,0,.2,1);
    }

    .ap-card:hover .ap-card-img-wrap img { transform: scale(1.06); }

    .ap-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, transparent 40%, rgba(10,10,10,.55));
        opacity: 0;
        transition: opacity .3s;
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
        height: 32px; padding: 0 16px;
        border-radius: 32px; border: none;
        background: var(--accent); color: var(--white);
        font-size: 12.5px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; transition: background .2s, transform .15s;
    }

    .ap-save-btn:hover { background: var(--accent-h); transform: scale(1.05); }

    .ap-overlay-actions { display: flex; gap: 7px; }

    .ap-icon-btn {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,.92);
        border: none; cursor: pointer;
        display: grid; place-items: center;
        transition: transform .2s, background .2s;
        backdrop-filter: blur(4px);
    }

    .ap-icon-btn:hover { transform: scale(1.12); background: var(--white); }

    .ap-multi-badge {
        position: absolute;
        top: 9px; left: 9px;
        background: rgba(10,10,10,.6);
        color: var(--white);
        font-size: 11px; font-weight: 500;
        padding: 3px 9px; border-radius: 20px;
        backdrop-filter: blur(4px);
        display: flex; align-items: center; gap: 4px;
    }

    .ap-card-body { padding: 12px 14px 14px; }

    .ap-card-user {
        display: flex; align-items: center;
        gap: 8px; margin-bottom: 7px;
    }

    .ap-card-avatar {
        width: 26px; height: 26px;
        border-radius: 50%; object-fit: cover;
        border: 1.5px solid var(--warm-gray); flex-shrink: 0;
    }

    .ap-card-username {
        font-size: 12.5px; font-weight: 600;
        color: var(--black); text-decoration: none;
        transition: color .2s;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .ap-card-username:hover { color: var(--accent); }

    .ap-card-caption {
        font-size: 13px; color: #555;
        line-height: 1.5; margin-bottom: 9px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ap-card-stats {
        display: flex; align-items: center; gap: 12px;
    }

    .ap-stat {
        display: flex; align-items: center;
        gap: 4px; font-size: 12px;
        color: var(--muted); font-weight: 500;
    }

    /* ===================== EMPTY ===================== */
    .ex-empty {
        text-align: center;
        padding: 80px 24px;
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-sm);
    }

    .ex-empty-icon {
        width: 64px; height: 64px;
        background: var(--cream);
        border-radius: 50%;
        display: grid; place-items: center;
        margin: 0 auto 20px;
    }

    .ex-empty h4 {
        font-family: 'Playfair Display', serif;
        font-size: 20px; font-weight: 400;
        color: var(--black); margin-bottom: 8px;
    }

    .ex-empty p { font-size: 14px; color: var(--muted); }

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
        display: flex; flex-direction: column;
        box-shadow: 0 30px 80px rgba(10,10,10,.3);
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
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; position: relative;
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
        height: 100%; display: flex !important;
        align-items: center; justify-content: center;
        position: absolute; top: 0; left: 0; width: 100%;
        opacity: 0; transition: opacity .35s ease;
    }
    .ap-modal-media .carousel-item.active { position: relative; opacity: 1; }

    .ap-modal-media .carousel-control-prev,
    .ap-modal-media .carousel-control-next {
        width: 44px; height: 44px;
        background: rgba(255,255,255,.9);
        backdrop-filter: blur(8px);
        border-radius: 50%; top: 50%; transform: translateY(-50%);
        opacity: 1; z-index: 10; transition: background .2s, transform .2s;
    }
    .ap-modal-media .carousel-control-prev { left: 16px; }
    .ap-modal-media .carousel-control-next { right: 16px; }
    .ap-modal-media .carousel-control-prev:hover,
    .ap-modal-media .carousel-control-next:hover {
        background: var(--white); transform: translateY(-50%) scale(1.1);
    }
    .ap-modal-media .carousel-control-prev-icon,
    .ap-modal-media .carousel-control-next-icon { width: 20px; height: 20px; filter: invert(1); }
    .ap-modal-media .carousel-indicators { bottom: 16px; gap: 6px; margin: 0; }
    .ap-modal-media .carousel-indicators button {
        width: 6px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,.5); border: none;
        transition: all .2s; padding: 0; margin: 0;
    }
    .ap-modal-media .carousel-indicators button.active { background: var(--white); transform: scale(1.4); }

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
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--cream); border: none; cursor: pointer;
        display: grid; place-items: center;
        transition: background .2s, transform .2s;
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
        width: 42px; height: 42px; border-radius: 50%;
        object-fit: cover; border: 2px solid var(--warm-gray); flex-shrink: 0;
    }

    .ap-author-name { font-size: 14.5px; font-weight: 600; color: var(--black); text-decoration: none; }
    .ap-author-name:hover { color: var(--accent); }
    .ap-author-time { font-size: 12px; color: var(--muted); display: block; margin-top: 1px; }

    .ap-modal-caption { font-size: 14px; color: #444; line-height: 1.6; margin-bottom: 10px; }

    .ap-modal-stats { display: flex; gap: 16px; }
    .ap-modal-stat { display: flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; color: var(--muted); }

    .ap-modal-comments { flex: 1; overflow-y: auto; padding: 14px 18px; }
    .ap-modal-comments::-webkit-scrollbar { width: 4px; }
    .ap-modal-comments::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 10px; }

    .ap-comment { display: flex; gap: 10px; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid var(--cream); }
    .ap-comment:last-child { border-bottom: none; }

    .ap-comment-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        object-fit: cover; flex-shrink: 0; border: 1.5px solid var(--warm-gray);
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
        transition: color .2s;
    }
    .ap-comment-action-btn:hover { color: var(--black); }
    .ap-comment-action-btn.danger { color: #c0392b; }

    .ap-replies-nest {
        margin-left: 42px; margin-top: 8px;
        padding-left: 12px; border-left: 2px solid var(--warm-gray);
    }

    .ap-comment-form-wrap {
        padding: 12px 18px;
        border-top: 1px solid var(--warm-gray);
    }

    .ap-reply-indicator {
        display: none;
        background: var(--accent-soft);
        border-radius: var(--r-sm);
        padding: 5px 11px; margin-bottom: 8px;
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
        border-radius: 38px; padding: 0 16px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        outline: none; transition: border-color .2s, background .2s; color: var(--black);
    }
    .ap-comment-input-row input::placeholder { color: var(--muted); }
    .ap-comment-input-row input:focus { background: var(--white); border-color: var(--accent); }

    .ap-comment-submit {
        height: 38px; padding: 0 16px;
        background: var(--accent); color: var(--white);
        border: none; border-radius: 38px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; transition: background .2s; white-space: nowrap;
    }
    .ap-comment-submit:hover:not(:disabled) { background: var(--accent-h); }
    .ap-comment-submit:disabled { opacity: .4; cursor: not-allowed; }

    /* Report Modal */
    .ap-report-modal .modal-dialog { max-width: 480px; }
    .ap-report-modal .modal-content { border: none; border-radius: var(--r-xl); box-shadow: var(--shadow-lg); overflow: hidden; }
    .ap-report-modal .modal-header { padding: 22px 26px 14px; border-bottom: 1px solid var(--warm-gray); }
    .ap-report-modal .modal-title { font-size: 17px; font-weight: 600; color: var(--black); }
    .ap-report-modal .modal-body { padding: 18px 26px; }
    .ap-report-modal .form-label { font-size: 13.5px; font-weight: 600; color: var(--black); display: block; margin-bottom: 7px; }
    .ap-report-modal .form-select,
    .ap-report-modal .form-control {
        border: 1.5px solid var(--warm-gray); border-radius: var(--r-md);
        padding: 10px 14px; font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        background: var(--cream); outline: none;
        transition: border-color .2s; width: 100%; color: var(--black);
    }
    .ap-report-modal .form-select:focus,
    .ap-report-modal .form-control:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(200,83,58,.12); }
    .ap-report-modal .modal-footer { padding: 12px 26px 22px; border-top: 1px solid var(--warm-gray); display: flex; gap: 10px; }
    .ap-report-modal .btn-cancel { flex: 1; height: 40px; background: var(--cream); border: none; border-radius: var(--r-md); font-size: 13.5px; font-weight: 600; font-family: 'DM Sans', sans-serif; color: var(--black); cursor: pointer; transition: background .2s; }
    .ap-report-modal .btn-cancel:hover { background: var(--warm-gray); }
    .ap-report-modal .btn-submit-report { flex: 1; height: 40px; background: #c0392b; border: none; border-radius: var(--r-md); font-size: 13.5px; font-weight: 600; font-family: 'DM Sans', sans-serif; color: var(--white); cursor: pointer; transition: background .2s; }
    .ap-report-modal .btn-submit-report:hover { background: #a93226; }

    /* Dropdown */
    .dropdown-menu { border: 1px solid var(--warm-gray); border-radius: var(--r-md); box-shadow: var(--shadow-md); padding: 6px; font-family: 'DM Sans', sans-serif; }
    .dropdown-item { border-radius: var(--r-sm); padding: 8px 13px; font-size: 13.5px; color: var(--black); transition: background .15s; }
    .dropdown-item:hover { background: var(--cream); }
    .dropdown-item.text-danger { color: #c0392b !important; }
    .dropdown-item.text-danger:hover { background: #fdf2f2; }

    /* Toast */
    .ap-toast { position: fixed; top: 80px; right: 24px; z-index: 99999; padding: 12px 18px; border-radius: var(--r-md); font-size: 13.5px; font-weight: 500; font-family: 'DM Sans', sans-serif; box-shadow: var(--shadow-lg); animation: toastIn .3s ease; max-width: 300px; }
    .ap-toast.success { background: #1a7431; color: var(--white); }
    .ap-toast.error   { background: #c0392b; color: var(--white); }
    @keyframes toastIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }

    /* Responsive modal */
    @media (max-width: 860px) {
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
        .ex-sidebar { position: static; }
    }
    @media (max-width: 480px) {
        .ex-page { padding: 20px 0 56px; }
        .ex-inner { padding: 0 12px; }
        .ex-heading { margin-bottom: 14px; }
        .ex-title { font-size: 20px; }
        .ap-card {
            margin-bottom: 10px;
            border-radius: 16px;
        }
        .ap-card-body {
            display: none;
        }
        .ap-card-overlay {
            padding: 10px;
        }
        .ap-multi-badge {
            top: 8px;
            left: 8px;
            font-size: 10px;
            padding: 3px 8px;
        }
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

<div class="ex-page">
    <div class="ex-inner">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="ex-sidebar">

            {{-- Search --}}
            <div class="ex-search-box">
                <form action="{{ route('user.explore.search') }}" method="GET">
                    <div class="ex-search-wrap">
                        <span class="ex-search-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <circle cx="6.5" cy="6.5" r="5" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M10.5 10.5L13.5 13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <input type="text" name="q" placeholder="Cari postingan…" value="{{ $searchQuery ?? '' }}">
                    </div>
                    <button type="submit" class="ex-search-btn">Cari</button>
                </form>
            </div>

            {{-- Categories --}}
            <div class="ex-cat-card">
                <div class="ex-cat-header">Kategori</div>
                <div class="ex-cat-list">
                    <a href="{{ route('user.explore.halaman') }}"
                       class="ex-cat-item {{ !isset($selectedCategory) ? 'active' : '' }}">
                        <span class="ex-cat-dot"></span>
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('user.explore.category', $category->id) }}"
                           class="ex-cat-item {{ isset($selectedCategory) && $selectedCategory->id === $category->id ? 'active' : '' }}">
                            <span class="ex-cat-dot"></span>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

        </aside>

        {{-- ══ MAIN ══ --}}
        <main class="ex-main">

            {{-- Heading --}}
            <div class="ex-heading">
                <h2 class="ex-title">
                    @if(isset($selectedCategory))
                        {{ $selectedCategory->name }}
                    @elseif(isset($searchQuery) && $searchQuery)
                        Hasil: "{{ $searchQuery }}"
                    @else
                        Jelajahi
                    @endif
                </h2>
                @if($posts->count() > 0)
                    <span class="ex-count">{{ $posts->count() }} postingan</span>
                @endif
            </div>

            {{-- Grid --}}
            @if($posts->count() > 0)
                <div class="ap-grid">
                    @foreach($posts as $post)

                        {{-- Card --}}
                        <div class="ap-card" data-bs-toggle="modal" data-bs-target="#exModal{{ $post->id }}">
                            <div class="ap-card-img-wrap">
                                @if($post->photos && $post->photos->first())
                                    <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="" loading="lazy">
                                @else
                                    <img src="https://via.placeholder.com/300x400/e8e4df/b8b3ac?text=No+Image" alt="">
                                @endif

                                @if($post->photos && $post->photos->count() > 1)
                                    <div class="ap-multi-badge">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                                            <rect x="1" y="3" width="6" height="6" rx="1" stroke="white" stroke-width="1.2"/>
                                            <path d="M3 3V2a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H7" stroke="white" stroke-width="1.2"/>
                                        </svg>
                                        {{ $post->photos->count() }}
                                    </div>
                                @endif
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
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M6 10.5S1 7.5 1 4A2.5 2.5 0 016 2.2 2.5 2.5 0 0111 4C11 7.5 6 10.5 6 10.5z" stroke="#c8533a" stroke-width="1.3"/>
                                        </svg>
                                        {{ $post->likes->count() }}
                                    </span>
                                    <span class="ap-stat">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M9.5 1H2.5a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4l2 2 2-2h1.5a.5.5 0 00.5-.5v-6A.5.5 0 009.5 1z" stroke="#888" stroke-width="1.3"/>
                                        </svg>
                                        {{ $post->comments->count() }}
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Detail Modal --}}
                        <div class="modal fade ap-detail-modal" id="exModal{{ $post->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="ap-modal-media">
                                            @if($post->photos && $post->photos->count() > 1)
                                                <div id="exCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="false">
                                                    <div class="carousel-inner">
                                                        @foreach($post->photos as $i => $photo)
                                                            <div class="carousel-item {{ $i==0?'active':'' }}">
                                                                <img src="{{ asset('storage/'.$photo->photo) }}" alt="">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#exCarousel{{ $post->id }}" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#exCarousel{{ $post->id }}" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                                                    <div class="carousel-indicators">
                                                        @foreach($post->photos as $i => $photo)
                                                            <button type="button" data-bs-target="#exCarousel{{ $post->id }}" data-bs-slide-to="{{ $i }}" class="{{ $i==0?'active':'' }}"></button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @elseif($post->photos && $post->photos->first())
                                                <img src="{{ asset('storage/'.$post->photos->first()->photo) }}" alt="">
                                            @else
                                                <img src="https://via.placeholder.com/600x600/1a1a1a/444?text=No+Image" alt="">
                                            @endif
                                        </div>

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
                                                    <button class="ap-modal-action">
                                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                            <circle cx="12" cy="3" r="1.5" stroke="#888" stroke-width="1.4"/>
                                                            <circle cx="3" cy="7.5" r="1.5" stroke="#888" stroke-width="1.4"/>
                                                            <circle cx="12" cy="12" r="1.5" stroke="#888" stroke-width="1.4"/>
                                                            <path d="M4.5 8.5l6 3M4.5 6.5l6-3" stroke="#888" stroke-width="1.4"/>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown">
                                                        <button class="ap-modal-action" type="button" data-bs-toggle="dropdown">
                                                            <svg width="14" height="4" viewBox="0 0 14 4" fill="#888">
                                                                <circle cx="2" cy="2" r="1.3"/><circle cx="7" cy="2" r="1.3"/><circle cx="12" cy="2" r="1.3"/>
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
                                                        <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="ap-author-name">{{ $post->user->username ?? $post->user->name }}</a>
                                                        <span class="ap-author-time">{{ $post->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                                @if($post->caption)
                                                    <p class="ap-modal-caption">{{ $post->caption }}</p>
                                                @endif
                                                <div class="ap-modal-stats">
                                                    <span class="ap-modal-stat like-count" data-post-id="{{ $post->id }}">
                                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M6.5 11S1.5 8 1.5 4.5A2.5 2.5 0 016.5 2.7 2.5 2.5 0 0111.5 4.5C11.5 8 6.5 11 6.5 11z" stroke="#c8533a" stroke-width="1.4"/></svg>
                                                        {{ $post->likes->count() }} suka
                                                    </span>
                                                    <span class="ap-modal-stat">
                                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M10.5 1.5h-8a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4l2.5 2.5 2.5-2.5h1.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#888" stroke-width="1.3"/></svg>
                                                        {{ $post->comments->count() }} komentar
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="ap-modal-comments" id="comments-container-{{ $post->id }}">
                                                @forelse($post->comments->where('reply_id', null) as $comment)
                                                    <div class="comment-wrapper" id="comment-wrapper-{{ $comment->id }}">
                                                        <div class="ap-comment" id="comment-{{ $comment->id }}">
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
                                                                        @if(auth()->id() !== $comment->user_id)
                                                                            <button class="ap-comment-action-btn" data-bs-toggle="modal" data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                                                                        @endif
                                                                    @else
                                                                        <button class="ap-comment-action-btn" data-bs-toggle="modal" data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                                                                    @endauth
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($comment->replies->count() > 0)
                                                            <div class="ap-replies-nest">
                                                                @foreach($comment->replies as $reply)
                                                                    <div class="ap-comment" id="comment-{{ $reply->id }}" style="margin-bottom:10px;">
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
                                                <label class="form-label">Keterangan <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
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

                        @foreach($post->comments as $comment)
                            <div class="modal fade ap-report-modal" id="reportCommentModal{{ $comment->id }}" tabindex="-1">
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
                <div class="ex-empty">
                    <div class="ex-empty-icon">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <rect x="2" y="4" width="22" height="18" rx="3" stroke="#b8b3ac" stroke-width="1.6"/>
                            <circle cx="13" cy="13" r="4" stroke="#b8b3ac" stroke-width="1.6"/>
                            <circle cx="19.5" cy="8" r="1.2" fill="#b8b3ac"/>
                        </svg>
                    </div>
                    <h4>Tidak ada postingan</h4>
                    <p>Coba kata kunci lain atau pilih kategori berbeda</p>
                </div>
            @endif

        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

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
                    document.getElementById('nc-' + postId)?.remove();

                    if (data.comment.reply_id) {
                        let pw = document.getElementById('comment-wrapper-' + data.comment.reply_id);
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
                    document.getElementById('ri-' + postId)?.classList.remove('show');
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
                document.getElementById('comment-wrapper-' + id)?.remove() || document.getElementById('comment-' + id)?.remove();
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
