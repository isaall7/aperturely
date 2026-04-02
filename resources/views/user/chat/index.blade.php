@extends('layouts.index2')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --black:      #0a0a0a;
    --white:      #ffffff;
    --cream:      #f9f7f4;
    --warm-gray:  #e8e4df;
    --mid-gray:   #b8b3ac;
    --muted:      #888077;
    --accent:     #c8533a;
    --accent-h:   #a83f28;
    --accent-soft:#f5ece9;
    --online:     #22c55e;
    --shadow-sm:  0 1px 3px rgba(10,10,10,0.07);
    --shadow-md:  0 4px 16px rgba(10,10,10,0.10);
    --r-sm: 8px;
    --r-md: 14px;
    --r-lg: 20px;
    --r-xl: 28px;
    font-family: 'DM Sans', sans-serif;
}

.container-fluid { padding: 0 !important; max-width: 100% !important; }
.body-wrapper    { margin-top: 0 !important; }

.ch-page {
    background: var(--cream);
    height: calc(100vh - 64px);
    display: flex; padding: 20px; gap: 16px; overflow: hidden;
}

/* ── Sidebar ── */
.ch-sidebar {
    width: 300px; flex-shrink: 0;
    background: var(--white); border-radius: var(--r-xl);
    box-shadow: var(--shadow-sm); display: flex;
    flex-direction: column; overflow: hidden; transition: transform .25s;
}

.ch-sidebar-header { padding: 18px 18px 14px; border-bottom: 1px solid var(--warm-gray); flex-shrink: 0; }
.ch-sidebar-title  { font-size: 16px; font-weight: 600; color: var(--black); margin-bottom: 12px; }

.ch-search-wrap { position: relative; }
.ch-search-wrap input {
    width: 100%; height: 36px; background: var(--cream);
    border: 1.5px solid transparent; border-radius: 36px;
    padding: 0 14px 0 36px; font-size: 13px;
    font-family: 'DM Sans', sans-serif; color: var(--black);
    outline: none; transition: border-color .2s, background .2s;
}
.ch-search-wrap input:focus { background: var(--white); border-color: var(--accent); }
.ch-search-wrap input::placeholder { color: var(--muted); }
.ch-search-icon {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%); color: var(--muted); pointer-events: none; display: flex;
}

.ch-user-list { flex: 1; overflow-y: auto; padding: 8px; }
.ch-user-list::-webkit-scrollbar { width: 4px; }
.ch-user-list::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 10px; }

.ch-user-item {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 11px; border-radius: var(--r-md);
    cursor: pointer; transition: background .15s; border: 1.5px solid transparent;
}
.ch-user-item:hover  { background: var(--cream); }
.ch-user-item.active { background: var(--cream); border-color: var(--warm-gray); }

.ch-user-av-wrap { position: relative; flex-shrink: 0; }
.ch-user-av { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--warm-gray); display: block; }
.ch-online-dot { position: absolute; bottom: 1px; right: 1px; width: 11px; height: 11px; background: var(--online); border-radius: 50%; border: 2px solid var(--white); }

