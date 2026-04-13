@extends('layouts.index2')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">

<style>
:root {
    --ch-bg: #f5efe8;
    --ch-panel: #ffffff;
    --ch-soft: #faf6f0;
    --ch-border: #e8ddd0;
    --ch-text: #1e1812;
    --ch-muted: #7a6f65;
    --ch-accent: #bd5b3f;
    --ch-accent-d: #9b452d;
    --ch-accent-light: #fbeee8;
    --ch-self-bg: #1e1812;
    --ch-self-text: #ffffff;
    --ch-other-bg: #ffffff;
    --ch-other-text: #1e1812;
    --ch-online: #22c55e;
    --radius-xl: 28px;
    --radius-lg: 20px;
    --radius-md: 14px;
    --radius-sm: 10px;
    --shadow-sm: 0 2px 12px rgba(31,24,18,.06);
    --shadow-md: 0 8px 32px rgba(31,24,18,.10);
    --shadow-lg: 0 20px 60px rgba(31,24,18,.12);
    --transition: .18s cubic-bezier(.4,0,.2,1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
.body-wrapper { margin-top: 0 !important; }
.container-fluid { padding: 0 !important; max-width: 100% !important; }

/* ─── SHELL ────────────────────────────────────────── */
.ch-shell {
    height: calc(100vh - 64px);
    padding: 16px;
    background:
        radial-gradient(ellipse at 80% 10%, rgba(189,91,63,.14) 0%, transparent 40%),
        radial-gradient(ellipse at 10% 90%, rgba(189,91,63,.08) 0%, transparent 35%),
        linear-gradient(160deg, #fdfaf5 0%, #f5efe8 100%);
    font-family: 'DM Sans', sans-serif;
    display: flex;
    flex-direction: column;
}

/* ─── LAYOUT ────────────────────────────────────────── */
.ch-layout {
    display: grid;
    grid-template-columns: 300px minmax(0, 1fr);
    gap: 14px;
    flex: 1;
    min-height: 0;
}

/* ─── SIDEBAR ───────────────────────────────────────── */
.ch-sidebar {
    background: var(--ch-panel);
    border: 1px solid var(--ch-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform var(--transition), opacity var(--transition);
}

.ch-sidebar-head {
    padding: 20px 18px 14px;
    border-bottom: 1px solid var(--ch-border);
    background: linear-gradient(135deg, #fdfaf6 0%, #fff 100%);
    flex-shrink: 0;
}

.ch-sidebar-head-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.ch-sidebar-head h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--ch-text);
    letter-spacing: -.3px;
}

.ch-new-chat-btn {
    width: 32px; height: 32px;
    border-radius: 10px;
    border: 1px solid var(--ch-border);
    background: var(--ch-soft);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ch-accent);
    font-size: 18px;
    transition: background var(--transition), transform var(--transition);
}
.ch-new-chat-btn:hover { background: var(--ch-accent-light); transform: scale(1.06); }

.ch-search-wrap {
    position: relative;
}
.ch-search-icon {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: var(--ch-muted); font-size: 13px; pointer-events: none;
}
.ch-search-input {
    width: 100%;
    background: var(--ch-soft);
    border: 1px solid var(--ch-border);
    border-radius: 24px;
    padding: 8px 14px 8px 34px;
    font-size: 13px;
    color: var(--ch-text);
    font-family: inherit;
    outline: none;
    transition: border var(--transition), background var(--transition);
}
.ch-search-input::placeholder { color: var(--ch-muted); }
.ch-search-input:focus { border-color: var(--ch-accent); background: #fffdfa; }

.ch-section-label {
    padding: 12px 18px 4px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--ch-muted);
    flex-shrink: 0;
}

.ch-user-list {
    padding: 6px 8px 10px;
    overflow-y: auto;
    flex: 1;
    scrollbar-width: thin;
    scrollbar-color: var(--ch-border) transparent;
}
.ch-user-list::-webkit-scrollbar { width: 4px; }
.ch-user-list::-webkit-scrollbar-track { background: transparent; }
.ch-user-list::-webkit-scrollbar-thumb { background: var(--ch-border); border-radius: 4px; }

.ch-user-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    border: 1px solid transparent;
    background: transparent;
    border-radius: var(--radius-md);
    padding: 10px 10px;
    text-align: left;
    cursor: pointer;
    transition: background var(--transition), border-color var(--transition), transform var(--transition);
    position: relative;
}
.ch-user-item:hover {
    background: var(--ch-soft);
    transform: translateX(2px);
}
.ch-user-item.active {
    background: linear-gradient(135deg, #fbeee8 0%, #fff5f0 100%);
    border-color: rgba(189,91,63,.22);
}

/* Avatar */
.ch-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; font-weight: 700; color: #fff;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}
.ch-avatar img {
    width: 100%; height: 100%;
    object-fit: cover; border-radius: 50%;
}
.ch-avatar-online::after {
    content: '';
    position: absolute; bottom: 1px; right: 1px;
    width: 11px; height: 11px;
    border-radius: 50%;
    background: var(--ch-online);
    border: 2px solid #fff;
}

.ch-user-body { flex: 1; min-width: 0; }
.ch-user-name {
    font-size: 13px; font-weight: 600; color: var(--ch-text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 2px;
}
.ch-user-preview {
    font-size: 11.5px; color: var(--ch-muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.ch-user-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
.ch-time-label { font-size: 10px; color: var(--ch-muted); }
.ch-badge {
    min-width: 18px; height: 18px; padding: 0 5px;
    border-radius: 999px;
    background: var(--ch-accent);
    color: #fff; font-size: 10px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
}

/* ─── MAIN ──────────────────────────────────────────── */
.ch-main {
    background: var(--ch-panel);
    border: 1px solid var(--ch-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Empty state */
.ch-empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 40px;
    text-align: center;
}
.ch-empty-icon {
    width: 64px; height: 64px;
    border-radius: 20px;
    background: linear-gradient(135deg, #fbeee8, #fdf5f0);
    border: 1px solid rgba(189,91,63,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px;
    margin-bottom: 6px;
}
.ch-empty-state h3 { font-size: 18px; font-weight: 600; color: var(--ch-text); }
.ch-empty-state p { font-size: 13px; color: var(--ch-muted); max-width: 220px; line-height: 1.5; }

/* Header */
.ch-header {
    display: none;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--ch-border);
    background: linear-gradient(135deg, #fdfaf6 0%, #fff 100%);
    flex-shrink: 0;
}
.ch-header.show { display: flex; }

.ch-back-btn {
    display: none;
    width: 34px; height: 34px;
    border-radius: 10px;
    border: 1px solid var(--ch-border);
    background: var(--ch-soft);
    cursor: pointer;
    align-items: center; justify-content: center;
    color: var(--ch-muted);
    font-size: 16px;
    transition: background var(--transition);
    flex-shrink: 0;
}
.ch-back-btn:hover { background: var(--ch-accent-light); color: var(--ch-accent); }

.ch-header-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #bd5b3f, #d47a5e);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 15px; font-weight: 700;
    flex-shrink: 0;
    overflow: hidden;
    position: relative;
}
.ch-header-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

.ch-header-info { flex: 1; min-width: 0; }
.ch-header-info h3 { font-size: 15px; font-weight: 700; color: var(--ch-text); }
.ch-header-status { font-size: 11px; font-weight: 500; color: var(--ch-muted); margin-top: 1px; }
.ch-header-status.online { color: var(--ch-online); }

.ch-header-actions { display: flex; gap: 6px; }
.ch-icon-btn {
    width: 34px; height: 34px;
    border-radius: 10px;
    border: 1px solid var(--ch-border);
    background: var(--ch-soft);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ch-muted);
    font-size: 15px;
    transition: background var(--transition), color var(--transition);
}
.ch-icon-btn:hover { background: var(--ch-accent-light); color: var(--ch-accent); }
/* Messages */
.ch-messages {
    display: none;
    flex: 1;
    flex-direction: column;
    gap: 10px;
    padding: 20px;
    overflow-y: auto;
    background:
        radial-gradient(circle at top right, rgba(189,91,63,.07) 0%, transparent 40%),
        linear-gradient(180deg, #faf6f0 0%, #fff 100%);
    scrollbar-width: thin;
    scrollbar-color: var(--ch-border) transparent;
}
.ch-messages::-webkit-scrollbar { width: 4px; }
.ch-messages::-webkit-scrollbar-track { background: transparent; }
.ch-messages::-webkit-scrollbar-thumb { background: var(--ch-border); border-radius: 4px; }
.ch-messages.show { display: flex; }

.ch-date-divider {
    align-self: center;
    padding: 4px 14px;
    border-radius: 999px;
    background: rgba(255,255,255,.9);
    border: 1px solid var(--ch-border);
    color: var(--ch-muted);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .2px;
    margin: 4px 0;
}

.ch-row {
    display: flex;
    flex-direction: column;
    max-width: min(75%, 520px);
    gap: 3px;
}
.ch-row.self { align-self: flex-end; align-items: flex-end; }
.ch-row.other { align-self: flex-start; align-items: flex-start; }
.ch-bubble-wrap {
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.ch-row.self .ch-bubble-wrap { flex-direction: row-reverse; }

.ch-bubble {
    padding: 10px 15px;
    border-radius: 20px;
    font-size: 13.5px;
    line-height: 1.55;
    word-break: break-word;
    position: relative;
}
.ch-row.self .ch-bubble {
    background: var(--ch-self-bg);
    color: var(--ch-self-text);
    border-bottom-right-radius: 5px;
    box-shadow: 0 4px 14px rgba(31,24,18,.18);
}
.ch-row.other .ch-bubble {
    background: var(--ch-other-bg);
    color: var(--ch-other-text);
    border: 1px solid rgba(232,221,208,.9);
    border-bottom-left-radius: 5px;
    box-shadow: var(--shadow-sm);
}
.ch-msg-delete {
    width: 28px;
    height: 28px;
    border: 0;
    border-radius: 999px;
    background: #fff1ef;
    color: #d64545;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    opacity: 0;
    pointer-events: none;
    transform: translateY(4px);
    transition: opacity var(--transition), transform var(--transition), background var(--transition);
}
.ch-row.self:hover .ch-msg-delete {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
}
.ch-msg-delete:hover { background: #ffe4de; }
.ch-msg-delete:disabled {
    opacity: .45;
    pointer-events: none;
}

.ch-msg-meta {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 10px;
    color: var(--ch-muted);
    padding: 0 4px;
}
.ch-check { color: var(--ch-accent); font-size: 11px; }
.ch-check.sent { color: var(--ch-muted); }

/* Typing */
.ch-typing {
    display: flex;
    align-self: flex-start;
    max-width: min(75%, 520px);
}
.ch-typing-bubble {
    background: var(--ch-other-bg);
    border: 1px solid rgba(232,221,208,.9);
    border-radius: 20px;
    border-bottom-left-radius: 5px;
    padding: 12px 16px;
    display: flex;
    gap: 5px;
    box-shadow: var(--shadow-sm);
}
.ch-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #c4b9b0;
    animation: ch-bounce .9s ease-in-out infinite;
}
.ch-dot:nth-child(2) { animation-delay: .15s; }
.ch-dot:nth-child(3) { animation-delay: .3s; }
@keyframes ch-bounce {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-5px); }
}

/* Form */
.ch-form {
    display: none;
    gap: 10px;
    padding: 12px 16px 16px;
    border-top: 1px solid var(--ch-border);
    background: rgba(255,255,255,.96);
    align-items: flex-end;
    flex-shrink: 0;
}
.ch-form.show { display: flex; }

.ch-input-wrap {
    flex: 1;
    background: var(--ch-soft);
    border: 1.5px solid var(--ch-border);
    border-radius: 20px;
    display: flex;
    align-items: flex-end;
    padding: 4px 12px;
    transition: border-color var(--transition), box-shadow var(--transition);
    min-height: 44px;
}
.ch-input-wrap:focus-within {
    border-color: var(--ch-accent);
    box-shadow: 0 0 0 3px rgba(189,91,63,.10);
}

.ch-input-wrap textarea {
    flex: 1;
    background: transparent;
    border: 0;
    outline: none;
    padding: 10px 4px 10px 0;
    font-size: 13.5px;
    font-family: inherit;
    color: var(--ch-text);
    resize: none;
    max-height: 120px;
    line-height: 1.45;
}
.ch-input-wrap textarea::placeholder { color: var(--ch-muted); }
.ch-emoji-wrap {
    position: relative;
    display: flex;
    align-items: center;
    flex-shrink: 0;
}
.ch-emoji-btn {
    border: 0;
    background: transparent;
    color: var(--ch-muted);
    font-size: 18px;
    cursor: pointer;
    padding-bottom: 8px;
    line-height: 1;
    transition: transform var(--transition);
}
.ch-emoji-btn:hover { transform: scale(1.2); }
.ch-emoji-panel {
    position: absolute;
    right: 0;
    bottom: calc(100% + 10px);
    width: 230px;
    padding: 12px;
    border-radius: 18px;
    background: #fffdf9;
    border: 1px solid var(--ch-border);
    box-shadow: var(--shadow-lg);
    display: none;
    z-index: 20;
}
.ch-emoji-panel.show { display: block; }
.ch-emoji-panel-title {
    font-size: 11px;
    font-weight: 700;
    color: var(--ch-muted);
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: .7px;
}
.ch-emoji-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 8px;
}
.ch-emoji-item {
    width: 100%;
    aspect-ratio: 1;
    border: 0;
    border-radius: 12px;
    background: transparent;
    cursor: pointer;
    font-size: 20px;
    line-height: 1;
    transition: transform var(--transition), background var(--transition);
}
.ch-emoji-item:hover {
    background: var(--ch-accent-light);
    transform: scale(1.08);
}

.ch-send-btn {
    width: 44px; height: 44px;
    border-radius: 14px;
    border: 0;
    background: linear-gradient(135deg, var(--ch-accent), var(--ch-accent-d));
    color: #fff;
    font-size: 17px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(189,91,63,.35);
    transition: transform var(--transition), box-shadow var(--transition), opacity var(--transition);
}
.ch-send-btn:hover { transform: scale(1.06) translateY(-1px); box-shadow: 0 6px 20px rgba(189,91,63,.45); }
.ch-send-btn:active { transform: scale(.97); }
.ch-send-btn:disabled { opacity: .45; cursor: not-allowed; transform: none; box-shadow: none; }

/* Firestore note */
.ch-note {
    padding: 0 20px 10px;
    font-size: 11px;
    color: var(--ch-muted);
    flex-shrink: 0;
    display: none;
}
.ch-note.show { display: block; }

/* ─── RESPONSIVE ─────────────────────────────────────── */
@media (max-width: 768px) {
    .ch-shell { padding: 0; height: calc(100vh - 64px); border-radius: 0; }
    .ch-layout { grid-template-columns: 1fr; gap: 0; }

    .ch-sidebar {
        border-radius: 0;
        box-shadow: none;
        border: none;
        border-bottom: 1px solid var(--ch-border);
        position: absolute; inset: 64px 0 0 0;
        z-index: 10;
        transform: translateX(0);
        transition: transform var(--transition), opacity var(--transition);
    }
    .ch-sidebar.hidden {
        transform: translateX(-100%);
        opacity: 0;
        pointer-events: none;
    }

    .ch-main {
        border-radius: 0;
        box-shadow: none;
        border: none;
        position: absolute; inset: 64px 0 0 0;
        z-index: 5;
    }

    .ch-back-btn { display: flex !important; }
    .ch-row { max-width: 88%; }
    .ch-layout { position: relative; }
}
</style>

<div class="ch-shell">
    <div class="ch-layout" id="chLayout">

        {{-- ─── SIDEBAR ─────────────────────────── --}}
        <aside class="ch-sidebar" id="chSidebar">

            <div class="ch-sidebar-head">
                <div class="ch-sidebar-head-top">
                    <h2>Pesan</h2>
                </div>
                <div class="ch-search-wrap">
                    <span class="ch-search-icon">&#128269;</span>
                    <input class="ch-search-input" type="text" placeholder="Cari percakapan..." id="chSearchInput">
                </div>
            </div>

            <div class="ch-section-label">Terbaru</div>

            <div class="ch-user-list" id="chatUserList">
                @forelse($conversations as $conversation)
                    <button
                        class="ch-user-item"
                        type="button"
                        data-chat-id="{{ $conversation['conversation_id'] }}"
                        data-other-user-id="{{ $conversation['user']->id }}"
                        data-user-name="{{ $conversation['user']->username ?? $conversation['user']->name }}"
                        data-user-avatar="{{ $conversation['user']->avatar_display }}"
                    >
                        <div class="ch-avatar" style="background: linear-gradient(135deg, #bd5b3f, #d47a5e);">
                            <img
                                src="{{ $conversation['user']->avatar_display }}"
                                alt="{{ $conversation['user']->username ?? $conversation['user']->name }}"
                                onerror="this.style.display='none'; this.parentElement.textContent='{{ strtoupper(substr($conversation['user']->username ?? $conversation['user']->name, 0, 2)) }}';"
                            >
                        </div>
                        <div class="ch-user-body">
                            <div class="ch-user-name">{{ $conversation['user']->username ?? $conversation['user']->name }}</div>
                            <div class="ch-user-preview" id="preview_{{ $conversation['conversation_id'] }}">Memuat...</div>
                        </div>
                        <div class="ch-user-meta">
                            <span class="ch-time-label">--:--</span>
                        </div>
                    </button>
                @empty
                    <div class="ch-empty-state">
                        <div class="ch-empty-icon">💬</div>
                        <h3>Belum ada percakapan</h3>
                        <p>Buka profil pengguna lain untuk memulai chat baru.</p>
                    </div>
                @endforelse
            </div>

        </aside>

        {{-- ─── MAIN ────────────────────────────── --}}
        <section class="ch-main" id="chMain">

            <div class="ch-empty-state" id="chatEmptyState">
                <div class="ch-empty-icon">💬</div>
                <h3>Pilih percakapan</h3>
                <p>Pesan akan tampil realtime tanpa refresh halaman.</p>
            </div>

            <div class="ch-header" id="chatHeader">
                <button class="ch-back-btn" id="chBackBtn">&#8592;</button>
                <div class="ch-header-avatar" id="chatHeaderAvatar">--</div>
                <div class="ch-header-info">
                    <h3 id="chatHeaderName">-</h3>
                    <div class="ch-header-status" id="chatHeaderStatus"></div>
                </div>
            </div>

            <div class="ch-messages" id="chatMessages"></div>

            <form class="ch-form" id="chatForm">
                <div class="ch-input-wrap">
                    <textarea
                        id="chatInput"
                        placeholder="Tulis pesan…"
                        rows="1"
                    ></textarea>
                    <div class="ch-emoji-wrap">
                        <button type="button" class="ch-emoji-btn" id="chatEmojiButton" title="Tambah emote">😊</button>
                        <div class="ch-emoji-panel" id="chatEmojiPanel">
                            <div class="ch-emoji-panel-title">Pilih emote</div>
                            <div class="ch-emoji-grid" id="chatEmojiGrid"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="ch-send-btn" id="chatSendButton" disabled>&#10148;</button>
            </form>

        </section>
    </div>
</div>

<script type="module">
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js';
import {
    getAuth,
    signInWithCustomToken,
} from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-auth.js';
import {
    addDoc,
    collection,
    deleteDoc,
    doc,
    getFirestore,
    setDoc,
    limit,
    onSnapshot,
    orderBy,
    query,
    serverTimestamp,
} from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-firestore.js';

/* ─── Firebase Config ─────────────────────────────── */
const firebaseConfig = {
    apiKey: 'AIzaSyCUAAmjfFRw3o0t2Ifwj8zarmBTBNj_c1Y',
    authDomain: 'aperture-62cbb.firebaseapp.com',
    projectId: 'aperture-62cbb',
    storageBucket: 'aperture-62cbb.firebasestorage.app',
    messagingSenderId: '795719998676',
    appId: '1:795719998676:web:d668473fc5bdc1ae0b2f41',
    measurementId: 'G-9GD9M5VPYR'
};

const firebaseApp = initializeApp(firebaseConfig);
const db          = getFirestore(firebaseApp);
const firebaseAuth = getAuth(firebaseApp);

/* ─── Laravel vars ────────────────────────────────── */
const authId         = {{ auth()->id() }};
const autoOpenChatId = @json($openConvId);
const csrfToken      = @json(csrf_token());

/* ─── DOM refs ────────────────────────────────────── */
const userList        = document.getElementById('chatUserList');
const emptyState      = document.getElementById('chatEmptyState');
const header          = document.getElementById('chatHeader');
const headerAvatar    = document.getElementById('chatHeaderAvatar');
const headerName      = document.getElementById('chatHeaderName');
const headerStatus    = document.getElementById('chatHeaderStatus');
const messagesEl      = document.getElementById('chatMessages');
const form            = document.getElementById('chatForm');
const input           = document.getElementById('chatInput');
const sendButton      = document.getElementById('chatSendButton');
const emojiButton     = document.getElementById('chatEmojiButton');
const emojiPanel      = document.getElementById('chatEmojiPanel');
const emojiGrid       = document.getElementById('chatEmojiGrid');
const backBtn         = document.getElementById('chBackBtn');
const chSidebar       = document.getElementById('chSidebar');
const searchInput     = document.getElementById('chSearchInput');

/* ─── State ───────────────────────────────────────── */
let activeChatId     = null;
let activeChatKey    = null;
let unsubscribeMsgs  = null;
const sidebarUnsubs  = [];
let firebaseReady    = false;
let firebaseError    = 'Firebase belum siap.';
const emojiList      = ['😊', '😂', '😍', '🥹', '😭', '🔥', '👍', '🙏', '✨', '🤍', '🤝', '😎', '🥳', '😴', '🤔', '😅', '😡', '💯'];

/* ─── Helpers ─────────────────────────────────────── */
const isMobile = () => window.innerWidth <= 768;

const escapeHtml = v => {
    const d = document.createElement('div');
    d.textContent = v ?? '';
    return d.innerHTML;
};

const normalizeDate = v => {
    if (v?.toDate) return v.toDate();
    if (v instanceof Date) return v;
    return new Date();
};

const formatDateLabel = d => d.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
const formatTime      = d => d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

const scrollBottom = () => { messagesEl.scrollTop = messagesEl.scrollHeight; };

const buildChatKey = (a, b) => {
    const pair = [Number(a), Number(b)].sort((x, y) => x - y);
    return `chat_${pair[0]}_${pair[1]}`;
};
const getSeenStorageKey = chatId => `chat:last-seen:${authId}:${chatId}`;

const setComposerEnabled = on => {
    input.disabled    = !on;
    sendButton.disabled = !on || !input.value.trim();
};

const getInitials = name => name ? name.split(' ').slice(0,2).map(w => w[0]).join('').toUpperCase() : '--';

const renderStatus = (title, body) => {
    messagesEl.innerHTML = `
        <div style="margin:auto;text-align:center;padding:40px;">
            <div style="font-size:13px;font-weight:600;color:var(--ch-text);margin-bottom:4px;">${escapeHtml(title)}</div>
            <div style="font-size:12px;color:var(--ch-muted);">${escapeHtml(body)}</div>
        </div>`;
};

/* ─── Firebase Auth ───────────────────────────────── */
const fetchCustomToken = async () => {
    const r = await fetch('{{ route('user.firebase.custom-token') }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({}),
    });
    if (!r.ok) {
        const p = await r.json().catch(() => ({}));
        throw new Error(p.message || 'Gagal membuat custom token.');
    }
    return r.json();
};

const bootFirebase = async () => {
    const payload = await fetchCustomToken();
    if (payload.uid !== String(authId)) throw new Error('UID Firebase tidak cocok.');
    await signInWithCustomToken(firebaseAuth, payload.token);
    firebaseReady = true;
    setComposerEnabled(true);
};

/* ─── Render messages ─────────────────────────────── */
const renderMessages = msgs => {
    messagesEl.innerHTML = '';
    if (!msgs.length) {
        renderStatus('Belum ada pesan', 'Mulai percakapan dari kotak input di bawah.');
        return;
    }
    let prevDate = null;
    msgs.forEach(msg => {
        const date      = normalizeDate(msg.created_at);
        const dateLabel = formatDateLabel(date);
        if (dateLabel !== prevDate) {
            messagesEl.insertAdjacentHTML('beforeend', `<div class="ch-date-divider">${dateLabel}</div>`);
            prevDate = dateLabel;
        }
        const isSelf  = Number(msg.sender_id) === Number(authId);
        const safeText = escapeHtml(msg.text ?? '').replace(/\n/g, '<br>');
        const checkMark = isSelf
            ? `<span class="ch-check">&#10003;&#10003;</span>`
            : '';
        const deleteButtonHtml = isSelf
            ? `<button type="button" class="ch-msg-delete" data-message-id="${msg.id}" title="Hapus pesan">&#128465;</button>`
            : '';
        messagesEl.insertAdjacentHTML('beforeend', `
            <div class="ch-row ${isSelf ? 'self' : 'other'}">
                <div class="ch-bubble-wrap">
                    ${deleteButtonHtml}
                    <div class="ch-bubble">${safeText}</div>
                </div>
                <div class="ch-msg-meta">${formatTime(date)} ${checkMark}</div>
            </div>`);
    });

    if (activeChatId) {
        const lastDate = normalizeDate(msgs.at(-1)?.created_at);
        localStorage.setItem(
            getSeenStorageKey(activeChatId),
            String(lastDate ? lastDate.getTime() : Date.now())
        );
    }

    // Typing indicator
    messagesEl.insertAdjacentHTML('beforeend', `
        <div class="ch-typing" id="typingIndicator" style="display:none;">
            <div class="ch-typing-bubble">
                <div class="ch-dot"></div>
                <div class="ch-dot"></div>
                <div class="ch-dot"></div>
            </div>
        </div>`);
    scrollBottom();
};

/* ─── Update sidebar preview ──────────────────────── */
const updatePreview = (chatId, text) => {
    const el = document.getElementById(`preview_${chatId}`);
    if (el) el.textContent = (text || 'Belum ada pesan').slice(0, 42);
};

const handleDeleteMessage = async messageId => {
    if (!activeChatKey || !messageId) return;

    const confirmed = window.confirm('Hapus pesan ini?');
    if (!confirmed) return;

    const deleteTarget = messagesEl.querySelector(`[data-message-id="${messageId}"]`);
    if (deleteTarget) deleteTarget.disabled = true;

    try {
        await deleteDoc(doc(db, `chats/${activeChatKey}/messages`, messageId));
    } catch (error) {
        console.error(error);
        alert('Pesan gagal dihapus.');
        if (deleteTarget) deleteTarget.disabled = false;
    }
};

/* ─── Sidebar previews listener ───────────────────── */
const hydratePreviews = () => {
    userList.querySelectorAll('.ch-user-item').forEach(item => {
        const key  = buildChatKey(authId, item.dataset.otherUserId);
        const q    = query(collection(db, `chats/${key}/messages`), orderBy('created_at','desc'), limit(1));
        const unsub = onSnapshot(q, snap => {
            const last = snap.docs[0]?.data({ serverTimestamps:'estimate' });
            const timeEl = item.querySelector('.ch-time-label');
            if (last?.created_at) {
                const d = normalizeDate(last.created_at);
                if (timeEl) timeEl.textContent = formatTime(d);
            }
            updatePreview(item.dataset.chatId, last?.text ?? 'Belum ada pesan');
        }, err => console.error('Preview error', err));
        sidebarUnsubs.push(unsub);
    });
};

/* ─── Listen messages ─────────────────────────────── */
const listenMessages = key => {
    if (unsubscribeMsgs) unsubscribeMsgs();
    renderStatus('Memuat pesan...', 'Menyambungkan ke Firestore…');
    const q = query(collection(db, `chats/${key}/messages`), orderBy('created_at','asc'));
    unsubscribeMsgs = onSnapshot(q, snap => {
        const msgs = snap.docs.map(d => ({ id: d.id, ...d.data({ serverTimestamps:'estimate' }) }));
        renderMessages(msgs);
        updatePreview(activeChatId, msgs.at(-1)?.text ?? '');
    }, err => {
        console.error(err);
        renderStatus('Firestore gagal', 'Periksa Firestore Rules dan konfigurasi Firebase.');
    });
};

/* ─── Ensure chat doc ─────────────────────────────── */
const ensureChatDoc = async otherUserId => {
    await setDoc(doc(db, 'chats', activeChatKey), {
        participant_ids: [String(authId), String(otherUserId)].sort(),
        updated_at: serverTimestamp(),
        last_message: null,
    }, { merge: true });
};

/* ─── Sync URL ────────────────────────────────────── */
const syncUrl = chatId => {
    const url = new URL(window.location.href);
    if (chatId) {
        url.searchParams.set('open', chatId);
        localStorage.setItem(`chat:last-open:${authId}`, String(chatId));
    } else {
        url.searchParams.delete('open');
        localStorage.removeItem(`chat:last-open:${authId}`);
    }
    window.history.replaceState({}, '', url);
};

/* ─── Open conversation ───────────────────────────── */
const openConversation = async item => {
    userList.querySelectorAll('.ch-user-item').forEach(n => n.classList.remove('active'));
    item.classList.add('active');

    activeChatId  = item.dataset.chatId;
    activeChatKey = buildChatKey(authId, item.dataset.otherUserId);

    // Header
    const name   = item.dataset.userName;
    const avatar = item.dataset.userAvatar;
    headerName.textContent = name;
    headerAvatar.innerHTML = avatar
        ? `<img src="${avatar}" alt="${escapeHtml(name)}" onerror="this.style.display='none'; this.parentElement.textContent='${getInitials(name)}';">`
        : getInitials(name);
    headerStatus.textContent = '';
    headerStatus.className   = 'ch-header-status';

    emptyState.style.display = 'none';
    header.classList.add('show');
    messagesEl.classList.add('show');
    form.classList.add('show');
    localStorage.setItem(getSeenStorageKey(activeChatId), String(Date.now()));

    syncUrl(activeChatId);
    renderStatus('Membuka percakapan...', 'Menghubungkan akun ke Firebase…');

    // Mobile: hide sidebar, show main
    if (isMobile()) chSidebar.classList.add('hidden');

    try {
        await ensureChatDoc(item.dataset.otherUserId);
    } catch (e) {
        console.error(e);
        renderStatus('Chat tidak bisa dibuka', 'Dokumen chat gagal dibuat. Periksa Firestore rules.');
        return;
    }

    listenMessages(activeChatKey);
    input.focus();
};

/* ─── Go back (mobile) ───────────────────────────── */
backBtn.addEventListener('click', () => {
    chSidebar.classList.remove('hidden');
});

/* ─── Send message ────────────────────────────────── */
const sendMessage = async () => {
    const text = input.value.trim();
    if (!activeChatId || !text) return;
    sendButton.disabled = true;

    const otherUserId = userList.querySelector(`[data-chat-id="${activeChatId}"]`)?.dataset.otherUserId;

    try {
        await addDoc(collection(db, `chats/${activeChatKey}/messages`), {
            text,
            sender_id: String(authId),
            created_at: serverTimestamp(),
        });
        await setDoc(doc(db, 'chats', activeChatKey), {
            participant_ids: [String(authId), String(otherUserId)].sort(),
            updated_at: serverTimestamp(),
            last_message: text,
        }, { merge: true });

        input.value = '';
        input.style.height = 'auto';
        input.focus();
    } catch (e) {
        console.error(e);
        alert('Pesan gagal dikirim. Periksa konfigurasi Firebase.');
    } finally {
        sendButton.disabled = !input.value.trim();
    }
};

const insertEmoji = emoji => {
    const start = input.selectionStart ?? input.value.length;
    const end = input.selectionEnd ?? input.value.length;
    input.value = `${input.value.slice(0, start)}${emoji}${input.value.slice(end)}`;
    input.focus();
    const cursor = start + emoji.length;
    input.setSelectionRange(cursor, cursor);
    input.dispatchEvent(new Event('input', { bubbles: true }));
};


/* ─── Input auto-resize ───────────────────────────── */
input.addEventListener('input', () => {
    input.style.height = 'auto';
    input.style.height = `${Math.min(input.scrollHeight, 120)}px`;
    sendButton.disabled = !firebaseReady || !input.value.trim();
});

input.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        if (!sendButton.disabled) sendMessage();
    }
});

form.addEventListener('submit', async e => {
    e.preventDefault();
    await sendMessage();
});

messagesEl.addEventListener('click', async e => {
    const deleteBtn = e.target.closest('.ch-msg-delete');
    if (!deleteBtn) return;

    await handleDeleteMessage(deleteBtn.dataset.messageId);
});

emojiList.forEach(emoji => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'ch-emoji-item';
    button.textContent = emoji;
    button.title = `Tambahkan ${emoji}`;
    button.addEventListener('click', () => {
        insertEmoji(emoji);
        emojiPanel.classList.remove('show');
    });
    emojiGrid.appendChild(button);
});

