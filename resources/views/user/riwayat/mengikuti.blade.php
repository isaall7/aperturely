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
        --red:         #c0392b;
        --red-soft:    #fdf2f2;
        --shadow-sm:   0 1px 3px rgba(10,10,10,0.07);
        --shadow-md:   0 4px 16px rgba(10,10,10,0.10);
        --shadow-lg:   0 12px 40px rgba(10,10,10,0.14);
        --r-sm:  8px;
        --r-md:  14px;
        --r-lg:  20px;
        --r-xl:  28px;
        font-family: 'DM Sans', sans-serif;
    }

    .container-fluid { padding: 0 !important; max-width: 100% !important; }
    .body-wrapper    { margin-top: 0 !important; }

    /* ===================== PAGE ===================== */
    .rw-page {
        background: var(--cream);
        min-height: calc(100vh - 64px);
        padding: 36px 0 80px;
    }

    .rw-inner {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 32px;
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 900px) { .rw-inner { grid-template-columns: 1fr; } }
    @media (max-width: 560px) { .rw-inner { padding: 0 16px; } }

    /* ===================== SIDEBAR ===================== */
    .rw-sidebar { position: sticky; top: 80px; }

    .rw-sidebar-card {
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .rw-sidebar-header {
        padding: 18px 20px 14px;
        border-bottom: 1px solid var(--warm-gray);
    }

    .rw-sidebar-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .rw-nav { padding: 8px; }

    .rw-nav-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px 12px;
        border-radius: var(--r-md);
        text-decoration: none;
        color: var(--black);
        font-size: 13.5px;
        font-weight: 500;
        transition: background .15s, color .15s;
        margin-bottom: 2px;
    }

    .rw-nav-item:hover { background: var(--cream); color: var(--black); }
    .rw-nav-item.active { background: var(--black); color: var(--white); }
    .rw-nav-item.active:hover { background: #222; color: var(--white); }

    .rw-nav-icon {
        width: 32px; height: 32px;
        border-radius: var(--r-sm);
        background: var(--cream);
        display: grid; place-items: center;
        flex-shrink: 0;
    }

    .rw-nav-item.active .rw-nav-icon { background: rgba(255,255,255,.15); }

    .rw-nav-info { flex: 1; min-width: 0; }

    .rw-nav-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .rw-nav-desc {
        display: block;
        font-size: 11px;
        opacity: .65;
        margin-top: 1px;
    }

    .rw-nav-badge {
        background: var(--accent);
        color: var(--white);
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        flex-shrink: 0;
    }

    .rw-nav-item.active .rw-nav-badge { background: rgba(255,255,255,.25); }

    /* ===================== MAIN ===================== */
    .rw-main { min-width: 0; }

    .rw-heading { margin-bottom: 22px; }

    .rw-heading h1 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 400;
        color: var(--black);
        margin-bottom: 5px;
    }

    .rw-heading p { font-size: 13.5px; color: var(--muted); }

    /* ===================== USER GRID ===================== */
    .rw-user-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    @media (max-width: 640px) { .rw-user-grid { grid-template-columns: repeat(2,1fr); gap: 12px; } }
    @media (max-width: 400px) { .rw-user-grid { grid-template-columns: 1fr; } }

    /* ===================== USER CARD ===================== */
    .rw-user-card {
        background: var(--white);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1.5px solid var(--warm-gray);
        transition: box-shadow .25s, transform .25s, border-color .25s;
        animation: cardIn .4s ease both;
        display: flex;
        flex-direction: column;
    }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .rw-user-card:nth-child(1) { animation-delay:.04s; }
    .rw-user-card:nth-child(2) { animation-delay:.08s; }
    .rw-user-card:nth-child(3) { animation-delay:.12s; }
    .rw-user-card:nth-child(4) { animation-delay:.16s; }
    .rw-user-card:nth-child(5) { animation-delay:.20s; }
    .rw-user-card:nth-child(6) { animation-delay:.24s; }

    .rw-user-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
        border-color: var(--mid-gray);
    }

    /* Card top */
    .rw-user-top {
        padding: 24px 20px 16px;
        text-align: center;
        background: var(--cream);
        border-bottom: 1px solid var(--warm-gray);
    }

    .rw-user-avatar {
        width: 64px; height: 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 2.5px solid var(--white);
        box-shadow: var(--shadow-sm);
        display: block;
        margin: 0 auto 12px;
        transition: transform .2s;
    }

    .rw-user-card:hover .rw-user-avatar { transform: scale(1.05); }

    .rw-user-name {
        font-size: 14.5px;
        font-weight: 600;
        color: var(--black);
        text-decoration: none;
        display: block;
        margin-bottom: 3px;
        transition: color .2s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .rw-user-name:hover { color: var(--accent); }

    .rw-user-handle { font-size: 12.5px; color: var(--muted); }

    /* Card info */
    .rw-user-info { padding: 14px 16px; flex: 1; }

    .rw-user-info-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--muted);
    }

    /* Card footer — two buttons */
    .rw-user-footer {
        padding: 12px 14px;
        border-top: 1px solid var(--warm-gray);
        display: flex;
        gap: 8px;
    }

    .rw-btn {
        height: 34px;
        border-radius: 34px;
        font-size: 12.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none;
        transition: all .2s;
        white-space: nowrap;
    }

    .rw-btn-profile {
        flex: 1;
        background: var(--black);
        color: var(--white);
    }
    .rw-btn-profile:hover { background: #222; color: var(--white); transform: translateY(-1px); }

    .rw-btn-unfollow {
        flex: 1;
        background: var(--red-soft);
        color: var(--red);
        border: 1px solid #f5c0b8;
    }
    .rw-btn-unfollow:hover { background: var(--red); color: var(--white); border-color: var(--red); }

    /* ===================== EMPTY ===================== */
    .rw-empty {
        text-align: center;
        padding: 80px 24px;
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-sm);
    }

    .rw-empty-icon {
        width: 64px; height: 64px;
        background: var(--cream);
        border-radius: 50%;
        display: grid; place-items: center;
        margin: 0 auto 20px;
    }

    .rw-empty h4 {
        font-family: 'Playfair Display', serif;
        font-size: 20px; font-weight: 400;
        color: var(--black); margin-bottom: 8px;
    }

    .rw-empty p { font-size: 14px; color: var(--muted); }
