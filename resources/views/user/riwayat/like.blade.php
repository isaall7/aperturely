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

/* ===================== SIDEBAR ===================== */
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
.rw-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); border-color: var(--accent-soft); }

.rw-card-header {
    padding: 13px 18px; border-bottom: 1px solid var(--warm-gray);
    display: flex; align-items: center; gap: 10px; background: var(--accent-soft);
}
.rw-card-header-icon { width: 30px; height: 30px; border-radius: 50%; background: rgba(200,83,58,.12); display: grid; place-items: center; flex-shrink: 0; }
.rw-card-header-text { flex: 1; display: flex; align-items: center; gap: 10px; }
.rw-card-type { font-size: 12.5px; font-weight: 600; color: var(--accent); flex: 1; }
.rw-card-time { font-size: 11.5px; color: var(--muted); }

.rw-card-body { padding: 18px; display: flex; gap: 18px; align-items: flex-start; }

.rw-thumb-wrap { width: 110px; height: 110px; border-radius: var(--r-md); overflow: hidden; flex-shrink: 0; background: var(--warm-gray); }
.rw-thumb-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }

.rw-card-details { flex: 1; min-width: 0; }

/* Owner row */
.rw-owner-row { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; flex-wrap: wrap; }
.rw-owner-label { font-size: 10.5px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; }
.rw-owner-link { display: inline-flex; align-items: center; gap: 7px; text-decoration: none; transition: opacity .2s; }
.rw-owner-link:hover { opacity: .8; }
.rw-owner-avatar { width: 22px; height: 22px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--warm-gray); flex-shrink: 0; }
.rw-owner-name { font-size: 13px; font-weight: 600; color: var(--black); }

/* Caption */
.rw-caption { font-size: 13.5px; color: #555; line-height: 1.55; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.rw-caption.no-caption { color: var(--muted); font-style: italic; }

/* Like action */
.rw-actions { display: flex; align-items: center; gap: 8px; }
.rw-like-btn {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--cream); border: 1.5px solid var(--warm-gray);
    display: grid; place-items: center; cursor: pointer;
    transition: background .2s, border-color .2s, transform .15s; flex-shrink: 0;
}
.rw-like-btn:hover { background: var(--accent-soft); border-color: var(--accent); transform: scale(1.08); }
.rw-like-btn.liked { background: var(--accent-soft); border-color: var(--accent); }
.rw-like-count { font-size: 13.5px; font-weight: 600; color: var(--black); }
.rw-like-label { font-size: 13px; color: var(--muted); }

/* ===================== EMPTY ===================== */
.rw-empty { text-align: center; padding: 80px 24px; background: var(--white); border-radius: var(--r-xl); box-shadow: var(--shadow-sm); }
.rw-empty-icon { width: 64px; height: 64px; background: var(--cream); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 20px; }
.rw-empty h4 { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 400; color: var(--black); margin-bottom: 8px; }
.rw-empty p  { font-size: 14px; color: var(--muted); }

/* ===================== MOBILE BOTTOM NAV ===================== */
.rw-mobile-nav {
    display: none;
    position: fixed; bottom: 0; left: 0; right: 0; z-index: 500;
    background: var(--white); border-top: 1px solid var(--warm-gray);
    padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
    box-shadow: 0 -4px 20px rgba(10,10,10,0.08);
}
.rw-mobile-nav-inner { display: flex; justify-content: space-around; align-items: center; max-width: 500px; margin: 0 auto; padding: 0 8px; }
.rw-mob-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 6px 8px; border-radius: var(--r-md);
    text-decoration: none; color: var(--muted); transition: color .15s; position: relative; min-width: 48px;
}
.rw-mob-item:hover  { color: var(--black); }
.rw-mob-item.active { color: var(--black); }
.rw-mob-icon { width: 34px; height: 34px; border-radius: var(--r-sm); display: grid; place-items: center; transition: background .15s; }
.rw-mob-item.active .rw-mob-icon { background: var(--black); color: var(--white); }
.rw-mob-badge {
    position: absolute; top: 2px; right: 4px; min-width: 16px; height: 16px;
    background: var(--accent); color: var(--white); font-size: 9px; font-weight: 700;
    border-radius: 20px; display: flex; align-items: center; justify-content: center;
    padding: 0 4px; border: 1.5px solid var(--white);
}
.rw-mob-label { font-size: 10px; font-weight: 500; line-height: 1; }

