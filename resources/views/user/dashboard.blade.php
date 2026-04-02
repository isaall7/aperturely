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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
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

    /* ===================== MOBILE RESPONSIVE ===================== */
    @media (max-width: 768px) {
        .ap-feed { padding: 20px 0 60px; }
        .ap-feed-inner { padding: 0 12px; }

        .ap-grid {
            columns: 2 !important;
            column-gap: 10px;
        }

        .ap-card { margin-bottom: 10px; border-radius: 12px; }
        .ap-card-body { display: none; }

        .ap-card-overlay {
            opacity: 1;
            background: linear-gradient(160deg, transparent 55%, rgba(10,10,10,0.5));
        }

        .ap-overlay-top { display: none; }

        .ap-filters {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 8px;
            margin-bottom: 20px;
            padding-bottom: 6px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .ap-filters::-webkit-scrollbar { display: none; }

        .ap-filter-btn {
            flex-shrink: 0;
            height: 32px;
            padding: 0 14px;
            font-size: 12.5px;
        }
    }

    @media (max-width: 360px) {
        .ap-grid { column-gap: 8px; }
        .ap-feed-inner { padding: 0 8px; }
    }

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
        display: block;
        text-decoration: none;
        color: inherit;
    }

    .ap-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-3px);
    }

    @keyframes cardReveal {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

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
        justify-content: flex-end;
    }

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
        text-decoration: none;
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

    /* ===================== SHIMMER SKELETON ===================== */
    @keyframes shimmer {
        0%   { background-position: -800px 0; }
        100% { background-position: 800px 0; }
    }

    .shimmer-wrap {
        break-inside: avoid;
        margin-bottom: 20px;
        border-radius: var(--r-lg);
        overflow: hidden;
        background: var(--white);
        box-shadow: var(--shadow-sm);
    }

    .shimmer-block {
        background: linear-gradient(
            90deg,
            var(--warm-gray) 25%,
            #f0ede8 50%,
            var(--warm-gray) 75%
        );
        background-size: 800px 100%;
        animation: shimmer 1.4s infinite linear;
    }

    .shimmer-img { width: 100%; height: var(--sh-h, 220px); }

    .shimmer-body { padding: 14px 16px 16px; }

    .shimmer-avatar-row {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 10px;
    }

    .shimmer-avatar { width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0; }
    .shimmer-name   { height: 12px; width: 90px; border-radius: 6px; }

    .shimmer-line { height: 11px; border-radius: 6px; margin-bottom: 7px; }
    .shimmer-line.short { width: 65%; }
    .shimmer-line.long  { width: 90%; }

    .shimmer-stats { display: flex; gap: 14px; margin-top: 12px; }
    .shimmer-stat  { height: 10px; width: 36px; border-radius: 6px; }

    #shimmer-grid {
        columns: 5;
        column-gap: 20px;
    }

    @media (max-width: 1400px) { #shimmer-grid { columns: 4; } }
    @media (max-width: 768px)  { #shimmer-grid { columns: 2; column-gap: 10px; } }
    @media (max-width: 360px)  { #shimmer-grid { column-gap: 8px; } }
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

            {{-- SHIMMER SKELETON --}}
            <div id="shimmer-grid" aria-hidden="true">
                @php $heights = [180, 240, 300, 200, 260, 320, 190, 270]; @endphp
                @foreach($heights as $i => $h)
                <div class="shimmer-wrap" style="--sh-h: {{ $h }}px; animation-delay: {{ $i * 0.05 }}s;">
                    <div class="shimmer-block shimmer-img"></div>
                    <div class="shimmer-body">
                        <div class="shimmer-avatar-row">
                            <div class="shimmer-block shimmer-avatar"></div>
                            <div class="shimmer-block shimmer-name"></div>
                        </div>
                        <div class="shimmer-block shimmer-line long"></div>
                        <div class="shimmer-block shimmer-line short"></div>
                        <div class="shimmer-stats">
                            <div class="shimmer-block shimmer-stat"></div>
                            <div class="shimmer-block shimmer-stat"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- REAL GRID --}}
            <div class="ap-grid">
                @foreach($posts as $post)

                    {{-- CARD → link ke halaman detail --}}
                    <a href="{{ route('user.post-detail', $post->id) }}" class="ap-card">

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

                            <div class="ap-card-overlay">
                                <div class="ap-overlay-top"></div>
                                <div class="ap-overlay-bottom">
                                    <div class="ap-overlay-actions">
                                        <span class="ap-icon-btn" title="Suka">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8 13.5S2 10 2 5.5A3.5 3.5 0 018 3.1 3.5 3.5 0 0114 5.5C14 10 8 13.5 8 13.5z" stroke="#c8533a" stroke-width="1.6"/>
                                            </svg>
                                        </span>
                                        <span class="ap-icon-btn" title="Komentar">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13 2H3a1 1 0 00-1 1v7a1 1 0 001 1h2l3 3 3-3h2a1 1 0 001-1V3a1 1 0 00-1-1z" stroke="#555" stroke-width="1.6"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($post->caption || $post->user)
                        <div class="ap-card-body">
                            <div class="ap-card-user">
                                <img src="{{ $post->user->avatar_display }}" alt="" class="ap-card-avatar">
                                <span class="ap-card-username">
                                    {{ $post->user->username ?? $post->user->name }}
                                </span>
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

                    </a>

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
// ── Shimmer → real content swap ──────────────────────────────────
(function () {
    const shimmerGrid = document.getElementById('shimmer-grid');
    const realGrid    = document.querySelector('.ap-grid');

    if (!shimmerGrid || !realGrid) return;

    realGrid.style.visibility = 'hidden';
    realGrid.style.position   = 'absolute';

    function revealContent() {
        shimmerGrid.style.transition = 'opacity 0.35s ease';
        shimmerGrid.style.opacity    = '0';
        setTimeout(() => {
            shimmerGrid.remove();
            realGrid.style.visibility = '';
            realGrid.style.position   = '';
        }, 350);
    }

    const imgs = Array.from(realGrid.querySelectorAll('.ap-card-img-wrap img'));

    if (imgs.length === 0) { revealContent(); return; }

    let loaded = 0;
    const threshold = Math.min(imgs.length, 4);

    imgs.slice(0, threshold).forEach(img => {
        if (img.complete) {
            loaded++;
            if (loaded >= threshold) revealContent();
        } else {
            img.addEventListener('load',  () => { loaded++; if (loaded >= threshold) revealContent(); }, { once: true });
            img.addEventListener('error', () => { loaded++; if (loaded >= threshold) revealContent(); }, { once: true });
        }
    });

    setTimeout(revealContent, 3000);
})();
</script>

@endsection