</style>

<div class="rw-page">
    <div class="rw-inner">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="rw-sidebar">
            <div class="rw-sidebar-card">
                <div class="rw-sidebar-header">
                    <span class="rw-sidebar-title">Riwayat Aktivitas</span>
                </div>
                <nav class="rw-nav">

                    <a href="{{ route('user.riwayat.postingan') }}" class="rw-nav-item">
                        <div class="rw-nav-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M7.5 2C7.5 2 5 5 5 7.5a2.5 2.5 0 005 0C10 5 7.5 2 7.5 2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                <path d="M7.5 10v3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="rw-nav-info">
                            <span class="rw-nav-label">Notifikasi</span>
                            <span class="rw-nav-desc">Postingan dibanned</span>
                        </div>
                        @if(isset($totalPosts) && $totalPosts > 0)
                            <span class="rw-nav-badge">{{ $totalPosts }}</span>
                        @endif
                    </a>

                    <a href="{{ route('user.riwayat.komentar') }}" class="rw-nav-item">
                        <div class="rw-nav-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M12.5 1.5H2.5a.5.5 0 00-.5.5v7a.5.5 0 00.5.5H4l3 3 3-3h2.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="currentColor" stroke-width="1.3"/>
                            </svg>
                        </div>
                        <div class="rw-nav-info">
                            <span class="rw-nav-label">Komentar</span>
                            <span class="rw-nav-desc">Riwayat komentar</span>
                        </div>
                        @if(isset($totalComments) && $totalComments > 0)
                            <span class="rw-nav-badge">{{ $totalComments }}</span>
                        @endif
                    </a>

                    <a href="{{ route('user.riwayat.like') }}" class="rw-nav-item">
                        <div class="rw-nav-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M7.5 13S1.5 9.5 1.5 5.5A3 3 0 017.5 3.1 3 3 0 0113.5 5.5C13.5 9.5 7.5 13 7.5 13z" stroke="currentColor" stroke-width="1.4"/>
                            </svg>
                        </div>
                        <div class="rw-nav-info">
                            <span class="rw-nav-label">Menyukai</span>
                            <span class="rw-nav-desc">Postingan disukai</span>
                        </div>
                        @if($totalLikes > 0)
                            <span class="rw-nav-badge">{{ $totalLikes }}</span>
                        @endif
                    </a>

                    <a href="{{ route('user.riwayat.diikuti') }}" class="rw-nav-item">
                        <div class="rw-nav-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <circle cx="7.5" cy="5" r="2.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M2 13c0-3 2.5-4.5 5.5-4.5s5.5 1.5 5.5 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                <path d="M11 6l1.5 1.5L15 5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="rw-nav-info">
                            <span class="rw-nav-label">Pengikut</span>
                            <span class="rw-nav-desc">Pengguna yang diikuti</span>
                        </div>
                        @if($totalFollowers > 0)
                            <span class="rw-nav-badge">{{ $totalFollowers }}</span>
                        @endif
                    </a>

                    <a href="{{ route('user.riwayat.mengikuti') }}" class="rw-nav-item active">
                        <div class="rw-nav-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <circle cx="6" cy="5" r="2.5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M1.5 13c0-3 2-4.5 4.5-4.5s4.5 1.5 4.5 4.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                <path d="M11.5 3v5M9 5.5h5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="rw-nav-info">
                            <span class="rw-nav-label">Mengikuti</span>
                            <span class="rw-nav-desc">Pengguna yang mengikuti</span>
                        </div>
                        @if($totalFollowing > 0)
                            <span class="rw-nav-badge">{{ $totalFollowing }}</span>
                        @endif
                    </a>

                </nav>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <main class="rw-main">

            <div class="rw-heading">
                <h1>Mengikuti</h1>
                <p>Pengguna yang sedang kamu ikuti</p>
            </div>

            @if($followingUsers->count() > 0)
                <div class="rw-user-grid">
                    @foreach($followingUsers as $follow)
                        <div class="rw-user-card">

                            {{-- Top --}}
                            <div class="rw-user-top">
                                <img src="{{ $follow->followed->avatar_display ?? 'https://ui-avatars.com/api/?name='.urlencode($follow->followed->name) }}"
                                     alt="{{ $follow->followed->name }}"
                                     class="rw-user-avatar">
                                <a href="{{ route('user.profile.username', ['name' => $follow->followed->name]) }}"
                                   class="rw-user-name">
                                    {{ $follow->followed->name }}
                                </a>
                                <span class="rw-user-handle">{{ $follow->followed->username ?? strtolower(str_replace(' ','',$follow->followed->name)) }}</span>
                            </div>

                            {{-- Info --}}
                            <div class="rw-user-info">
                                <div class="rw-user-info-row">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                        <rect x="1.5" y="2" width="10" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/>
                                        <path d="M1.5 5h10M4 1v2M9 1v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                    </svg>
                                    Diikuti sejak {{ $follow->created_at->format('d M Y') }}
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="rw-user-footer">
                                <a href="{{ route('user.profile.username', ['name' => $follow->followed->name]) }}"
                                   class="rw-btn rw-btn-profile">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                        <circle cx="6" cy="4" r="2" stroke="currentColor" stroke-width="1.3"/>
                                        <path d="M2 10c0-2 1.8-3.5 4-3.5s4 1.5 4 3.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                    </svg>
                                    Profil
                                </a>
                                <form action="{{ route('user.profile.follow', $follow->followed->id) }}" method="POST" style="flex:1;margin:0">
                                    @csrf
                                    <button type="submit" class="rw-btn rw-btn-unfollow" style="width:100%"
                                            onclick="return confirm('Berhenti mengikuti {{ $follow->followed->name }}?')">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <circle cx="5" cy="4" r="2" stroke="currentColor" stroke-width="1.3"/>
                                            <path d="M1 10c0-2 1.8-3.5 4-3.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                            <path d="M8 8h4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                                        </svg>
                                        Unfollow
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="rw-empty">
                    <div class="rw-empty-icon">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <circle cx="10" cy="9" r="4" stroke="#b8b3ac" stroke-width="1.6"/>
                            <path d="M3 22c0-5 3.5-7 7-7s7 2 7 7" stroke="#b8b3ac" stroke-width="1.6" stroke-linecap="round"/>
                            <path d="M19 13h6M22 10v6" stroke="#b8b3ac" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h4>Belum Mengikuti Siapa Pun</h4>
                    <p>Mulai ikuti fotografer lain untuk melihat karya mereka.</p>
                </div>
            @endif

        </main>
    </div>
</div>

@endsection