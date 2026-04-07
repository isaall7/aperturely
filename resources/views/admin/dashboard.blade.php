@extends('layouts.index')

@section('content')
<style>
    .admin-dashboard {
        background:
            radial-gradient(circle at top left, rgba(15, 118, 110, 0.12), transparent 28%),
            linear-gradient(180deg, #f4f7fb 0%, #eef3f8 100%);
        min-height: calc(100vh - 80px);
        padding: 1.5rem 0 2.5rem;
    }

    .dashboard-shell {
        max-width: 1380px;
        margin: 0 auto;
        padding: 0 1.25rem;
    }

    .dashboard-hero {
        background: linear-gradient(135deg, #0f766e 0%, #155e75 55%, #1d4ed8 100%);
        border-radius: 28px;
        padding: 2rem;
        color: #fff;
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(280px, 1fr);
        gap: 1.5rem;
        box-shadow: 0 28px 60px rgba(15, 23, 42, 0.16);
        margin-bottom: 1.5rem;
    }

    .dashboard-hero h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: #fff;
    }

    .dashboard-hero p {
        margin-bottom: 1rem;
        max-width: 620px;
        color: rgba(255, 255, 255, 0.88);
    }

    .hero-badge,
    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.55rem 0.9rem;
        border-radius: 999px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .hero-badge {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.18);
        margin-bottom: 1rem;
    }

    .hero-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .hero-chip {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    .hero-summary {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 24px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .hero-summary-title {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.78);
        margin-bottom: 1rem;
    }

    .hero-summary-grid {
        display: grid;
        gap: 1rem;
    }

    .hero-summary-item strong {
        display: block;
        font-size: 1.75rem;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .hero-summary-item span {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.92rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: #fff;
        border-radius: 22px;
        padding: 1.35rem;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.06);
    }

    .stat-card small {
        display: block;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .stat-card strong {
        display: block;
        font-size: 2rem;
        line-height: 1;
        color: #0f172a;
        margin-bottom: 0.45rem;
    }

    .stat-card p {
        margin: 0;
        color: #475569;
        font-size: 0.95rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(320px, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .dashboard-card-header {
        padding: 1.35rem 1.5rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .dashboard-card-header h2,
    .dashboard-card-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        color: #0f172a;
    }

    .dashboard-card-header p {
        margin: 0;
        color: #64748b;
        font-size: 0.92rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.9rem;
        padding: 0 1.5rem 1.5rem;
    }

    .quick-action {
        display: block;
        text-decoration: none;
        background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 18px;
        padding: 1rem;
        color: #0f172a;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .quick-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(59, 130, 246, 0.12);
        color: #0f172a;
    }

    .quick-action strong {
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.98rem;
    }

    .quick-action span {
        color: #64748b;
        font-size: 0.88rem;
    }

    .report-list,
    .activity-list {
        padding: 0 1.5rem 1.5rem;
    }

    .report-item,
    .activity-item {
        display: grid;
        gap: 0.35rem;
        padding: 1rem 0;
        border-top: 1px solid #e2e8f0;
    }

    .report-item:first-child,
    .activity-item:first-child {
        border-top: none;
        padding-top: 0;
    }

    .report-item-head,
    .activity-item-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .report-item strong,
    .activity-item strong {
        color: #0f172a;
    }

    .report-item p,
    .activity-item p {
        margin: 0;
        color: #475569;
        font-size: 0.94rem;
    }

    .soft-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.65rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .soft-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .soft-badge.reviewed,
    .soft-badge.active {
        background: #dcfce7;
        color: #166534;
    }

    .soft-badge.post {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .soft-badge.comment {
        background: #ede9fe;
        color: #6d28d9;
    }

    .report-reason-list {
        padding: 0 1.5rem 1.5rem;
        display: grid;
        gap: 0.85rem;
    }

    .reason-row {
        display: grid;
        gap: 0.45rem;
    }

    .reason-row-head {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        font-size: 0.94rem;
        color: #1e293b;
        font-weight: 600;
    }

    .reason-progress {
        width: 100%;
        height: 9px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .reason-progress span {
        display: block;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #0f766e 0%, #2563eb 100%);
    }

    .table-card {
        margin-top: 1rem;
    }

    .table-wrap {
        overflow-x: auto;
        padding: 0 1.5rem 1.5rem;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table th {
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        padding: 0.9rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .dashboard-table td {
        padding: 0.95rem 0;
        border-bottom: 1px solid #eef2f7;
        color: #334155;
        vertical-align: top;
    }

    .dashboard-table tr:last-child td {
        border-bottom: none;
    }

    .muted-text {
        color: #64748b;
        font-size: 0.88rem;
    }

    .empty-state {
        padding: 2rem 1.5rem 1.75rem;
        color: #64748b;
        text-align: center;
    }

    @media (max-width: 1200px) {
        .stats-grid,
        .quick-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .admin-dashboard {
            padding-top: 0.75rem;
        }

        .dashboard-shell {
            padding: 0 0.9rem;
        }

        .dashboard-hero {
            grid-template-columns: 1fr;
            padding: 1.4rem;
            border-radius: 22px;
        }

        .dashboard-hero h1 {
            font-size: 1.6rem;
        }

        .stats-grid,
        .quick-actions {
            grid-template-columns: 1fr;
        }

        .dashboard-card-header,
        .report-list,
        .activity-list,
        .report-reason-list,
        .table-wrap {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>

<div class="admin-dashboard">
    <div class="dashboard-shell">
        <section class="dashboard-hero">
            <div>
                <div class="hero-badge">Dashboard Admin</div>
                <h1>Ringkasan moderasi untuk {{ Auth::user()->name }}</h1>
                <p>Halaman ini sekarang menampilkan data nyata dari aplikasi: jumlah posting aktif, total pengguna, total report dari user, serta daftar report terbaru agar proses moderasi lebih cepat.</p>
                <div class="hero-chips">
                    <span class="hero-chip">{{ number_format($activePosts) }} posting aktif</span>
                    <span class="hero-chip">{{ number_format($totalUsers) }} pengguna</span>
                    <span class="hero-chip">{{ number_format($pendingReports) }} report menunggu review</span>
                </div>
            </div>

            <div class="hero-summary">
                <div class="hero-summary-title">Status saat ini</div>
                <div class="hero-summary-grid">
                    <div class="hero-summary-item">
                        <strong>{{ number_format($totalReports) }}</strong>
                        <span>Total seluruh laporan yang masuk</span>
                    </div>
                    <div class="hero-summary-item">
                        <strong>{{ number_format($recentReports->whereNotNull('post_id')->count()) }}</strong>
                        <span>Laporan post pada daftar terbaru</span>
                    </div>
                    <div class="hero-summary-item">
                        <strong>{{ number_format($recentReports->whereNotNull('comment_id')->count()) }}</strong>
                        <span>Laporan komentar pada daftar terbaru</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="stats-grid">
            <article class="stat-card">
                <small>Posting Aktif</small>
                <strong>{{ number_format($activePosts) }}</strong>
                <p>Posting milik user yang masih tayang dan belum dibanned.</p>
            </article>
            <article class="stat-card">
                <small>Pengguna</small>
                <strong>{{ number_format($totalUsers) }}</strong>
                <p>Total akun dengan role user yang terdaftar di sistem.</p>
            </article>
            <article class="stat-card">
                <small>Total Report</small>
                <strong>{{ number_format($totalReports) }}</strong>
                <p>Gabungan seluruh laporan post dan komentar dari pengguna.</p>
            </article>
            <article class="stat-card">
                <small>Report Pending</small>
                <strong>{{ number_format($pendingReports) }}</strong>
                <p>Laporan yang masih butuh tindak lanjut dari admin.</p>
            </article>
        </section>

        <section class="dashboard-card">
            <div class="dashboard-card-header">
                <div>
                    <h2>Akses cepat</h2>
                    <p>Navigasi utama admin dibuat lebih jelas supaya kerja moderasi lebih cepat.</p>
                </div>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.user.posts') }}" class="quick-action">
                    <strong>Kelola postingan</strong>
                    <span>Lihat posting aktif, banned, dan detail user.</span>
                </a>
                <a href="{{ route('admin.user.index') }}" class="quick-action">
                    <strong>Kelola pengguna</strong>
                    <span>Cari akun user dan hapus bila diperlukan.</span>
                </a>
                <a href="{{ route('admin.report.post') }}" class="quick-action">
                    <strong>Report postingan</strong>
                    <span>Tinjau laporan yang terkait dengan postingan.</span>
                </a>
                <a href="{{ route('admin.report.comment') }}" class="quick-action">
                    <strong>Report komentar</strong>
                    <span>Tinjau laporan yang terkait dengan komentar.</span>
                </a>
            </div>
        </section>

        <section class="dashboard-grid">
            <article class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <h3>Report terbaru dari user</h3>
                        <p>Daftar laporan terbaru lengkap dengan pelapor, target, dan status penanganan.</p>
                    </div>
                </div>
                <div class="report-list">
                    @forelse ($recentReports as $report)
                        <div class="report-item">
                            <div class="report-item-head">
                                <div>
                                    <strong>{{ $report->reporter?->name ?? 'Pengguna tidak ditemukan' }}</strong>
                                    <span class="muted-text">melaporkan {{ $report->reportedUser?->name ?? 'pengguna' }}</span>
                                </div>
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="soft-badge {{ $report->status }}">{{ ucfirst($report->status) }}</span>
                                    <span class="soft-badge {{ $report->report_type }}">{{ $report->report_type === 'post' ? 'Post' : 'Komentar' }}</span>
                                </div>
                            </div>
                            <p>{{ $report->reason_label }}@if($report->description) - {{ \Illuminate\Support\Str::limit($report->description, 90) }}@endif</p>
                            <span class="muted-text">{{ $report->created_at->format('d M Y H:i') }}</span>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada report dari user.</div>
                    @endforelse
                </div>
            </article>

            <article class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <h3>Ringkasan alasan report</h3>
                        <p>Alasan yang paling sering dipilih pengguna.</p>
                    </div>
                </div>
                <div class="report-reason-list">
                    @php
                        $highestReasonCount = max($reportSummary->max('total') ?? 1, 1);
                    @endphp

                    @forelse ($reportSummary as $item)
                        <div class="reason-row">
                            <div class="reason-row-head">
                                <span>{{ $item->reason_label }}</span>
                                <span>{{ number_format($item->total) }} laporan</span>
                            </div>
                            <div class="reason-progress">
                                <span style="width: {{ ($item->total / $highestReasonCount) * 100 }}%"></span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">Belum ada data report untuk dirangkum.</div>
                    @endforelse
                </div>
            </article>
        </section>

        <section class="dashboard-grid table-card">
            <article class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <h3>Pengguna terbaru</h3>
                        <p>User terbaru yang baru masuk ke platform.</p>
                    </div>
                </div>
                <div class="table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if ($user->username)
                                            <div class="muted-text">{{ '@' . $user->username }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center muted-text">Belum ada data pengguna.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="dashboard-card">
                <div class="dashboard-card-header">
                    <div>
                        <h3>Posting aktif terbaru</h3>
                        <p>Posting user terbaru yang masih aktif di platform.</p>
                    </div>
                </div>
                <div class="table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Caption</th>
                                <th>Interaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPosts as $post)
                                <tr>
                                    <td>
                                        <strong>{{ $post->user?->name ?? 'User tidak ditemukan' }}</strong>
                                        <div class="muted-text">{{ $post->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($post->caption ?: 'Tanpa caption', 60) }}</td>
                                    <td>
                                        <span class="muted-text">{{ $post->likes_count }} suka</span><br>
                                        <span class="muted-text">{{ $post->comments_count }} komentar • {{ $post->reports_count }} report</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center muted-text">Belum ada posting aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </div>
</div>
@endsection
