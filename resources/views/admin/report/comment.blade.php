@extends('layouts.index')

@section('content')
<style>
    .report-page {
        padding: 1.5rem 0 2.5rem;
        background: linear-gradient(180deg, #f8fafc 0%, #eff4f9 100%);
        min-height: calc(100vh - 80px);
    }

    .report-shell {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.25rem;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .report-header h1 {
        margin-bottom: 0.3rem;
        font-size: 1.85rem;
        font-weight: 700;
        color: #0f172a;
    }

    .report-header p {
        margin: 0;
        color: #64748b;
    }

    .report-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .report-stat-card,
    .report-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.06);
    }

    .report-stat-card {
        padding: 1.2rem 1.35rem;
    }

    .report-stat-card strong {
        display: block;
        font-size: 1.8rem;
        line-height: 1;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }

    .report-stat-card span {
        color: #64748b;
        font-size: 0.93rem;
    }

    .report-card form {
        padding: 1.4rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .search-input {
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 0.85rem 1rem;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }

    .table-wrap {
        overflow-x: auto;
        padding: 0 1.5rem 1.5rem;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th {
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .report-table td {
        padding: 1rem 0;
        border-bottom: 1px solid #eef2f7;
        vertical-align: top;
        color: #334155;
    }

    .report-table tr:last-child td {
        border-bottom: none;
    }

    .user-cell {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .user-cell img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-cell strong {
        display: block;
        color: #0f172a;
    }

    .user-cell span,
    .muted-text {
        color: #64748b;
        font-size: 0.88rem;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .pill.reason {
        background: #fef3c7;
        color: #92400e;
    }

    .pill.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .pill.reviewed,
    .pill.active {
        background: #dcfce7;
        color: #166534;
    }

    .pill.banned {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action-row {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .empty-state {
        padding: 2rem 1.5rem 2.2rem;
        text-align: center;
        color: #64748b;
    }

    @media (max-width: 992px) {
        .report-stats {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .report-page {
            padding-top: 0.75rem;
        }

        .report-shell {
            padding: 0 0.9rem;
        }

        .report-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .report-card form,
        .table-wrap {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>

<div class="report-page">
    <div class="report-shell">
        <div class="report-header">
            <div>
                <h1>Laporan Komentar</h1>
                <p>Daftar laporan dari user untuk komentar yang perlu dimoderasi.</p>
            </div>
        </div>

        <div class="report-stats">
            <div class="report-stat-card">
                <strong>{{ number_format($reports->count()) }}</strong>
                <span>Total laporan komentar yang sedang ditampilkan.</span>
            </div>
            <div class="report-stat-card">
                <strong>{{ number_format($reports->where('status', 'pending')->count()) }}</strong>
                <span>Laporan masih berstatus pending.</span>
            </div>
            <div class="report-stat-card">
                <strong>{{ number_format($reports->filter(fn ($report) => optional($report->comment)->status === 'banned')->count()) }}</strong>
                <span>Komentar pada daftar ini yang sudah dibanned.</span>
            </div>
        </div>

        <div class="report-card">
            <form action="{{ route('admin.report.comment') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control search-input" placeholder="Cari pelapor, terlapor, alasan, atau deskripsi..." value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">Cari Laporan</button>
                    </div>
                </div>
            </form>

            <div class="table-wrap">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>Terlapor</th>
                            <th>Komentar</th>
                            <th>status</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <img src="{{ $report->reporter?->avatar_display ?? 'https://ui-avatars.com/api/?name=' . urlencode($report->reporter?->name ?? 'User') }}" alt="{{ $report->reporter?->name }}">
                                        <div>
                                            <strong>{{ $report->reporter?->name ?? 'User tidak ditemukan' }}</strong>
                                            <span>{{ $report->reporter?->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <img src="{{ $report->reportedUser?->avatar_display ?? 'https://ui-avatars.com/api/?name=' . urlencode($report->reportedUser?->name ?? 'User') }}" alt="{{ $report->reportedUser?->name }}">
                                        <div>
                                            <strong>{{ $report->reportedUser?->name ?? 'User tidak ditemukan' }}</strong>
                                            <span>{{ $report->reportedUser?->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($report->comment)
                                        <strong>{{ \Illuminate\Support\Str::limit($report->comment->comment, 80) }}</strong>
                                    @else
                                        <span class="muted-text">Komentar sudah dihapus.</span>
                                    @endif
                                </td>
                                <td>
                                    @if($report->comment)
                                        <div class="muted-text mt-1">
                                            <span class="pill {{ $report->comment->status }}">{{ ucfirst($report->comment->status) }}</span>
                                        </div>
                                    @else
                                        <span class="muted-text">Komentar sudah dihapus.</span>
                                    @endif
                                </td>
                                <td><span class="pill reason">{{ $report->reason_label }}</span></td>
                                <td><span class="pill {{ $report->status }}">{{ ucfirst($report->status) }}</span></td>
                                <td>{{ $report->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="action-row">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $report->id }}">Detail</button>
                                        @if($report->comment && $report->comment->status !== 'banned')
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#banModal{{ $report->id }}">Ban</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="detailModal{{ $report->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title">Detail Laporan #{{ $report->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body pt-2">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <h6>Pelapor</h6>
                                                    <p class="mb-0">{{ $report->reporter?->name }}<br><span class="muted-text">{{ $report->reporter?->email }}</span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Terlapor</h6>
                                                    <p class="mb-0">{{ $report->reportedUser?->name }}<br><span class="muted-text">{{ $report->reportedUser?->email }}</span></p>
                                                </div>
                                                <div class="col-12">
                                                    <h6>Alasan</h6>
                                                    <p class="mb-0">{{ $report->reason_label }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <h6>Deskripsi</h6>
                                                    <p class="mb-0">{{ $report->description ?: 'Tidak ada deskripsi tambahan.' }}</p>
                                                </div>
                                                @if($report->comment)
                                                    <div class="col-12">
                                                        <h6>Isi Komentar</h6>
                                                        <div class="p-3 rounded-4 bg-light">{{ $report->comment->comment }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($report->comment && $report->comment->status !== 'banned')
                                <div class="modal fade" id="banModal{{ $report->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4">
                                            <form action="{{ route('admin.post.bancomment', $report->comment->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title text-danger">Ban Komentar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <p class="text-muted">Komentar dari <strong>{{ $report->reportedUser?->name }}</strong> akan diblokir dari sistem.</p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan ban</label>
                                                        <input type="text" name="reason" class="form-control" required value="{{ $report->reason_label }}">
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label">Catatan admin</label>
                                                        <textarea name="notes" class="form-control" rows="3">{{ $report->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ban Sekarang</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">Belum ada laporan komentar yang cocok dengan filter saat ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
