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
    max-width: 1300px; margin: 0 auto; padding: 0 32px;
    display: grid; grid-template-columns: 220px 1fr;
    gap: 24px; align-items: start;
}

/* ===================== SIDEBAR (desktop) ===================== */
.rw-sidebar { position: sticky; top: 80px; }

.rw-sidebar-card { background: var(--white); border-radius: var(--r-xl); box-shadow: var(--shadow-sm); overflow: hidden; }
.rw-sidebar-header { padding: 18px 20px 14px; border-bottom: 1px solid var(--warm-gray); }
.rw-sidebar-title { font-size: 12px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.8px; }

.rw-nav { padding: 8px; }
.rw-nav-item {
    display: flex; align-items: center; gap: 11px; padding: 10px 12px;
    border-radius: var(--r-md); text-decoration: none; color: var(--black);
    font-size: 13.5px; font-weight: 500; transition: background .15s, color .15s; margin-bottom: 2px;
}
.rw-nav-item:hover  { background: var(--cream); color: var(--black); }
.rw-nav-item.active { background: var(--black); color: var(--white); }
.rw-nav-item.active:hover { background: #222; color: var(--white); }

.rw-nav-icon { width: 32px; height: 32px; border-radius: var(--r-sm); background: var(--cream); display: grid; place-items: center; flex-shrink: 0; }
.rw-nav-item.active .rw-nav-icon { background: rgba(255,255,255,.15); }

.rw-nav-info { flex: 1; min-width: 0; }
.rw-nav-label { display: block; font-size: 13.5px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rw-nav-desc  { display: block; font-size: 11px; opacity: .65; margin-top: 1px; }
.rw-nav-badge { background: var(--accent); color: var(--white); font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 20px; flex-shrink: 0; }
.rw-nav-item.active .rw-nav-badge { background: rgba(255,255,255,.25); }

/* ===================== MAIN ===================== */
.rw-main { min-width: 0; }
.rw-heading { margin-bottom: 22px; }
.rw-heading h1 { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 400; color: var(--black); margin-bottom: 5px; }
.rw-heading p  { font-size: 13.5px; color: var(--muted); }

/* ===================== CARDS ===================== */
.rw-list { display: flex; flex-direction: column; gap: 16px; }

.rw-card {
    background: var(--white); border-radius: var(--r-lg); box-shadow: var(--shadow-sm);
    overflow: hidden; transition: box-shadow .25s, transform .25s;
    animation: cardIn .4s ease both; border: 1.5px solid transparent;
}
@keyframes cardIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
.rw-card:nth-child(1) { animation-delay: .04s; }
.rw-card:nth-child(2) { animation-delay: .08s; }
.rw-card:nth-child(3) { animation-delay: .12s; }
.rw-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); border-color: #f5c0b8; }

.rw-card-header { padding: 13px 18px; border-bottom: 1px solid var(--warm-gray); display: flex; align-items: center; gap: 10px; background: var(--red-soft); }
.rw-card-header-icon { width: 30px; height: 30px; border-radius: 50%; background: rgba(192,57,43,.12); display: grid; place-items: center; flex-shrink: 0; }
.rw-card-type { font-size: 12.5px; font-weight: 600; color: var(--red); flex: 1; }
.rw-card-time { font-size: 11.5px; color: var(--muted); }

.rw-card-body { padding: 18px; display: flex; gap: 18px; align-items: flex-start; }

.rw-thumb-wrap { width: 110px; height: 110px; border-radius: var(--r-md); overflow: hidden; flex-shrink: 0; background: var(--warm-gray); position: relative; }
.rw-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.rw-photo-count { position: absolute; top: 6px; right: 6px; background: rgba(10,10,10,.65); color: var(--white); font-size: 10.5px; font-weight: 600; padding: 2px 8px; border-radius: 12px; backdrop-filter: blur(4px); }

.rw-card-details { flex: 1; min-width: 0; }
.rw-detail { margin-bottom: 10px; }
.rw-detail:last-child { margin-bottom: 0; }
.rw-detail-label { font-size: 10.5px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .7px; margin-bottom: 3px; display: block; }
.rw-detail-value { font-size: 13.5px; color: var(--black); line-height: 1.5; }
.rw-detail-value.danger { color: var(--red); font-weight: 600; }

.rw-card-footer { padding: 13px 18px; border-top: 1px solid var(--warm-gray); background: var(--cream); display: flex; align-items: center; justify-content: flex-end; gap: 10px; }

.rw-btn { height: 36px; padding: 0 18px; border-radius: 36px; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 7px; text-decoration: none; transition: all .2s; white-space: nowrap; }
.rw-btn-detail { background: var(--white); color: var(--black); border: 1.5px solid var(--warm-gray); }
.rw-btn-detail:hover { background: var(--warm-gray); color: var(--black); }
.rw-btn-delete { background: var(--red-soft); color: var(--red); border: 1.5px solid #f5c0b8; }
.rw-btn-delete:hover { background: var(--red); color: var(--white); border-color: var(--red); }

/* ===================== MODAL ===================== */
.rw-modal .modal-dialog { max-width: 680px; }
.rw-modal .modal-content { border: none; border-radius: var(--r-xl); box-shadow: var(--shadow-lg); overflow: hidden; font-family: 'DM Sans', sans-serif; }
.rw-modal .modal-header { padding: 22px 28px 16px; border-bottom: 1px solid var(--warm-gray); display: flex; align-items: center; gap: 12px; }
.rw-modal-header-icon { width: 36px; height: 36px; border-radius: 50%; background: var(--red-soft); display: grid; place-items: center; flex-shrink: 0; }
.rw-modal .modal-title { font-size: 17px; font-weight: 600; color: var(--black); margin: 0; }
.rw-modal .modal-body { padding: 24px 28px; }
.rw-modal-photos { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; margin-bottom: 22px; }
.rw-modal-photo { aspect-ratio: 1; border-radius: var(--r-md); overflow: hidden; background: var(--warm-gray); border: 1.5px solid var(--warm-gray); }
.rw-modal-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
.rw-modal-section { margin-bottom: 20px; }
.rw-modal-section-label { font-size: 12px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .7px; margin-bottom: 8px; display: block; }
.rw-caption-box { background: var(--cream); border: 1.5px solid var(--warm-gray); border-radius: var(--r-md); padding: 14px 16px; font-size: 14px; color: #444; line-height: 1.65; }
.rw-ban-alert { background: var(--red-soft); border: 1.5px solid #f5c0b8; border-radius: var(--r-lg); padding: 18px 20px; }
.rw-ban-alert-title { font-size: 13px; font-weight: 600; color: var(--red); text-transform: uppercase; letter-spacing: .7px; margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }
.rw-ban-row { display: flex; gap: 8px; margin-bottom: 9px; font-size: 13.5px; }
.rw-ban-row:last-child { margin-bottom: 0; }
.rw-ban-key { font-weight: 600; color: var(--black); flex-shrink: 0; min-width: 120px; }
.rw-ban-val { color: #555; }
.rw-modal .modal-footer { padding: 14px 28px 22px; border-top: 1px solid var(--warm-gray); display: flex; justify-content: space-between; gap: 10px; }

/* ===================== EMPTY ===================== */
.rw-empty { text-align: center; padding: 80px 24px; background: var(--white); border-radius: var(--r-xl); box-shadow: var(--shadow-sm); }
.rw-empty-icon { width: 64px; height: 64px; background: var(--cream); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 20px; }
.rw-empty h4 { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 400; color: var(--black); margin-bottom: 8px; }
.rw-empty p  { font-size: 14px; color: var(--muted); }

/* ===================== MOBILE BOTTOM NAV ===================== */
.rw-mobile-nav {
    display: none;
    position: fixed; bottom: 0; left: 0; right: 0; z-index: 500;
    background: var(--white);
    border-top: 1px solid var(--warm-gray);
    padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
    box-shadow: 0 -4px 20px rgba(10,10,10,0.08);
}

.rw-mobile-nav-inner {
    display: flex; justify-content: space-around; align-items: center;
    max-width: 500px; margin: 0 auto; padding: 0 8px;
}

.rw-mob-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 6px 8px; border-radius: var(--r-md);
    text-decoration: none; color: var(--muted);
    transition: color .15s; position: relative; min-width: 48px;
}
.rw-mob-item:hover  { color: var(--black); }
.rw-mob-item.active { color: var(--black); }

.rw-mob-icon {
    width: 34px; height: 34px; border-radius: var(--r-sm);
    display: grid; place-items: center;
    transition: background .15s;
}
.rw-mob-item.active .rw-mob-icon { background: var(--black); color: var(--white); }

.rw-mob-badge {
    position: absolute; top: 2px; right: 4px;
    min-width: 16px; height: 16px;
    background: var(--accent); color: var(--white);
    font-size: 9px; font-weight: 700; border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 4px; border: 1.5px solid var(--white);
}

.rw-mob-label { font-size: 10px; font-weight: 500; line-height: 1; }

/* ===================== RESPONSIVE BREAKPOINTS ===================== */
@media (max-width: 900px) {
    .rw-inner { grid-template-columns: 1fr; padding: 0 16px; }
    .rw-sidebar { display: none; }           /* sidebar hilang */
    .rw-mobile-nav { display: block; }       /* bottom nav muncul */
    .rw-page { padding-bottom: 100px; }      /* ruang untuk bottom nav */
    .rw-heading h1 { font-size: 20px; }
}

@media (max-width: 560px) {
    .rw-inner  { padding: 0 12px; }
    .rw-page   { padding-top: 20px; }

    /* Card stack vertikal */
    .rw-card-body      { flex-direction: column; gap: 12px; }
    .rw-thumb-wrap     { width: 100%; height: 220px; }

    /* Footer stack */
    .rw-card-footer    { flex-direction: column-reverse; gap: 8px; padding: 12px 14px; }
    .rw-btn            { width: 100%; justify-content: center; height: 40px; font-size: 13.5px; }

    /* Modal adjustments */
    .rw-modal .modal-body   { padding: 16px; }
    .rw-modal .modal-header { padding: 14px 16px; }
    .rw-modal .modal-footer { padding: 12px 16px; flex-direction: column-reverse; }
    .rw-modal .modal-footer .rw-btn { width: 100%; justify-content: center; }
    .rw-modal-photos { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .rw-ban-row { flex-direction: column; gap: 2px; }
    .rw-ban-key { min-width: unset; font-size: 11px; }
    .rw-ban-val { font-size: 13px; }

    /* Empty state */
    .rw-empty { padding: 60px 20px; }
}
</style>

<div class="rw-page">
    <div class="rw-inner">

        {{-- ══ SIDEBAR (Desktop only) ══ --}}
        <aside class="rw-sidebar">
            <div class="rw-sidebar-card">
                <div class="rw-sidebar-header">
                    <span class="rw-sidebar-title">Riwayat Aktivitas</span>
                </div>
                <nav class="rw-nav">

                    <a href="{{ route('user.riwayat.postingan') }}" class="rw-nav-item active">
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
                        @if($totalPosts > 0)<span class="rw-nav-badge">{{ $totalPosts }}</span>@endif
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
                        @if($totalComments > 0)<span class="rw-nav-badge">{{ $totalComments }}</span>@endif
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
                        @if($totalLikes > 0)<span class="rw-nav-badge">{{ $totalLikes }}</span>@endif
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
                        @if($totalFollowers > 0)<span class="rw-nav-badge">{{ $totalFollowers }}</span>@endif
                    </a>

                    <a href="{{ route('user.riwayat.mengikuti') }}" class="rw-nav-item">
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
                        @if($totalFollowing > 0)<span class="rw-nav-badge">{{ $totalFollowing }}</span>@endif
                    </a>

                </nav>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <main class="rw-main">

            <div class="rw-heading">
                <h1>Notifikasi Pelanggaran</h1>
                <p>Postingan yang telah dibanned oleh admin</p>
            </div>

            @forelse($posts as $post)
                <div class="rw-list">
                <div class="rw-card">

                    <div class="rw-card-header">
                        <div class="rw-card-header-icon">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                <circle cx="6.5" cy="6.5" r="5.5" stroke="#c0392b" stroke-width="1.4"/>
                                <path d="M4 4l5 5M9 4L4 9" stroke="#c0392b" stroke-width="1.4" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span class="rw-card-type">Postingan Dibanned</span>
                        <span class="rw-card-time">{{ $post->bans->first()->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="rw-card-body">
                        <div class="rw-thumb-wrap">
                            @if($post->photos->first())
                                <img src="{{ asset('storage/'.$post->photos->first()->photo) }}" alt="">
                            @endif
                            @if($post->photos->count() > 1)
                                <div class="rw-photo-count">+{{ $post->photos->count() - 1 }}</div>
                            @endif
                        </div>

                        <div class="rw-card-details">
                            @if($post->caption)
                                <div class="rw-detail">
                                    <span class="rw-detail-label">Caption</span>
                                    <span class="rw-detail-value">{{ Str::limit($post->caption, 120) }}</span>
                                </div>
                            @endif
                            <div class="rw-detail">
                                <span class="rw-detail-label">Alasan Ban</span>
                                <span class="rw-detail-value danger">{{ $post->bans->first()->reason }}</span>
                            </div>
                            @if($post->bans->first()->notes)
                                <div class="rw-detail">
                                    <span class="rw-detail-label">Catatan Admin</span>
                                    <span class="rw-detail-value">{{ $post->bans->first()->notes }}</span>
                                </div>
                            @endif
                            <div class="rw-detail">
                                <span class="rw-detail-label">Dibanned Oleh</span>
                                <span class="rw-detail-value">{{ $post->bans->first()->admin->name }}</span>
                            </div>
                            <div class="rw-detail">
                                <span class="rw-detail-label">Tanggal</span>
                                <span class="rw-detail-value">{{ $post->bans->first()->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="rw-card-footer">
                        <form action="{{ route('user.postingan.destroy', $post) }}" method="POST" style="margin:0">
                            @csrf @method('DELETE')
                            <button type="submit" class="rw-btn rw-btn-delete"
                                    onclick="return confirm('Hapus postingan ini secara permanen?')">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M1.5 3h9M4.5 3V2a.5.5 0 01.5-.5h2a.5.5 0 01.5.5v1M9.5 3l-.5 7a.5.5 0 01-.5.5h-5A.5.5 0 013 10L2.5 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Hapus Postingan
                            </button>
                        </form>
                        <button class="rw-btn rw-btn-detail"
                                data-bs-toggle="modal" data-bs-target="#banModal{{ $post->id }}">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1.3"/>
                                <path d="M6 5.5v3M6 4v.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            Lihat Detail
                        </button>
                    </div>
                </div>
                </div>

                {{-- Modal --}}
                <div class="modal fade rw-modal" id="banModal{{ $post->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="rw-modal-header-icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <circle cx="8" cy="8" r="6.5" stroke="#c0392b" stroke-width="1.5"/>
                                        <path d="M5 5l6 6M11 5L5 11" stroke="#c0392b" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <h5 class="modal-title">Detail Pelanggaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="rw-modal-section">
                                    <span class="rw-modal-section-label">Foto Postingan</span>
                                    <div class="rw-modal-photos">
                                        @foreach($post->photos as $photo)
                                            <div class="rw-modal-photo">
                                                <img src="{{ asset('storage/'.$photo->photo) }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="rw-modal-section">
                                    <span class="rw-modal-section-label">Caption</span>
                                    <div class="rw-caption-box">{{ $post->caption ?? 'Tidak ada caption' }}</div>
                                </div>
                                <div class="rw-modal-section" style="margin-bottom:0">
                                    <div class="rw-ban-alert">
                                        <div class="rw-ban-alert-title">
                                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                                <circle cx="6.5" cy="6.5" r="5.5" stroke="currentColor" stroke-width="1.4"/>
                                                <path d="M4 4l5 5M9 4L4 9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                            </svg>
                                            Informasi Ban
                                        </div>
                                        <div class="rw-ban-row">
                                            <span class="rw-ban-key">Alasan:</span>
                                            <span class="rw-ban-val">{{ $post->bans->first()->reason }}</span>
                                        </div>
                                        @if($post->bans->first()->notes)
                                            <div class="rw-ban-row">
                                                <span class="rw-ban-key">Catatan:</span>
                                                <span class="rw-ban-val">{{ $post->bans->first()->notes }}</span>
                                            </div>
                                        @endif
                                        <div class="rw-ban-row">
                                            <span class="rw-ban-key">Dibanned oleh:</span>
                                            <span class="rw-ban-val">{{ $post->bans->first()->admin->name }}</span>
                                        </div>
                                        <div class="rw-ban-row">
                                            <span class="rw-ban-key">Tanggal:</span>
                                            <span class="rw-ban-val">{{ $post->bans->first()->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('user.postingan.destroy', $post) }}" method="POST" style="margin:0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rw-btn rw-btn-delete"
                                            onclick="return confirm('Hapus postingan ini secara permanen?')">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M1.5 3h9M4.5 3V2a.5.5 0 01.5-.5h2a.5.5 0 01.5.5v1M9.5 3l-.5 7a.5.5 0 01-.5.5h-5A.5.5 0 013 10L2.5 3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Hapus Postingan
                                    </button>
                                </form>
                                <button type="button" class="rw-btn rw-btn-detail" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="rw-empty">
                    <div class="rw-empty-icon">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <rect x="3" y="3" width="20" height="20" rx="4" stroke="#b8b3ac" stroke-width="1.6"/>
                            <path d="M9 13h8M13 9v8" stroke="#b8b3ac" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h4>Tidak Ada Notifikasi</h4>
                    <p>Tidak ada postingan yang dibanned saat ini.</p>
                </div>
            @endforelse

        </main>
    </div>
</div>

{{-- ══ MOBILE BOTTOM NAV ══ --}}
<nav class="rw-mobile-nav">
    <div class="rw-mobile-nav-inner">

        <a href="{{ route('user.riwayat.postingan') }}" class="rw-mob-item active">
            @if($totalPosts > 0)<span class="rw-mob-badge">{{ $totalPosts > 9 ? '9+' : $totalPosts }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M8.5 2S6 5.5 6 8a2.5 2.5 0 005 0C11 5.5 8.5 2 8.5 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M8.5 10.5v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="rw-mob-label">Notifikasi</span>
        </a>

        <a href="{{ route('user.riwayat.komentar') }}" class="rw-mob-item">
            @if($totalComments > 0)<span class="rw-mob-badge">{{ $totalComments > 9 ? '9+' : $totalComments }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M14 2H3a.5.5 0 00-.5.5v8a.5.5 0 00.5.5h3.5l3 3 3-3H14a.5.5 0 00.5-.5V2.5A.5.5 0 0014 2z" stroke="currentColor" stroke-width="1.4"/>
                </svg>
            </div>
            <span class="rw-mob-label">Komentar</span>
        </a>

        <a href="{{ route('user.riwayat.like') }}" class="rw-mob-item">
            @if($totalLikes > 0)<span class="rw-mob-badge">{{ $totalLikes > 9 ? '9+' : $totalLikes }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M8.5 14S2 10.5 2 6.5A3.5 3.5 0 018.5 3.7 3.5 3.5 0 0115 6.5C15 10.5 8.5 14 8.5 14z" stroke="currentColor" stroke-width="1.4"/>
                </svg>
            </div>
            <span class="rw-mob-label">Suka</span>
        </a>

        <a href="{{ route('user.riwayat.diikuti') }}" class="rw-mob-item">
            @if($totalFollowers > 0)<span class="rw-mob-badge">{{ $totalFollowers > 9 ? '9+' : $totalFollowers }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <circle cx="8.5" cy="5.5" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                    <path d="M3 14c0-3 2.5-4.5 5.5-4.5s5.5 1.5 5.5 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="rw-mob-label">Pengikut</span>
        </a>

        <a href="{{ route('user.riwayat.mengikuti') }}" class="rw-mob-item">
            @if($totalFollowing > 0)<span class="rw-mob-badge">{{ $totalFollowing > 9 ? '9+' : $totalFollowing }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <circle cx="6.5" cy="5.5" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                    <path d="M2 14c0-3 2-4.5 4.5-4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M13 9v6M10 12h6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="rw-mob-label">Mengikuti</span>
        </a>

    </div>
</nav>

@endsection