.ch-user-info { flex: 1; min-width: 0; }
.ch-user-name { font-size: 13.5px; font-weight: 600; color: var(--black); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ch-user-preview { font-size: 12px; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
.ch-user-preview.typing-preview { color: var(--accent); font-style: italic; font-weight: 500; }
.ch-user-item.unread .ch-user-preview { color: var(--black); font-weight: 500; }

.ch-user-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
.ch-user-time { font-size: 10.5px; color: var(--muted); }
.ch-unread-badge { min-width: 18px; height: 18px; background: var(--accent); color: var(--white); font-size: 10px; font-weight: 700; border-radius: 20px; display: flex; align-items: center; justify-content: center; padding: 0 5px; }
.ch-sidebar-empty { text-align: center; padding: 40px 20px; font-size: 13.5px; color: var(--muted); }

/* ── Main ── */
.ch-main { flex: 1; background: var(--white); border-radius: var(--r-xl); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; overflow: hidden; min-width: 0; }

.ch-empty-state { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; color: var(--muted); }
.ch-empty-icon  { width: 72px; height: 72px; background: var(--cream); border-radius: 50%; display: grid; place-items: center; }
.ch-empty-state h3 { font-size: 17px; font-weight: 600; color: var(--black); }
.ch-empty-state p  { font-size: 13.5px; }

.ch-chat-header { padding: 14px 20px; border-bottom: 1px solid var(--warm-gray); display: none; align-items: center; gap: 12px; flex-shrink: 0; }
.ch-chat-header.show { display: flex; }

.ch-back-btn { display: none; width: 34px; height: 34px; background: var(--cream); border: none; border-radius: 50%; cursor: pointer; align-items: center; justify-content: center; flex-shrink: 0; color: var(--black); transition: background .2s; }
.ch-back-btn:hover { background: var(--warm-gray); }

.ch-chat-av   { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid var(--warm-gray); flex-shrink: 0; }
.ch-chat-user { flex: 1; min-width: 0; }
.ch-chat-name { font-size: 14.5px; font-weight: 600; color: var(--black); }

/* Status: normal / typing */
.ch-chat-status         { font-size: 11.5px; color: var(--online); transition: color .2s; }
.ch-chat-status.offline { color: var(--muted); }
.ch-chat-status.typing  { color: var(--accent); font-style: italic; }

.ch-messages { flex: 1; overflow-y: auto; padding: 20px 20px 12px; display: none; flex-direction: column; gap: 4px; }
.ch-messages.show { display: flex; }
.ch-messages::-webkit-scrollbar { width: 5px; }
.ch-messages::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 10px; }

.ch-date-sep { text-align: center; font-size: 11.5px; color: var(--muted); padding: 8px 0; position: relative; flex-shrink: 0; }
.ch-date-sep::before { content: ''; position: absolute; left: 0; right: 0; top: 50%; height: 1px; background: var(--warm-gray); }
.ch-date-sep span { background: var(--white); padding: 0 12px; position: relative; z-index: 1; }

.ch-msg-row { display: flex; gap: 8px; align-items: flex-end; max-width: 72%; animation: msgIn .2s ease; }
@keyframes msgIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

.ch-msg-row.out { align-self: flex-end; flex-direction: row-reverse; }
.ch-msg-row.in  { align-self: flex-start; }
.ch-msg-row.in.consecutive .ch-msg-av { visibility: hidden; }

.ch-msg-av { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 1.5px solid var(--warm-gray); align-self: flex-end; }

.ch-msg-content { display: flex; flex-direction: column; gap: 2px; }
.ch-msg-row.out .ch-msg-content { align-items: flex-end; }
.ch-msg-row.in  .ch-msg-content { align-items: flex-start; }

.ch-bubble { padding: 10px 14px; font-size: 14px; line-height: 1.55; word-break: break-word; max-width: 100%; }
.ch-msg-row.in  .ch-bubble { background: var(--cream); color: var(--black); border-radius: 4px 18px 18px 18px; }
.ch-msg-row.out .ch-bubble { background: var(--black); color: var(--white); border-radius: 18px 4px 18px 18px; }
.ch-msg-row.in.first  .ch-bubble { border-radius: 18px 18px 18px 4px; }
.ch-msg-row.in.last   .ch-bubble { border-radius: 4px 18px 18px 18px; }
.ch-msg-row.out.first .ch-bubble { border-radius: 18px 18px 4px 18px; }
.ch-msg-row.out.last  .ch-bubble { border-radius: 18px 4px 18px 18px; }

.ch-msg-time { font-size: 10.5px; color: var(--muted); padding: 0 4px; flex-shrink: 0; }

/* ── Read receipt: ✓ → ✓✓ ── */
.ch-msg-row.out .ch-msg-time::after      { content: ' ✓';  color: var(--mid-gray); transition: color .3s; }
.ch-msg-row.out .ch-msg-time.read::after { content: ' ✓✓'; color: var(--accent); }

/* ── Typing indicator ── */
.ch-typing { display: none; align-self: flex-start; align-items: flex-end; gap: 8px; padding: 0 0 4px; animation: msgIn .2s ease; }
.ch-typing.show { display: flex; }
.ch-typing-bubble { background: var(--cream); border-radius: 4px 18px 18px 18px; padding: 12px 16px; display: flex; gap: 4px; align-items: center; }
.ch-typing-dot { width: 6px; height: 6px; background: var(--mid-gray); border-radius: 50%; animation: typingDot 1.2s infinite; }
.ch-typing-dot:nth-child(2) { animation-delay: .2s; }
.ch-typing-dot:nth-child(3) { animation-delay: .4s; }
@keyframes typingDot { 0%, 60%, 100% { transform: translateY(0); opacity: .6; } 30% { transform: translateY(-5px); opacity: 1; } }

.ch-load-spinner { align-self: center; margin: 40px auto; width: 28px; height: 28px; border: 2.5px solid var(--warm-gray); border-top-color: var(--black); border-radius: 50%; animation: spin .7s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.ch-input-area { padding: 12px 16px; border-top: 1px solid var(--warm-gray); display: none; align-items: flex-end; gap: 10px; flex-shrink: 0; background: var(--white); }
.ch-input-area.show { display: flex; }

.ch-input-wrap { flex: 1; background: var(--cream); border: 1.5px solid transparent; border-radius: var(--r-lg); padding: 10px 16px; display: flex; align-items: flex-end; gap: 8px; transition: border-color .2s, background .2s; min-height: 44px; max-height: 120px; }
.ch-input-wrap:focus-within { background: var(--white); border-color: var(--accent); }

#chInput { flex: 1; border: none; outline: none; background: transparent; font-size: 14px; font-family: 'DM Sans', sans-serif; color: var(--black); resize: none; max-height: 96px; line-height: 1.5; overflow-y: auto; }
#chInput::placeholder { color: var(--muted); }

.ch-send-btn { width: 38px; height: 38px; background: var(--black); border: none; border-radius: 50%; cursor: pointer; display: grid; place-items: center; flex-shrink: 0; transition: background .2s, transform .15s; align-self: flex-end; }
.ch-send-btn:hover { background: #222; transform: scale(1.06); }
.ch-send-btn:disabled { opacity: .35; cursor: not-allowed; transform: none; }

@media (max-width: 760px) {
    .ch-page { padding: 12px; gap: 0; }
    .ch-sidebar { position: absolute; top: 64px; left: 0; bottom: 0; width: 100%; z-index: 10; border-radius: 0; }
    .ch-sidebar.hidden { transform: translateX(-100%); }
    .ch-main { border-radius: 0; }
    .ch-back-btn { display: flex !important; }
}
</style>

<div class="ch-page">

    <aside class="ch-sidebar" id="chSidebar">
        <div class="ch-sidebar-header">
            <div class="ch-sidebar-title">Pesan</div>
            <div class="ch-search-wrap">
                <span class="ch-search-icon">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <circle cx="6" cy="6" r="4.5" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M9.5 9.5L12 12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </span>
                <input type="text" id="chSearch" placeholder="Cari percakapan…">
            </div>
        </div>

        <div class="ch-user-list" id="chUserList">
            @forelse($conversations as $conv)
                @php
                    $other   = $conv['user'];
                    $lastMsg = $conv['last_message'];
                    $unread  = $conv['unread_count'];
                    $convId  = $conv['conversation_id'];
                    $preview = $lastMsg ? Str::limit($lastMsg->message, 35) : 'Mulai percakapan…';
                    $timeAgo = $lastMsg ? $lastMsg->created_at->diffForHumans(null, true) : '';
                @endphp
                <div class="ch-user-item {{ $unread > 0 ? 'unread' : '' }}"
                     data-conv-id="{{ $convId }}"
                     data-user-id="{{ $other->id }}"
                     data-user-name="{{ $other->username ?? $other->name }}"
                     data-user-avatar="{{ $other->avatar_display }}">
                    <div class="ch-user-av-wrap">
                        <img src="{{ $other->avatar_display }}" alt="{{ $other->name }}" class="ch-user-av">
                    </div>
                    <div class="ch-user-info">
                        <div class="ch-user-name">{{ $other->username ?? $other->name }}</div>
                        <div class="ch-user-preview">{{ $preview }}</div>
                    </div>
                    <div class="ch-user-meta">
                        <span class="ch-user-time">{{ $timeAgo }}</span>
                        @if($unread > 0)
                            <span class="ch-unread-badge">{{ $unread }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="ch-sidebar-empty">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" style="margin:0 auto 12px;display:block">
                        <path d="M30 6H6a2 2 0 00-2 2v16a2 2 0 002 2h7l5 5 5-5h7a2 2 0 002-2V8a2 2 0 00-2-2z" stroke="#b8b3ac" stroke-width="1.8" stroke-linejoin="round"/>
                    </svg>
                    Belum ada percakapan
                </div>
            @endforelse
        </div>
    </aside>

    <main class="ch-main">
        <div class="ch-empty-state" id="chEmptyState">
            <div class="ch-empty-icon">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <path d="M25 4H5a1.5 1.5 0 00-1.5 1.5v15A1.5 1.5 0 005 22h5.5l4.5 5 4.5-5H25a1.5 1.5 0 001.5-1.5V5.5A1.5 1.5 0 0025 4z" stroke="#b8b3ac" stroke-width="1.8" stroke-linejoin="round"/>
                    <path d="M9 12h12M9 16h8" stroke="#b8b3ac" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </div>
            <h3>Pilih percakapan</h3>
            <p>Klik nama pengguna di sebelah kiri untuk mulai chat</p>
        </div>

        <div class="ch-chat-header" id="chChatHeader">
            <button class="ch-back-btn" id="chBackBtn">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <img src="" alt="" class="ch-chat-av" id="chChatAv">
            <div class="ch-chat-user">
                <div class="ch-chat-name"   id="chChatName">—</div>
                <div class="ch-chat-status" id="chChatStatus"></div>
            </div>
        </div>

        <div class="ch-messages" id="chMessages"></div>

        <div class="ch-input-area" id="chInputArea">
            <div class="ch-input-wrap">
                <textarea id="chInput" placeholder="Tulis pesan… (Enter kirim, Shift+Enter baris baru)" rows="1"></textarea>
            </div>
            <button class="ch-send-btn" id="chSendBtn" disabled>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M14 2L2 7.5l5 1.5 1.5 5L14 2z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </main>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

<script>
(function () {

    const AUTH_ID     = {{ auth()->id() }};
    const AUTH_AVATAR = '{{ auth()->user()->avatar_display }}';
    const CSRF        = '{{ csrf_token() }}';

    const route = {
        messages : (id) => `/chat/${id}/messages`,
        send     : (id) => `/chat/${id}/send`,
        read     : (id) => `/chat/${id}/read`,
    };

    let activeConvId      = null;
    let activeAvatar      = '';
    let echoChannel       = null;
    let isTyping          = false;
    let typingTimer       = null;
    let remoteTypingTimer = null;

    const sidebar     = document.getElementById('chSidebar');
    const userList    = document.getElementById('chUserList');
    const emptyState  = document.getElementById('chEmptyState');
    const chatHeader  = document.getElementById('chChatHeader');
    const chatAv      = document.getElementById('chChatAv');
    const chatName    = document.getElementById('chChatName');
    const chatStatus  = document.getElementById('chChatStatus');
    const messagesEl  = document.getElementById('chMessages');
    const inputArea   = document.getElementById('chInputArea');
    const input       = document.getElementById('chInput');
    const sendBtn     = document.getElementById('chSendBtn');
    const backBtn     = document.getElementById('chBackBtn');
    const searchInput = document.getElementById('chSearch');

    // ── Echo init ─────────────────────────────────────────────────────
    window.Echo = new Echo({
        broadcaster  : 'pusher',
        key          : '{{ config("broadcasting.connections.pusher.key") }}',
        cluster      : '{{ config("broadcasting.connections.pusher.options.cluster") }}',
        forceTLS     : true,
        authEndpoint : '/broadcasting/auth',
        auth         : {
            headers: {
                'X-CSRF-TOKEN'     : CSRF,
                'Accept'           : 'application/json',
                'X-Requested-With' : 'XMLHttpRequest',
            }
        }
    });

    // ── Open conversation ─────────────────────────────────────────────
    userList.querySelectorAll('.ch-user-item').forEach(item => {
        item.addEventListener('click', () => openConversation(item));
    });

    function openConversation(item) {
        document.querySelectorAll('.ch-user-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        item.classList.remove('unread');
        item.querySelector('.ch-unread-badge')?.remove();

        // Reset sidebar preview jika sedang menampilkan "mengetik..."
        const preview = item.querySelector('.ch-user-preview');
        if (preview.classList.contains('typing-preview')) {
            preview.classList.remove('typing-preview');
        }

        activeConvId = item.dataset.convId;
        activeAvatar = item.dataset.userAvatar;
        const name   = item.dataset.userName;

        chatAv.src           = activeAvatar;
        chatAv.alt           = name;
        chatName.textContent = name;
        chatStatus.textContent = '';
        chatStatus.className   = 'ch-chat-status';

        emptyState.style.display = 'none';
        chatHeader.classList.add('show');
        messagesEl.classList.add('show');
        inputArea.classList.add('show');

        if (window.innerWidth <= 760) sidebar.classList.add('hidden');

        loadMessages(activeConvId);
        markRead(activeConvId);
        subscribeEcho(activeConvId);
        input.focus();
    }

    // ── Load & render messages ────────────────────────────────────────
    async function loadMessages(convId) {
        messagesEl.innerHTML = '<div class="ch-load-spinner"></div>';
        try {
            const res  = await fetch(route.messages(convId), {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            });
            renderMessages(await res.json());
        } catch {
            messagesEl.innerHTML = `<div style="text-align:center;padding:40px;color:var(--muted);font-size:13.5px">Gagal memuat pesan.</div>`;
        }
    }

    function renderMessages(msgs) {
        messagesEl.innerHTML = '';
        if (!msgs.length) {
            messagesEl.innerHTML = `<div style="text-align:center;padding:60px 20px;color:var(--muted);font-size:13.5px">Belum ada pesan. Mulai percakapan!</div>`;
            return;
        }
        let lastDate = '';
        msgs.forEach((msg, i) => {
            const dateStr = new Date(msg.created_at).toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
            if (dateStr !== lastDate) {
                messagesEl.insertAdjacentHTML('beforeend', `<div class="ch-date-sep"><span>${dateStr}</span></div>`);
                lastDate = dateStr;
            }
            appendBubble(msg, msgs[i-1], msgs[i+1]);
        });
        scrollBottom();
    }

    function appendBubble(msg, prev, next) {
        const isOut      = msg.sender_id === AUTH_ID;
        const sameAsPrev = prev && prev.sender_id === msg.sender_id;
        const sameAsNext = next && next.sender_id === msg.sender_id;

        let cls = '';
        if (!sameAsPrev && sameAsNext) cls = 'first';
        if (sameAsPrev && !sameAsNext) cls = 'last';
        if (sameAsPrev && sameAsNext)  cls = 'consecutive';

        const timeStr = new Date(msg.created_at).toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

        messagesEl.insertAdjacentHTML('beforeend', `
            <div class="ch-msg-row ${isOut ? 'out' : 'in'} ${cls}" id="msg-${msg.id}">
                ${!isOut ? `<img src="${activeAvatar}" class="ch-msg-av" alt="">` : ''}
                <div class="ch-msg-content">
                    <div class="ch-bubble">${escHtml(msg.message)}</div>
                </div>
                <span class="ch-msg-time ${msg.is_read ? 'read' : ''}">${timeStr}</span>
            </div>`);
    }

    // ── Input & typing ────────────────────────────────────────────────
    input.addEventListener('input', function () {
        sendBtn.disabled = !this.value.trim();
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 96) + 'px';

        if (this.value.trim()) triggerTyping(true);
    });

    input.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); if (!sendBtn.disabled) sendMessage(); }
    });

    input.addEventListener('blur', () => triggerTyping(false));
    sendBtn.addEventListener('click', sendMessage);

    // ── Kirim client event "typing" via Pusher whisper ────────────────
    function triggerTyping(typing) {
        if (!activeConvId || !echoChannel) return;
        clearTimeout(typingTimer);

        if (typing) {
            if (!isTyping) {
                isTyping = true;
                echoChannel.whisper('typing', { user_id: AUTH_ID, typing: true });
            }
            // Auto stop setelah 2.5 detik tidak ada ketikan
            typingTimer = setTimeout(() => triggerTyping(false), 2500);
        } else {
            if (isTyping) {
                isTyping = false;
                echoChannel.whisper('typing', { user_id: AUTH_ID, typing: false });
            }
        }
    }

    // ── Tampilkan/sembunyikan typing indicator ────────────────────────
    function showTyping(show) {
        document.getElementById('chTypingIndicator')?.remove();
        clearTimeout(remoteTypingTimer);

        if (!show) {
            chatStatus.textContent = '';
            chatStatus.className   = 'ch-chat-status';
            return;
        }

        // Header status
        chatStatus.textContent = 'sedang mengetik…';
        chatStatus.className   = 'ch-chat-status typing';

        // Bubble di messages
        messagesEl.insertAdjacentHTML('beforeend', `
            <div class="ch-typing show" id="chTypingIndicator">
                <img src="${activeAvatar}" class="ch-msg-av" alt=""
                     style="width:28px;height:28px;border-radius:50%;object-fit:cover;border:1.5px solid var(--warm-gray)">
                <div class="ch-typing-bubble">
                    <div class="ch-typing-dot"></div>
                    <div class="ch-typing-dot"></div>
                    <div class="ch-typing-dot"></div>
                </div>
            </div>`);
        scrollBottom();

        // Auto-hide setelah 4 detik sebagai safety net
        remoteTypingTimer = setTimeout(() => showTyping(false), 4000);
    }

    // ── Send message ──────────────────────────────────────────────────
    async function sendMessage() {
        const text = input.value.trim();
        if (!text || !activeConvId) return;

        triggerTyping(false); // stop typing event
        input.value = '';
        input.style.height = 'auto';
        sendBtn.disabled = true;

        const tempId  = 'temp-' + Date.now();
        const timeStr = new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

        messagesEl.insertAdjacentHTML('beforeend', `
            <div class="ch-msg-row out last" id="${tempId}">
                <div class="ch-msg-content">
                    <div class="ch-bubble" style="opacity:.7">${escHtml(text)}</div>
                </div>
                <span class="ch-msg-time">${timeStr}</span>
            </div>`);
        scrollBottom();
        updateSidebarPreview(activeConvId, text);

        try {
            const res = await fetch(route.send(activeConvId), {
                method : 'POST',
                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body   : JSON.stringify({ message: text }),
            });
            const msg = await res.json();
            document.getElementById(tempId)?.remove();
            appendBubble(msg, null, null);
            scrollBottom();
        } catch {
            document.getElementById(tempId)?.remove();
            showToast('Gagal mengirim pesan. Coba lagi.');
        }
    }

    // ── Mark as read + kirim whisper "read" ke pengirim ──────────────
    function markRead(convId) {
        fetch(route.read(convId), {
            method : 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
        }).then(() => {
            // Kirim whisper ke pengirim supaya ✓ → ✓✓ real-time
            if (echoChannel) {
                echoChannel.whisper('read', { reader_id: AUTH_ID });
            }
        }).catch(() => {});
    }

    // ── Subscribe Echo ────────────────────────────────────────────────
    function subscribeEcho(convId) {
        if (echoChannel) {
            echoChannel.stopListeningForWhisper('typing');
            echoChannel.stopListeningForWhisper('read');
            window.Echo.leave(`chat.${activeConvId}`);
        }

        echoChannel = window.Echo.private(`chat.${convId}`);

        // 1. Pesan baru
        echoChannel.listen('.message.sent', (e) => {
            const msg = e.message;
            if (msg.sender_id === AUTH_ID) return;

            showTyping(false);
            updateSidebarTyping(convId, false);

            appendBubble(msg, null, null);
            scrollBottom();
            markRead(convId);
            updateSidebarPreview(convId, msg.message);
        });

        // 2. Typing indicator (whisper — tidak melalui server, gratis di Pusher)
        echoChannel.listenForWhisper('typing', (e) => {
            if (e.user_id === AUTH_ID) return;
            showTyping(e.typing);
            updateSidebarTyping(convId, e.typing);
        });

        // 3. Read receipt (whisper — ✓ → ✓✓ real-time tanpa reload)
        echoChannel.listenForWhisper('read', (e) => {
            if (e.reader_id === AUTH_ID) return;
            // Update semua bubble outgoing jadi ✓✓
            messagesEl.querySelectorAll('.ch-msg-row.out .ch-msg-time').forEach(el => {
                el.classList.add('read');
            });
        });
    }

    // ── Sidebar helpers ───────────────────────────────────────────────
    function updateSidebarPreview(convId, text) {
        const item = userList.querySelector(`[data-conv-id="${convId}"]`);
        if (!item) return;
        const preview = item.querySelector('.ch-user-preview');
        preview.classList.remove('typing-preview');
        preview.textContent = text.length > 35 ? text.slice(0, 35) + '…' : text;
        item.querySelector('.ch-user-time').textContent = 'baru saja';
    }

    function updateSidebarTyping(convId, typing) {
        const item = userList.querySelector(`[data-conv-id="${convId}"]`);
        if (!item) return;
        const preview = item.querySelector('.ch-user-preview');
        if (typing) {
            preview.classList.add('typing-preview');
            preview.textContent = 'sedang mengetik…';
        } else {
            preview.classList.remove('typing-preview');
        }
    }

    // ── Search ────────────────────────────────────────────────────────
    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        userList.querySelectorAll('.ch-user-item').forEach(item => {
            item.style.display = item.dataset.userName.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    backBtn.addEventListener('click', () => sidebar.classList.remove('hidden'));

    function scrollBottom() { messagesEl.scrollTop = messagesEl.scrollHeight; }

    function escHtml(str) {
        const el = document.createElement('div');
        el.appendChild(document.createTextNode(String(str)));
        return el.innerHTML;
    }

    function showToast(msg) {
        const t = document.createElement('div');
        t.style.cssText = 'position:fixed;bottom:80px;right:24px;z-index:9999;background:#c0392b;color:#fff;padding:12px 18px;border-radius:12px;font-size:13.5px;font-family:DM Sans,sans-serif;box-shadow:0 4px 16px rgba(0,0,0,.15)';
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 3000);
    }

    // ── Auto-open dari URL (?open=convId) ─────────────────────────────
    const openId = {{ $openConvId ?? 'null' }};
    if (openId) {
        const target = userList.querySelector(`[data-conv-id="${openId}"]`);
        if (target) openConversation(target);
    }

})();
</script>

@endsection