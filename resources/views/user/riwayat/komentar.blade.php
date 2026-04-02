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
    --green:       #1a7431;
    --green-soft:  #eaf5ec;
    --red:         #c0392b;
    --red-soft:    #fdf2f2;
    --blue:        #2563eb;
    --blue-soft:   #eff6ff;
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

/* ===================== SPLIT GRID ===================== */
.rw-split { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

/* ===================== SECTION CARD ===================== */
.rw-section-card { background: var(--white); border-radius: var(--r-xl); box-shadow: var(--shadow-sm); overflow: hidden; display: flex; flex-direction: column; }
.rw-section-header { padding: 16px 18px; border-bottom: 1px solid var(--warm-gray); display: flex; align-items: center; gap: 10px; }
.rw-section-icon { width: 32px; height: 32px; border-radius: var(--r-sm); display: grid; place-items: center; flex-shrink: 0; }
.rw-section-icon.active-icon { background: var(--green-soft); }
.rw-section-icon.banned-icon { background: var(--red-soft); }
.rw-section-title { font-size: 13.5px; font-weight: 600; color: var(--black); flex: 1; }
.rw-section-count { font-size: 12px; font-weight: 700; padding: 2px 10px; border-radius: 20px; }
.rw-section-count.active-count { background: var(--green-soft); color: var(--green); }
.rw-section-count.banned-count { background: var(--red-soft); color: var(--red); }

/* ===================== COMMENT LIST ===================== */
.rw-comments-list { flex: 1; overflow-y: auto; max-height: 600px; }
.rw-comment-item { padding: 16px 18px; border-bottom: 1px solid var(--warm-gray); transition: background .15s; animation: cardIn .35s ease both; }
@keyframes cardIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
.rw-comment-item:last-child { border-bottom: none; }
.rw-comment-item:hover { background: var(--cream); }
.rw-comment-item.banned { background: var(--red-soft); }
.rw-comment-item.banned:hover { background: #fae8e8; }

.rw-comment-top { display: flex; align-items: center; gap: 8px; margin-bottom: 9px; flex-wrap: wrap; }
.rw-status-pill { font-size: 10.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; flex-shrink: 0; }
.rw-status-pill.active { background: var(--green-soft); color: var(--green); }
.rw-status-pill.banned { background: var(--red-soft); color: var(--red); border: 1px solid #f5c0b8; }
.rw-comment-ref { font-size: 12px; color: var(--muted); flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rw-comment-time { font-size: 11.5px; color: var(--muted); flex-shrink: 0; }

.rw-comment-bubble { font-size: 13.5px; color: var(--black); line-height: 1.55; background: var(--cream); border: 1px solid var(--warm-gray); border-radius: var(--r-md); padding: 10px 13px; margin-bottom: 10px; }
.rw-comment-item.banned .rw-comment-bubble { background: var(--white); }

.rw-reply-tag { font-size: 12px; color: var(--muted); background: var(--cream); border-left: 3px solid var(--mid-gray); padding: 6px 10px; border-radius: 0 var(--r-sm) var(--r-sm) 0; margin-bottom: 10px; }
.rw-reply-tag strong { color: var(--black); font-weight: 600; }

/* Ban info box */
.rw-ban-box { background: var(--white); border: 1.5px solid #f5c0b8; border-radius: var(--r-md); padding: 12px 14px; margin-bottom: 10px; }
.rw-ban-box-title { font-size: 11px; font-weight: 700; color: var(--red); text-transform: uppercase; letter-spacing: .6px; margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
.rw-ban-field { display: flex; gap: 6px; font-size: 12.5px; margin-bottom: 5px; }
.rw-ban-field:last-child { margin-bottom: 0; }
.rw-ban-key { font-weight: 600; color: var(--black); flex-shrink: 0; min-width: 60px; }
.rw-ban-val { color: #555; }

/* Delete button */
.rw-comment-footer { display: flex; justify-content: flex-end; }
.rw-delete-btn {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600; font-family: 'DM Sans', sans-serif;
    color: var(--red); background: var(--red-soft); border: 1px solid #f5c0b8;
    padding: 5px 12px; border-radius: 20px; cursor: pointer; transition: all .2s;
}
.rw-delete-btn:hover { background: var(--red); color: var(--white); border-color: var(--red); }

/* Empty inline */
.rw-empty-inline { text-align: center; padding: 40px 20px; }
.rw-empty-inline-icon { width: 48px; height: 48px; background: var(--cream); border-radius: 50%; display: grid; place-items: center; margin: 0 auto 14px; }
.rw-empty-inline h5 { font-size: 14px; font-weight: 600; color: var(--black); margin-bottom: 5px; }
.rw-empty-inline p { font-size: 12.5px; color: var(--muted); }

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

@media (max-width: 760px) {
    .rw-split { grid-template-columns: 1fr; }
}

@media (max-width: 560px) {
    .rw-inner { padding: 0 12px; }
    .rw-page { padding-top: 20px; }
    .rw-ban-field { flex-direction: column; gap: 2px; }
    .rw-ban-key { min-width: unset; font-size: 11px; }
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

                    <a href="{{ route('user.riwayat.komentar') }}" class="rw-nav-item active">
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
                        @if(isset($totalLikes) && $totalLikes > 0)<span class="rw-nav-badge">{{ $totalLikes }}</span>@endif
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
                <h1>Riwayat Komentar</h1>
                <p>Semua komentar yang pernah kamu tulis dan komentar yang dibanned</p>
            </div>

            <div class="rw-split">

                {{-- ── Komentar Aktif ── --}}
                <div class="rw-section-card">
                    <div class="rw-section-header">
                        <div class="rw-section-icon active-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M12.5 1.5H2.5a.5.5 0 00-.5.5v7a.5.5 0 00.5.5H4l3 3 3-3h2.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#1a7431" stroke-width="1.3"/>
                            </svg>
                        </div>
                        <span class="rw-section-title">Komentar Aktif</span>
                        <span class="rw-section-count active-count">{{ $activeComments->count() }}</span>
                    </div>

                    <div class="rw-comments-list">
                        @forelse($activeComments as $comment)
                            <div class="rw-comment-item">
                                <div class="rw-comment-top">
                                    <span class="rw-status-pill active">Aktif</span>
                                    <span class="rw-comment-ref">{{ Str::limit($comment->post->caption ?? 'Postingan', 28) }}</span>
                                    <span class="rw-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="rw-comment-bubble">{{ $comment->comment }}</div>
                                @if($comment->reply_id)
                                    <div class="rw-reply-tag">
                                        <strong>Balasan:</strong>
                                        <span>{{ Str::limit($comment->parent->comment ?? '—', 50) }}</span>
                                    </div>
                                @endif
                                @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                    <div class="rw-comment-footer">
                                        <button type="button" class="rw-delete-btn"
                                                data-id="{{ $comment->id }}"
                                                data-url="{{ route('user.comments.destroy', $comment->id) }}"
                                                onclick="deleteComment(this)">
                                            <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                                                <path d="M1.5 2.5h8M3.5 2.5V2a.5.5 0 01.5-.5h2a.5.5 0 01.5.5v.5M8.5 2.5l-.5 7a.5.5 0 01-.5.5h-4a.5.5 0 01-.5-.5l-.5-7" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="rw-empty-inline">
                                <div class="rw-empty-inline-icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M16.5 2H3.5a.5.5 0 00-.5.5v10a.5.5 0 00.5.5H6l4 4 4-4h2.5a.5.5 0 00.5-.5V2.5a.5.5 0 00-.5-.5z" stroke="#b8b3ac" stroke-width="1.5"/>
                                    </svg>
                                </div>
                                <h5>Belum Ada Komentar</h5>
                                <p>Kamu belum menulis komentar apapun</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ── Komentar Dibanned ── --}}
                <div class="rw-section-card">
                    <div class="rw-section-header">
                        <div class="rw-section-icon banned-icon">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <circle cx="7.5" cy="7.5" r="6" stroke="#c0392b" stroke-width="1.3"/>
                                <path d="M5 5l5 5M10 5L5 10" stroke="#c0392b" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span class="rw-section-title">Komentar Dibanned</span>
                        <span class="rw-section-count banned-count">{{ $bannedComments->count() }}</span>
                    </div>

                    <div class="rw-comments-list">
                        @forelse($bannedComments as $comment)
                            <div class="rw-comment-item banned">
                                <div class="rw-comment-top">
                                    <span class="rw-status-pill banned">Dibanned</span>
                                    <span class="rw-comment-ref">{{ Str::limit($comment->post->caption ?? 'Postingan', 28) }}</span>
                                    <span class="rw-comment-time">{{ $comment->bans->first()->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="rw-comment-bubble">{{ $comment->comment }}</div>
                                <div class="rw-ban-box">
                                    <div class="rw-ban-box-title">
                                        <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                                            <circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/>
                                            <path d="M3.5 3.5l4 4M7.5 3.5l-4 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                                        </svg>
                                        Info Ban
                                    </div>
                                    <div class="rw-ban-field">
                                        <span class="rw-ban-key">Alasan:</span>
                                        <span class="rw-ban-val">{{ $comment->bans->first()->reason }}</span>
                                    </div>
                                    @if($comment->bans->first()->notes)
                                        <div class="rw-ban-field">
                                            <span class="rw-ban-key">Catatan:</span>
                                            <span class="rw-ban-val">{{ $comment->bans->first()->notes }}</span>
                                        </div>
                                    @endif
                                    <div class="rw-ban-field">
                                        <span class="rw-ban-key">Admin:</span>
                                        <span class="rw-ban-val">{{ $comment->bans->first()->admin->name }}</span>
                                    </div>
                                </div>
                                @if($comment->reply_id)
                                    <div class="rw-reply-tag">
                                        <strong>Balasan:</strong>
                                        <span>{{ Str::limit($comment->parent->comment ?? '—', 50) }}</span>
                                    </div>
                                @endif
                                @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                    <div class="rw-comment-footer">
                                        <button type="button" class="rw-delete-btn"
                                                data-id="{{ $comment->id }}"
                                                data-url="{{ route('user.comments.destroy', $comment->id) }}"
                                                onclick="deleteComment(this)">
                                            <svg width="11" height="11" viewBox="0 0 11 11" fill="none">
                                                <path d="M1.5 2.5h8M3.5 2.5V2a.5.5 0 01.5-.5h2a.5.5 0 01.5.5v.5M8.5 2.5l-.5 7a.5.5 0 01-.5.5h-4a.5.5 0 01-.5-.5l-.5-7" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="rw-empty-inline">
                                <div class="rw-empty-inline-icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <circle cx="10" cy="10" r="8" stroke="#b8b3ac" stroke-width="1.5"/>
                                        <path d="M7 7l6 6M13 7l-6 6" stroke="#b8b3ac" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <h5>Tidak Ada Komentar Dibanned</h5>
                                <p>Semua komentarmu baik-baik saja</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
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

        <a href="{{ route('user.riwayat.komentar') }}" class="rw-mob-item active">
            @if($totalComments > 0)<span class="rw-mob-badge">{{ $totalComments > 9 ? '9+' : $totalComments }}</span>@endif
            <div class="rw-mob-icon">
                <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                    <path d="M14 2H3a.5.5 0 00-.5.5v8a.5.5 0 00.5.5h3.5l3 3 3-3H14a.5.5 0 00.5-.5V2.5A.5.5 0 0014 2z" stroke="currentColor" stroke-width="1.4"/>
                </svg>
            </div>
            <span class="rw-mob-label">Komentar</span>
        </a>

        <a href="{{ route('user.riwayat.like') }}" class="rw-mob-item">
            @if(isset($totalLikes) && $totalLikes > 0)<span class="rw-mob-badge">{{ $totalLikes > 9 ? '9+' : $totalLikes }}</span>@endif
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
function deleteComment(button) {
    if (!confirm('Hapus komentar ini?')) return;
    const url = button.getAttribute('data-url');
    const form = document.createElement('form');
    form.method = 'POST'; form.action = url;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (csrf) { const t = document.createElement('input'); t.type='hidden'; t.name='_token'; t.value=csrf; form.appendChild(t); }
    const m = document.createElement('input'); m.type='hidden'; m.name='_method'; m.value='DELETE'; form.appendChild(m);
    document.body.appendChild(form); form.submit();
}
</script>

@endsection