/* ===================== RESPONSIVE BREAKPOINTS ===================== */
@media (max-width: 900px) {
    .rw-inner { grid-template-columns: 1fr; padding: 0 16px; }
    .rw-sidebar { display: none; }
    .rw-mobile-nav { display: block; }
    .rw-page { padding-bottom: 100px; }
    .rw-heading h1 { font-size: 20px; }
}

@media (max-width: 560px) {
    .rw-inner { padding: 0 12px; }
    .rw-page { padding-top: 20px; }
    .rw-card-body { flex-direction: column; gap: 12px; }
    .rw-thumb-wrap { width: 100%; height: 180px; }
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
                        @if(isset($totalPosts) && $totalPosts > 0)<span class="rw-nav-badge">{{ $totalPosts }}</span>@endif
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
                        @if(isset($totalComments) && $totalComments > 0)<span class="rw-nav-badge">{{ $totalComments }}</span>@endif
                    </a>

                    <a href="{{ route('user.riwayat.like') }}" class="rw-nav-item active">
                        <div class="rw-nav-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M7.5 13S1.5 9.5 1.5 5.5A3 3 0 017.5 3.1 3 3 0 0113.5 5.5C13.5 9.5 7.5 13 7.5 13z" stroke="currentColor" stroke-width="1.4" fill="currentColor"/>
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
                        @if(isset($totalFollowers) && $totalFollowers > 0)<span class="rw-nav-badge">{{ $totalFollowers }}</span>@endif
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
                        @if(isset($totalFollowing) && $totalFollowing > 0)<span class="rw-nav-badge">{{ $totalFollowing }}</span>@endif
                    </a>

                </nav>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <main class="rw-main">

            <div class="rw-heading">
                <h1>Riwayat Menyukai</h1>
                <p>Postingan yang pernah kamu sukai</p>
            </div>

            @if($likedPosts->count() > 0)
                <div class="rw-list">
                    @foreach($likedPosts as $post)
                        <div class="rw-card">

                            <div class="rw-card-header">
                                <div class="rw-card-header-icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 12S1.5 9 1.5 5A3.5 3.5 0 017 2.2 3.5 3.5 0 0112.5 5C12.5 9 7 12 7 12z" stroke="#c8533a" stroke-width="1.5" fill="#c8533a"/>
                                    </svg>
                                </div>
                                <div class="rw-card-header-text">
                                    <span class="rw-card-type">Postingan Disukai</span>
                                    <span class="rw-card-time">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="rw-card-body">
                                <div class="rw-thumb-wrap">
                                    <img src="{{ asset('storage/'.optional($post->mainPhoto)->photo ?? 'images/default-post.jpg') }}" alt="Post">
                                </div>
                                <div class="rw-card-details">
                                    @if($post->user)
                                        <div class="rw-owner-row">
                                            <span class="rw-owner-label">Akun</span>
                                            <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="rw-owner-link">
                                                <img src="{{ $post->user->avatar_display ?? 'https://ui-avatars.com/api/?name='.$post->user->name }}"
                                                     alt="{{ $post->user->name }}" class="rw-owner-avatar">
                                                <span class="rw-owner-name">{{ $post->user->username ?? $post->user->name }}</span>
                                            </a>
                                        </div>
                                    @endif
                                    @if($post->caption)
                                        <div class="rw-caption">{{ $post->caption }}</div>
                                    @else
                                        <div class="rw-caption no-caption">Tidak ada caption</div>
                                    @endif
                                    <div class="rw-actions">
                                        <button type="button"
                                                class="rw-like-btn {{ $post->isLikedBy(auth()->id()) ? 'liked' : '' }}"
                                                data-post-id="{{ $post->id }}"
                                                data-liked="{{ $post->isLikedBy(auth()->id()) ? '1' : '0' }}">
                                            @if($post->isLikedBy(auth()->id()))
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="#c8533a">
                                                    <path d="M7.5 13S1.5 9.5 1.5 5.5A3 3 0 017.5 3.1 3 3 0 0113.5 5.5C13.5 9.5 7.5 13 7.5 13z"/>
                                                </svg>
                                            @else
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                    <path d="M7.5 13S1.5 9.5 1.5 5.5A3 3 0 017.5 3.1 3 3 0 0113.5 5.5C13.5 9.5 7.5 13 7.5 13z" stroke="#888" stroke-width="1.4"/>
                                                </svg>
                                            @endif
                                        </button>
                                        <span class="rw-like-count" data-post-id="{{ $post->id }}">{{ $post->likesCount() }}</span>
                                        <span class="rw-like-label">suka</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="rw-empty">
                    <div class="rw-empty-icon">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none">
                            <path d="M13 22S3 16.5 3 9A5 5 0 0113 5.5 5 5 0 0123 9C23 16.5 13 22 13 22z" stroke="#b8b3ac" stroke-width="1.6"/>
                        </svg>
                    </div>
                    <h4>Belum Ada Postingan Disukai</h4>
                    <p>Kamu belum menyukai postingan apapun.</p>
                </div>
            @endif

        </main>
    </div>
</div>

{{-- ══ MOBILE BOTTOM NAV ══ --}}
<nav class="rw-mobile-nav">
    <div class="rw-mobile-nav-inner">

        <a href="{{ route('user.riwayat.postingan') }}" class="rw-mob-item">
            @if(isset($totalPosts) && $totalPosts > 0)<span class="rw-mob-badge">{{ $totalPosts > 9 ? '9+' : $totalPosts }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M8.5 2S6 5.5 6 8a2.5 2.5 0 005 0C11 5.5 8.5 2 8.5 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M8.5 10.5v3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="rw-mob-label">Notifikasi</span>
        </a>

        <a href="{{ route('user.riwayat.komentar') }}" class="rw-mob-item">
            @if(isset($totalComments) && $totalComments > 0)<span class="rw-mob-badge">{{ $totalComments > 9 ? '9+' : $totalComments }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M14 2H3a.5.5 0 00-.5.5v8a.5.5 0 00.5.5h3.5l3 3 3-3H14a.5.5 0 00.5-.5V2.5A.5.5 0 0014 2z" stroke="currentColor" stroke-width="1.4"/>
                </svg>
            </div>
            <span class="rw-mob-label">Komentar</span>
        </a>

        <a href="{{ route('user.riwayat.like') }}" class="rw-mob-item active">
            @if($totalLikes > 0)<span class="rw-mob-badge">{{ $totalLikes > 9 ? '9+' : $totalLikes }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M8.5 14S2 10.5 2 6.5A3.5 3.5 0 018.5 3.7 3.5 3.5 0 0115 6.5C15 10.5 8.5 14 8.5 14z" stroke="currentColor" stroke-width="1.4"/>
                </svg>
            </div>
            <span class="rw-mob-label">Suka</span>
        </a>

        <a href="{{ route('user.riwayat.diikuti') }}" class="rw-mob-item">
            @if(isset($totalFollowers) && $totalFollowers > 0)<span class="rw-mob-badge">{{ $totalFollowers > 9 ? '9+' : $totalFollowers }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <circle cx="8.5" cy="5.5" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                    <path d="M3 14c0-3 2.5-4.5 5.5-4.5s5.5 1.5 5.5 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
            </div>
            <span class="rw-mob-label">Pengikut</span>
        </a>

        <a href="{{ route('user.riwayat.mengikuti') }}" class="rw-mob-item">
            @if(isset($totalFollowing) && $totalFollowing > 0)<span class="rw-mob-badge">{{ $totalFollowing > 9 ? '9+' : $totalFollowing }}</span>@endif
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rw-like-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`{{ route('user.post.like', ':id') }}`.replace(':id', postId), {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            })
            .then(r => r.json())
            .then(data => {
                const liked = data.liked;
                this.innerHTML = liked
                    ? `<svg width="15" height="15" viewBox="0 0 15 15" fill="#c8533a"><path d="M7.5 13S1.5 9.5 1.5 5.5A3 3 0 017.5 3.1 3 3 0 0113.5 5.5C13.5 9.5 7.5 13 7.5 13z"/></svg>`
                    : `<svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M7.5 13S1.5 9.5 1.5 5.5A3 3 0 017.5 3.1 3 3 0 0113.5 5.5C13.5 9.5 7.5 13 7.5 13z" stroke="#888" stroke-width="1.4"/></svg>`;
                this.classList.toggle('liked', liked);
                this.dataset.liked = liked ? '1' : '0';
                const countEl = document.querySelector(`.rw-like-count[data-post-id="${postId}"]`);
                if (countEl) countEl.textContent = data.total;
            })
            .catch(console.error);
        });
    });
});
</script>

@endsection