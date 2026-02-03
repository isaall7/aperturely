{{-- resources/views/user/partials/post-modal.blade.php --}}
<div class="modal fade detail-modal" id="detailModal{{ $post->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-container">
                    <!-- Image Section -->
                    <div class="modal-image-section">
                        @if($post->photos && $post->photos->count() > 1)
                            <div id="modalCarousel{{ $post->id }}" class="carousel slide modal-carousel" data-bs-ride="false">
                                <div class="carousel-inner">
                                    @foreach($post->photos as $index => $photo)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $photo->photo) }}" alt="Post {{ $index + 1 }}">
                                        </div>
                                    @endforeach
                                </div>
                                @if($post->photos->count() > 1)
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
                                @endif
                            </div>
                        @elseif($post->photos && $post->photos->first())
                            <img src="{{ asset('storage/' . $post->photos->first()->photo) }}" alt="Post">
                        @else
                            <img src="https://via.placeholder.com/600x600?text=No+Image" alt="No Image">
                        @endif
                    </div>
                    
                    <!-- Details Section -->
                    <div class="modal-details-section">
                        <!-- Header with Like, Close, More -->
                        <div class="modal-header-custom">
                            <div class="modal-header-actions">
                                <button type="button" 
                                        class="modal-action-btn" 
                                        data-post-id="{{ $post->id }}" 
                                        data-liked="{{ $post->isLikedBy(auth()->id()) ? '1' : '0' }}">
                                    {{ $post->isLikedBy(auth()->id()) ? '❤️' : '🤍' }}
                                </button>
                                <button class="modal-action-btn">📤</button>
                                <button class="modal-action-btn" type="button" data-bs-dismiss="modal">✖️</button>
                                <div class="dropdown">
                                    <button class="modal-action-btn" type="button" data-bs-toggle="dropdown">
                                        ⋯
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @auth
                                            @if(auth()->id() === $post->user_id)
                                                <li><a class="dropdown-item" href="#">✏️ Edit</a></li>
                                                <form action="{{ route('user.postingan.destroy', $post) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <li><button class="dropdown-item text-danger" onclick="return confirm('Yakin ingin hapus postingan ini?')">🗑️ Hapus</button></li>
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
                            </div>
                            <button class="modal-save-btn">Simpan</button>
                        </div>
                        
                        <!-- User Section -->
                        <div class="modal-user-section">
                            <div class="modal-user-info">
                                <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}">
                                    <img src="{{ $post->user->avatar_display }}" alt="Avatar" class="modal-user-avatar">
                                </a>
                                <div class="modal-user-details">
                                    <h6 class="username text-dark">
                                        <a href="{{ route('user.profile.username', ['name' => $post->user->name]) }}" class="text-dark text-decoration-none">
                                            {{ $post->user->username ?? $post->user->name }}
                                        </a>
                                    </h6>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            @if($post->caption)
                                <div class="modal-caption">{{ $post->caption }}</div>
                            @endif
                            
                            <div class="modal-stats">
                                <span class="like-count" data-post-id="{{ $post->id }}">❤️ {{ $post->likes->count() ?? 0 }} likes</span>
                                <span>💬 {{ $post->comments->count() ?? 0 }} comments</span>
                            </div>
                        </div>
                        
                        <!-- Comments Section -->
                        <div class="modal-comments-section" id="comments-container-{{ $post->id }}">
                            @forelse($post->comments->where('reply_id', null) as $comment)
                            <div class="comment-wrapper" id="comment-wrapper-{{ $comment->id }}">
                                <div class="comment-item" id="comment-{{ $comment->id }}">
                                    <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="comment-avatar-link">
                                        <img src="{{ $comment->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                            alt="{{ $comment->user->name ?? 'User' }}" 
                                            class="comment-avatar">
                                    </a>
                                    <div class="comment-content">
                                        <div>
                                            <a href="{{ route('user.profile.username', ['name' => $comment->user->username ?? $comment->user->name]) }}" class="comment-username-link">
                                                <span class="comment-username">{{ $comment->user->username ?? $comment->user->name }}</span>
                                            </a><br>
                                            <span class="comment-text">{{ $comment->comment }}</span>
                                        </div>
                                        <div class="comment-actions">
                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                            
                                            @auth
                                                <button type="button" 
                                                        class="reply-btn" 
                                                        data-id="{{ $comment->id }}"
                                                        data-username="{{ $comment->user->username ?? $comment->user->name }}">
                                                    Reply
                                                </button>
                                                
                                                @if(auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                                    <button type="button" 
                                                            class="delete-comment-btn" 
                                                            data-id="{{ $comment->id }}"
                                                            data-url="{{ route('user.comments.destroy', $comment->id) }}">
                                                        Hapus
                                                    </button>
                                                @endif
                                                
                                                @if(auth()->id() !== $comment->user_id)
                                                    <button data-bs-toggle="modal" 
                                                            data-bs-target="#reportCommentModal{{ $comment->id }}">
                                                        Report
                                                    </button>
                                                @endif
                                            @else
                                                <button data-bs-toggle="modal" 
                                                        data-bs-target="#reportCommentModal{{ $comment->id }}">
                                                    Report
                                                </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                                {{-- Nested replies --}}
                                @if($comment->replies->count() > 0)
                                    <div class="replies-container">
                                        @foreach($comment->replies as $reply)
                                            <div class="comment-item reply-item" id="comment-{{ $reply->id }}" style="margin-bottom: 12px;">
                                                <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}" class="comment-avatar-link">
                                                    <img src="{{ $reply->user->avatar_display ?? 'https://ui-avatars.com/api/?name=User' }}" 
                                                        alt="{{ $reply->user->name ?? 'User' }}" 
                                                        class="comment-avatar">
                                                </a>
                                                <div class="comment-content">
                                                    <div>
                                                        <a href="{{ route('user.profile.username', ['name' => $reply->user->username ?? $reply->user->name]) }}" class="comment-username-link">
                                                            <span class="comment-username">{{ $reply->user->username ?? $reply->user->name }}</span>
                                                        </a><br>
                                                        <span class="comment-text">{{ $reply->comment }}</span>
                                                    </div>
                                                    <div class="comment-actions">
                                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                        
                                                        @auth
                                                            <button type="button" 
                                                                    class="reply-btn" 
                                                                    data-id="{{ $reply->id }}"
                                                                    data-username="{{ $reply->user->username ?? $reply->user->name }}">
                                                                Reply
                                                            </button>
                                                            
                                                            @if(auth()->id() === $reply->user_id || auth()->user()->role === 'admin')
                                                                <button type="button" 
                                                                        class="delete-comment-btn" 
                                                                        data-id="{{ $reply->id }}"
                                                                        data-url="{{ route('user.comments.destroy', $reply->id) }}">
                                                                    Hapus
                                                                </button>
                                                            @endif
                                                            
                                                            @if(auth()->id() !== $reply->user_id)
                                                                <button data-bs-toggle="modal" 
                                                                        data-bs-target="#reportCommentModal{{ $reply->id }}">
                                                                    Report
                                                                </button>
                                                            @endif
                                                        @else
                                                            <button data-bs-toggle="modal" 
                                                                    data-bs-target="#reportCommentModal{{ $reply->id }}">
                                                                Report
                                                            </button>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @empty
                                <p class="text-center text-muted no-comments-msg" id="no-comments-{{ $post->id }}">Belum ada komentar</p>
                            @endforelse
                        </div>

                        {{-- Comment Form --}}
                        @auth
                        <form class="comment-form-ajax" data-post-id="{{ $post->id }}">
                            @csrf
                            <div class="modal-comment-input-section">
                                <div class="modal-comment-input">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="hidden" name="reply_id" class="reply-id-input" value="">
                                    <input type="text" name="comment" class="comment-input" placeholder="Tambah Komentar..." required>
                                    <button type="submit">Kirim</button>
                                </div>
                                <div class="reply-info">
                                    <small>Membalas: <span class="reply-to-username"></span></small>
                                    <button type="button" class="cancel-reply">✕ Batal</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <p class="text-center text-muted" style="padding: 15px;">Silakan login untuk berkomentar</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Post Modal -->