emojiButton.addEventListener('click', e => {
    e.stopPropagation();
    emojiPanel.classList.toggle('show');
});

emojiPanel.addEventListener('click', e => {
    e.stopPropagation();
});

document.addEventListener('click', () => {
    emojiPanel.classList.remove('show');
});

/* ─── Search filter ───────────────────────────────── */
searchInput.addEventListener('input', () => {
    const q = searchInput.value.toLowerCase();
    userList.querySelectorAll('.ch-user-item').forEach(item => {
        item.style.display = item.dataset.userName.toLowerCase().includes(q) ? '' : 'none';
    });
});

/* ─── Boot ────────────────────────────────────────── */
setComposerEnabled(false);
renderStatus('Menyiapkan chat…', 'Sedang login ke Firebase secara aman...');

try {
    await bootFirebase();
    hydratePreviews();
} catch (e) {
    console.error(e);
    firebaseError = e.message || 'Custom token belum bisa dibuat.';
    renderStatus('Firebase belum siap', firebaseError);
}

/* ─── Auto-open remembered conversation ───────────── */
const remembered =
    autoOpenChatId ??
    new URL(window.location.href).searchParams.get('open') ??
    localStorage.getItem(`chat:last-open:${authId}`);

if (remembered) {
    const target = userList.querySelector(`[data-chat-id="${remembered}"]`);
    if (target && firebaseReady) openConversation(target);
}

/* ─── Click handlers ──────────────────────────────── */
userList.querySelectorAll('.ch-user-item').forEach(item => {
    item.addEventListener('click', () => {
        if (!firebaseReady) {
            alert(firebaseError);
            return;
        }
        openConversation(item);
    });
});

/* ─── Cleanup ─────────────────────────────────────── */
window.addEventListener('beforeunload', () => {
    if (unsubscribeMsgs) unsubscribeMsgs();
    sidebarUnsubs.forEach(u => u());
});
</script>
@endsection
