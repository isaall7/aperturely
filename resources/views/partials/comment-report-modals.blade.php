@foreach($comments as $comment)
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
                            <label class="form-label">Alasan <span style="color:var(--accent)">*</span></label>
                            <select class="form-select" name="reason" required>
                                <option value="">Pilih alasan...</option>
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
                            <label class="form-label">Keterangan <span style="color:var(--muted);font-weight:400">(opsional)</span></label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Jelaskan lebih lanjut..."></textarea>
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

    @if($comment->replies && $comment->replies->count())
        @include('partials.comment-report-modals', ['comments' => $comment->replies])
    @endif
@endforeach