<div class="modal fade report-modal" id="reportPostModal{{ $post->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🚩 Laporkan Postingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.report.post', $post->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Laporan <span class="text-danger">*</span></label>
                        <select class="form-select" name="reason" required>
                            <option value="">Pilih alasan...</option>
                            <option value="spam">Spam</option>
                            <option value="bullying">Bullying atau Pelecehan</option>
                            <option value="hate_speech">Ujaran Kebencian (SARA)</option>
                            <option value="pornography">Konten Pornografi</option>
                            <option value="violence">Kekerasan</option>
                            <option value="scam">Penipuan</option>
                            <option value="copyright">Pelanggaran Hak Cipta</option>
                            <option value="misinformation">Informasi Menyesatkan</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Keterangan Tambahan (Opsional)</label>
                        <textarea class="form-control" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Jelaskan lebih detail mengapa Anda melaporkan postingan ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit-report">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($post->comments as $comment)
    <!-- Report Comment Modal -->
    <div class="modal fade report-modal" id="reportCommentModal{{ $comment->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">🚩 Laporkan Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.report.comment', $comment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Alasan Laporan <span class="text-danger">*</span></label>
                            <select class="form-select" name="reason" required>
                                <option value="">Pilih alasan...</option>
                                <option value="spam">Spam</option>
                                <option value="bullying">Bullying atau Pelecehan</option>
                                <option value="hate_speech">Ujaran Kebencian (SARA)</option>
                                <option value="pornography">Konten Pornografi</option>
                                <option value="violence">Kekerasan</option>
                                <option value="scam">Penipuan</option>
                                <option value="copyright">Pelanggaran Hak Cipta</option>
                                <option value="misinformation">Informasi Menyesatkan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Keterangan Tambahan (Opsional)</label>
                            <textarea class="form-control" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Jelaskan lebih detail mengapa Anda melaporkan komentar ini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-submit-report">Kirim Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach