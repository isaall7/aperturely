

<style>
:root {
    --cb-black:  #0a0a0a;
    --cb-white:  #ffffff;
    --cb-cream:  #f9f7f4;
    --cb-warm:   #e8e4df;
    --cb-muted:  #888077;
    --cb-accent: #c8533a;
    --cb-shadow: 0 8px 32px rgba(10,10,10,0.18);
}

.cb-trigger {
    position: fixed;
    bottom: 28px; right: 28px; left: unset;
    z-index: 2000;
    width: 52px; height: 52px;
    background: var(--cb-black);
    border-radius: 50%; border: none; cursor: pointer;
    display: grid; place-items: center;
    box-shadow: var(--cb-shadow);
    transition: transform .2s, background .2s;
}
.cb-trigger:hover { background: #222; transform: scale(1.08); }

.cb-badge {
    position: absolute;
    top: -2px; right: -2px;
    min-width: 18px; height: 18px;
    background: var(--cb-accent); color: var(--cb-white);
    font-size: 10px; font-weight: 700;
    border-radius: 20px; border: 2px solid var(--cb-white);
    display: none; align-items: center; justify-content: center;
    padding: 0 4px; font-family: 'DM Sans', sans-serif;
}
.cb-badge.show { display: flex; }

.cb-panel {
    position: fixed;
    bottom: 90px; right: 28px; left: unset;
    z-index: 1999;
    width: 320px;
    background: var(--cb-white); border-radius: 20px;
    box-shadow: var(--cb-shadow); overflow: hidden;
    transform-origin: bottom right;
    transform: scale(0.88) translateY(16px);
    opacity: 0; pointer-events: none;
    transition: transform .22s cubic-bezier(.4,0,.2,1), opacity .22s;
    font-family: 'DM Sans', sans-serif;
}
.cb-panel.open { transform: scale(1) translateY(0); opacity: 1; pointer-events: all; }

.cb-header {
    padding: 15px 18px;
    border-bottom: 1px solid var(--cb-warm);
    display: flex; align-items: center; justify-content: space-between;
}
.cb-title { font-size: 15px; font-weight: 600; color: var(--cb-black); }

.cb-close {
    width: 28px; height: 28px;
    background: var(--cb-cream); border: none; border-radius: 50%;
    cursor: pointer; display: grid; place-items: center;
    color: var(--cb-muted); transition: background .2s;
}
.cb-close:hover { background: var(--cb-warm); }

.cb-list { padding: 8px; max-height: 360px; overflow-y: auto; }
.cb-list::-webkit-scrollbar { width: 4px; }
.cb-list::-webkit-scrollbar-thumb { background: var(--cb-warm); border-radius: 10px; }

.cb-item {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 11px; border-radius: 14px;
    cursor: pointer; transition: background .15s;
    text-decoration: none;
}
.cb-item:hover { background: var(--cb-cream); }

.cb-av-wrap { position: relative; flex-shrink: 0; }

.cb-av {
    width: 42px; height: 42px; border-radius: 50%;
    object-fit: cover; border: 2px solid var(--cb-warm); display: block;
}

.cb-online {
    position: absolute; bottom: 1px; right: 1px;
    width: 10px; height: 10px;
    background: #22c55e; border-radius: 50%;
    border: 2px solid var(--cb-white);
}

.cb-info { flex: 1; min-width: 0; }

.cb-name {
    font-size: 13.5px; font-weight: 600; color: var(--cb-black);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

.cb-preview {
    font-size: 12px; color: var(--cb-muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-top: 2px;
}

.cb-item.cb-unread-item .cb-preview { color: var(--cb-black); font-weight: 500; }

.cb-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
.cb-time { font-size: 10.5px; color: var(--cb-muted); }

.cb-unread {
    min-width: 18px; height: 18px;
    background: var(--cb-accent); color: var(--cb-white);
    font-size: 10px; font-weight: 700; border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 5px;
}
.d-none { display: none !important; }

.cb-empty {
    padding: 32px 20px; text-align: center;
    font-size: 13px; color: var(--cb-muted);
}

.cb-footer {
    padding: 10px 18px;
    border-top: 1px solid var(--cb-warm);
    font-size: 12px; color: var(--cb-muted);
    text-align: center; background: var(--cb-cream);
}
.cb-footer a { color: var(--cb-accent); text-decoration: none; font-weight: 600; }
.cb-footer a:hover { text-decoration: underline; }

@media (max-width: 480px) {
    .cb-panel   { width: calc(100vw - 32px); right: 16px; left: unset; }
    .cb-trigger { right: 16px; left: unset; bottom: 20px; }
}
</style>

@auth
<button class="cb-trigger" id="cbTrigger" title="Pesan">
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
        <path d="M19 3H3a1 1 0 00-1 1v11a1 1 0 001 1h4l4 4 4-4h4a1 1 0 001-1V4a1 1 0 00-1-1z"
              stroke="white" stroke-width="1.7" stroke-linejoin="round"/>
        <path d="M7 9h8M7 13h5" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
    </svg>
    @if(isset($bubbleTotalUnread) && $bubbleTotalUnread > 0)
        <span class="cb-badge show" id="cbBadge">{{ $bubbleTotalUnread > 99 ? '99+' : $bubbleTotalUnread }}</span>
    @else
        <span class="cb-badge" id="cbBadge"></span>
    @endif
</button>

<div class="cb-panel" id="cbPanel">
    <div class="cb-header">
        <span class="cb-title">Pesan</span>
        <button class="cb-close" id="cbClose">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M1 1l10 10M11 1L1 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
            </svg>
        </button>
    </div>

    <div class="cb-list">
        @if(isset($bubbleConversations) && $bubbleConversations->count() > 0)
            @foreach($bubbleConversations as $conv)
                @php
                    $other   = $conv['user'];
                    $lastMsg = $conv['last_message'];
                    $unread  = $conv['unread_count'];
                    $convId  = $conv['conversation_id'];
                    $preview = $lastMsg
                        ? Str::limit($lastMsg->message, 38)
                        : 'Mulai percakapan…';
                    $timeAgo = $lastMsg
                        ? $lastMsg->created_at->diffForHumans(null, true)
                        : '';
                @endphp
                <a href="{{ route('user.chat.index', ['open' => $convId]) }}"
                   class="cb-item {{ $unread > 0 ? 'cb-unread-item' : '' }}"
                   data-chat-id="{{ $convId }}"
                   data-other-user-id="{{ $other->id }}"
                   data-initial-unread="{{ $unread }}">
                    <div class="cb-av-wrap">
                        <img src="{{ $other->avatar_display ?? 'https://ui-avatars.com/api/?name='.urlencode($other->name) }}"
                             alt="{{ $other->name }}"
                             class="cb-av">
                    </div>
                    <div class="cb-info">
                        <div class="cb-name">{{ $other->username ?? $other->name }}</div>
                        <div class="cb-preview" id="cbPreview{{ $convId }}">{{ $preview }}</div>
                    </div>
                    <div class="cb-meta">
                        <span class="cb-time" id="cbTime{{ $convId }}">{{ $timeAgo }}</span>
                        <span class="cb-unread {{ $unread > 0 ? '' : 'd-none' }}" id="cbUnread{{ $convId }}">{{ $unread > 99 ? '99+' : $unread }}</span>
                    </div>
                </a>
            @endforeach
        @else
            <div class="cb-empty">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" style="margin:0 auto 10px;display:block">
                    <path d="M26 4H6a2 2 0 00-2 2v14a2 2 0 002 2h6l4 4 4-4h6a2 2 0 002-2V6a2 2 0 00-2-2z"
                          stroke="#b8b3ac" stroke-width="1.6" stroke-linejoin="round"/>
                </svg>
                Belum ada percakapan
            </div>
        @endif
    </div>

    <div class="cb-footer">
        <a href="{{ route('user.chat.index') }}">Lihat semua pesan →</a>
    </div>
</div>
@endauth

<script type="module">
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js';
import {
    getAuth,
    signInWithCustomToken,
} from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-auth.js';
import {
    collection,
    getFirestore,
    limit,
    onSnapshot,
    orderBy,
    query,
} from 'https://www.gstatic.com/firebasejs/10.12.5/firebase-firestore.js';

(function () {
    const trigger = document.getElementById('cbTrigger');
    const panel   = document.getElementById('cbPanel');
    const close   = document.getElementById('cbClose');
    if (!trigger) return;

    let open = false;

    trigger.addEventListener('click', () => {
        open = !open;
        panel.classList.toggle('open', open);
    });

    close.addEventListener('click', () => {
        open = false;
        panel.classList.remove('open');
    });

    document.addEventListener('click', e => {
        if (open && !panel.contains(e.target) && !trigger.contains(e.target)) {
            open = false;
            panel.classList.remove('open');
        }
    });

    const firebaseConfig = {
        apiKey: 'AIzaSyCUAAmjfFRw3o0t2Ifwj8zarmBTBNj_c1Y',
        authDomain: 'aperture-62cbb.firebaseapp.com',
        projectId: 'aperture-62cbb',
        storageBucket: 'aperture-62cbb.firebasestorage.app',
        messagingSenderId: '795719998676',
        appId: '1:795719998676:web:d668473fc5bdc1ae0b2f41',
        measurementId: 'G-9GD9M5VPYR'
    };

    const authId = {{ auth()->id() }};
    const csrfToken = @json(csrf_token());
    const badgeEl = document.getElementById('cbBadge');
    const bubbleItems = Array.from(document.querySelectorAll('.cb-item[data-chat-id]'));
    const unreadState = new Map();
    const firebaseApp = initializeApp(firebaseConfig, 'chat-bubble');
    const firebaseAuth = getAuth(firebaseApp);
    const db = getFirestore(firebaseApp);

    const buildChatKey = (a, b) => {
        const pair = [Number(a), Number(b)].sort((x, y) => x - y);
        return `chat_${pair[0]}_${pair[1]}`;
    };

    const normalizeDate = value => {
        if (value?.toDate) return value.toDate();
        if (value instanceof Date) return value;
        return value ? new Date(value) : null;
    };

    const formatTimeAgo = date => {
        if (!date) return '';

        const seconds = Math.max(1, Math.floor((Date.now() - date.getTime()) / 1000));
        if (seconds < 60) return 'baru saja';
        if (seconds < 3600) return `${Math.floor(seconds / 60)}m`;
        if (seconds < 86400) return `${Math.floor(seconds / 3600)}j`;
        if (seconds < 604800) return `${Math.floor(seconds / 86400)}h`;

        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
        });
    };

    const getSeenStorageKey = chatId => `chat:last-seen:${authId}:${chatId}`;

    const setUnread = (chatId, isUnread) => {
        unreadState.set(String(chatId), Boolean(isUnread));

        const unreadEl = document.getElementById(`cbUnread${chatId}`);
        const itemEl = document.querySelector(`.cb-item[data-chat-id="${chatId}"]`);

        if (unreadEl) {
            unreadEl.textContent = isUnread ? '1' : '0';
            unreadEl.classList.toggle('d-none', !isUnread);
        }

        itemEl?.classList.toggle('cb-unread-item', Boolean(isUnread));

        const totalUnread = Array.from(unreadState.values()).filter(Boolean).length;
        if (badgeEl) {
            badgeEl.textContent = totalUnread > 99 ? '99+' : String(totalUnread);
            badgeEl.classList.toggle('show', totalUnread > 0);
        }
    };

    const fetchCustomToken = async () => {
        const response = await fetch('{{ route('user.firebase.custom-token') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({}),
        });

        if (!response.ok) {
            const payload = await response.json().catch(() => ({}));
            throw new Error(payload.message || 'Gagal membuat custom token.');
        }

        return response.json();
    };

    const moveItemToTop = item => {
        const list = item?.parentElement;
        if (!list || !item || list.firstElementChild === item) return;
        list.prepend(item);
    };

    bubbleItems.forEach(item => {
        const chatId = item.dataset.chatId;
        const initialUnread = Number(item.dataset.initialUnread || 0) > 0;
        unreadState.set(String(chatId), initialUnread);

        item.addEventListener('click', () => {
            localStorage.setItem(getSeenStorageKey(chatId), String(Date.now()));
            setUnread(chatId, false);
        });
    });

    const hydrateBubbleRealtime = async () => {
        const tokenPayload = await fetchCustomToken();
        await signInWithCustomToken(firebaseAuth, tokenPayload.token);

        bubbleItems.forEach(item => {
            const chatId = item.dataset.chatId;
            const otherUserId = item.dataset.otherUserId;
            const previewEl = document.getElementById(`cbPreview${chatId}`);
            const timeEl = document.getElementById(`cbTime${chatId}`);
            const chatKey = buildChatKey(authId, otherUserId);
            const lastSeenKey = getSeenStorageKey(chatId);
            const messageQuery = query(
                collection(db, `chats/${chatKey}/messages`),
                orderBy('created_at', 'desc'),
                limit(1)
            );

            onSnapshot(messageQuery, snapshot => {
                const lastMessage = snapshot.docs[0]?.data({ serverTimestamps: 'estimate' });
                if (!lastMessage) return;

                const messageDate = normalizeDate(lastMessage.created_at);
                if (previewEl) {
                    previewEl.textContent = (lastMessage.text || 'Mulai percakapan...').slice(0, 38);
                }
                if (timeEl && messageDate) {
                    timeEl.textContent = formatTimeAgo(messageDate);
                }

                const seenAt = Number(localStorage.getItem(lastSeenKey) || 0);
                const messageTime = messageDate ? messageDate.getTime() : Date.now();
                const isIncomingUnread =
                    String(lastMessage.sender_id) !== String(authId) &&
                    messageTime > seenAt;

                setUnread(chatId, isIncomingUnread);
                moveItemToTop(item);
            }, error => {
                console.error('Bubble realtime error', error);
            });
        });
    };

    hydrateBubbleRealtime().catch(error => {
        console.error('Bubble init error', error);
    });
})();
</script>
