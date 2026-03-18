{{-- resources/views/user/partials/post-modal.blade.php --}}

{{-- ===== DETAIL MODAL ===== --}}
<div class="modal fade ap-detail-modal" id="detailModal{{ $post->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                {{-- Media --}}
                <div class="ap-modal-media">
                    @if($post->photos && $post->photos->count() > 1)
                        <div id="modalCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner">
                                @foreach($post->photos as $index => $photo)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" alt="Post {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel{{ $post->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel{{ $post->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            <div class="carousel-indicators">
                                @foreach($post->photos as $index => $photo)
                                    <button type="button"
                                            data-bs-target="#modalCarousel{{ $post->id }}"
                                            data-bs-slide-to="{{ $index }}"
                                            class="{{ $index == 0 ? 'active' : '' }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @elseif($post->photos && $post->photos->first())
                        <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post">
                    @else
                        <img src="https://via.placeholder.com/600x600/1a1a1a/444?text=No+Image" alt="No Image">
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="ap-modal-sidebar">

                    {{-- Header --}}
                    <div class="ap-modal-header">
                        <div class="ap-modal-header-left">
                            <button type="button"
                                    class="ap-modal-action like-modal-btn"
                                    data-post-id="{{ $post->id }}"
                                    data-liked="{{ $post->isLikedBy(auth()->id()) ? '1' : '0' }}"
                                    title="Suka">
                                @if($post->isLikedBy(auth()->id()))
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="#c8533a"><path d="M9 15.5S2 11.5 2 6.5A4.5 4.5 0 019 3.2 4.5 4.5 0 0116 6.5C16 11.5 9 15.5 9 15.5z"/></svg>
                                @else
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 15.5S2 11.5 2 6.5A4.5 4.5 0 019 3.2 4.5 4.5 0 0116 6.5C16 11.5 9 15.5 9 15.5z" stroke="#888" stroke-width="1.6"/></svg>
                                @endif
                            </button>

                            <div class="dropdown">
                                <button class="ap-modal-action" type="button" data-bs-toggle="dropdown">
                                    <svg width="16" height="4" viewBox="0 0 16 4" fill="#888">
                                        <circle cx="2" cy="2" r="1.5"/><circle cx="8" cy="2" r="1.5"/><circle cx="14" cy="2" r="1.5"/>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @auth
                                        @if(auth()->id() === $post->user_id)
                                            <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                            <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <li><button class="dropdown-item text-danger" onclick="return confirm('Hapus postingan ini?')">🗑️ Hapus</button></li>
                                            </form>
                                        @else
                                            <li>
                                                <a class="dropdown-item text-danger" href="#"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#reportPostModal{{ $post->id }}">
                                                    🚩 Laporkan
                                                </a>
                                            </li>
                                        @endif
                                    @else
                                        <li>
                                            <a class="dropdown-item text-danger" href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#reportPostModal{{ $post->id }}">
                                                🚩 Laporkan
                                            </a>
                                        </li>
                                    @endauth
                                </ul>
                            </div>

                            <button class="ap-modal-action" data-bs-dismiss="modal" title="Tutup">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <path d="M1 1l11 11M12 1L1 12" stroke="#888" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                        <button class="ap-modal-save">Simpan</button>
                    </div>

                    {{-- Author --}}
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
                            <span class="ap-modal-stat like-count" data-post-id="{{ $post->id }}">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M7 12S1.5 9 1.5 5A3.5 3.5 0 017 2.2 3.5 3.5 0 0112.5 5C12.5 9 7 12 7 12z" stroke="#c8533a" stroke-width="1.5"/>
                                </svg>
                                {{ $post->likes->count() }} suka
                            </span>
                            <span class="ap-modal-stat">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M11.5 1.5H2.5a.5.5 0 00-.5.5v6a.5.5 0 00.5.5H4l3 3 3-3h1.5a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="#888" stroke-width="1.4"/>
                                </svg>
                                {{ $post->comments->count() }} komentar
                            </span>
                        </div>
                    </div>

                    {{-- Comments --}}
                    <div class="ap-modal-comments" id="comments-container-{{ $post->id }}">
                        @forelse($post->comments->where('reply_id', null) as $comment)
                            <div class="comment-wrapper" id="comment-wrapper-{{ $comment->id }}">
                                <div class="ap-comment" id="comment-{{ $comment->id }}">
                                    <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}">
                                        <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                                             alt="{{ $comment->user->name ?? 'User' }}"
                                             class="ap-comment-avatar">
                                    </a>
                                    <div class="ap-comment-body">
                                        <div>
                                            <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="ap-comment-author">{{ $comment->user->username ?? $comment->user->name }}</a>
                                            <span class="ap-comment-text">{{ $comment->comment }}</span>
                                        </div>
                                        <div class="ap-comment-meta">
                                            <span class="ap-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                            @auth
                                                <button class="ap-comment-action-btn reply-btn"
                                                        data-id="{{ $comment->id }}"
                                                        data-username="{{ $comment->user->username ?? $comment->user->name }}">Balas</button>
                                                @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                                    <button class="ap-comment-action-btn danger delete-comment-btn"
                                                            data-id="{{ $comment->id }}"
                                                            data-url="{{ route('user.comments.destroy', $comment->id) }}">Hapus</button>
                                                @endif
                                                @if(auth()->id() !== $comment->user_id)
                                                    <button class="ap-comment-action-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                                                @endif
                                            @else
                                                <button class="ap-comment-action-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reportCommentModal{{ $comment->id }}">Laporkan</button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                                @if($comment->replies->count() > 0)
                                    <div class="ap-replies-nest">
                                        @foreach($comment->replies as $reply)
                                            <div class="ap-comment" id="comment-{{ $reply->id }}" style="margin-bottom:10px;">
                                                <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}">
                                                    <img src="{{ $reply->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}"
                                                         alt="{{ $reply->user->name ?? 'User' }}"
                                                         class="ap-comment-avatar">
                                                </a>
                                                <div class="ap-comment-body">
                                                    <div>
                                                        <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}" class="ap-comment-author">{{ $reply->user->username ?? $reply->user->name }}</a>
                                                        <span class="ap-comment-text">{{ $reply->comment }}</span>
                                                    </div>
                                                    <div class="ap-comment-meta">
                                                        <span class="ap-comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                                        @auth
                                                            <button class="ap-comment-action-btn reply-btn"
                                                                    data-id="{{ $reply->id }}"
                                                                    data-username="{{ $reply->user->username ?? $reply->user->name }}">Balas</button>
                                                            @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
                                                                <button class="ap-comment-action-btn danger delete-comment-btn"
                                                                        data-id="{{ $reply->id }}"
                                                                        data-url="{{ route('user.comments.destroy', $reply->id) }}">Hapus</button>
                                                            @endif
                                                            @if(auth()->id() !== $reply->user_id)
                                                                <button class="ap-comment-action-btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#reportCommentModal{{ $reply->id }}">Laporkan</button>
                                                            @endif
                                                        @else
                                                            <button class="ap-comment-action-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#reportCommentModal{{ $reply->id }}">Laporkan</button>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-center" style="color:var(--muted,#888077);font-size:13.5px;padding:28px 0;" id="no-comments-{{ $post->id }}">Belum ada komentar.</p>
                        @endforelse
                    </div>

                    {{-- Comment form --}}
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
                                <input type="text" name="comment" class="comment-input" placeholder="Tulis komentar…" required autocomplete="off">
                                <button type="submit" class="ap-comment-submit" disabled>Kirim</button>
                            </div>
                        </form>
                    </div>
                    @else
                    <div style="padding:14px 20px;text-align:center;border-top:1px solid var(--warm-gray,#e8e4df);">
                        <a href="{{ route('login') }}" style="font-size:13.5px;color:var(--accent,#c8533a);font-weight:600;">Masuk untuk berkomentar</a>
                    </div>
                    @endauth

                </div>{{-- end sidebar --}}
            </div>
        </div>
    </div>
</div>

{{-- ===== REPORT POST MODAL ===== --}}
<div class="modal fade ap-report-modal" id="reportPostModal{{ $post->id }}" tabindex="-1">
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
                        <label class="form-label">Alasan <span style="color:var(--accent,#c8533a)">*</span></label>
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
                        <label class="form-label">Keterangan <span style="color:var(--muted,#888077);font-weight:400">(opsional)</span></label>
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

{{-- ===== REPORT COMMENT MODALS ===== --}}
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
                            <label class="form-label">Alasan <span style="color:var(--accent,#c8533a)">*</span></label>
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
                            <label class="form-label">Keterangan <span style="color:var(--muted,#888077);font-weight:400">(opsional)</span></label>
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