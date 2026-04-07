@extends('layouts.index')

@section('content')
<style>
    .admin-page {
        padding: 1.5rem 0 2.5rem;
        background: linear-gradient(180deg, #f8fafc 0%, #eff4f9 100%);
        min-height: calc(100vh - 80px);
    }

    .admin-page-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.25rem;
    }

    .admin-page-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .admin-page-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        color: #0f172a;
    }

    .admin-page-header p {
        margin: 0;
        color: #64748b;
    }

    .admin-summary-card,
    .admin-content-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.06);
    }

    .admin-summary-card {
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .admin-summary-card strong {
        display: block;
        font-size: 1.9rem;
        line-height: 1;
        color: #0f172a;
    }

    .admin-summary-card span {
        color: #64748b;
        font-size: 0.95rem;
    }

    .search-form {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .search-input {
        border-radius: 16px;
        border: 1px solid #cbd5e1;
        padding: 0.85rem 1rem;
        box-shadow: none;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.1);
    }

    .admin-table-wrap {
        overflow-x: auto;
        padding: 0 1.5rem 1.5rem;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th {
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .admin-table td {
        padding: 1rem 0;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        color: #334155;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .user-meta strong {
        display: block;
        color: #0f172a;
    }

    .user-meta span {
        color: #64748b;
        font-size: 0.88rem;
    }

    .soft-role {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.7rem;
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .danger-btn {
        border-radius: 12px;
        padding: 0.55rem 0.95rem;
        font-weight: 600;
    }

    .empty-state {
        padding: 2rem 1.5rem 2.2rem;
        text-align: center;
        color: #64748b;
    }

    @media (max-width: 768px) {
        .admin-page {
            padding-top: 0.75rem;
        }

        .admin-page-shell {
            padding: 0 0.9rem;
        }

        .admin-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .search-form,
        .admin-table-wrap {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>

<div class="admin-page">
    <div class="admin-page-shell">
        <div class="admin-page-header">
            <div>
                <h1>Daftar Pengguna</h1>
                <p>Kelola akun user yang terdaftar di Aperturely.</p>
            </div>
        </div>

        <div class="admin-summary-card">
            <div>
                <strong>{{ number_format($users->count()) }}</strong>
                <span>hasil ditampilkan untuk daftar pengguna</span>
            </div>
            <div>
                <span>Pencarian bisa berdasarkan nama, email, atau role.</span>
            </div>
        </div>

        <div class="admin-content-card">
            <form method="GET" action="{{ route('admin.user.index') }}" class="search-form">
                <div class="row g-3">
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control search-input" placeholder="Cari nama atau email pengguna..." value="{{ request()->search }}">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-primary danger-btn" type="submit">Cari Pengguna</button>
                    </div>
                </div>
            </form>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <div class="user-meta">
                                        <strong>{{ $user->name }}</strong>
                                        <span>{{ $user->username ? '@' . $user->username : 'Tanpa username' }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td><span class="soft-role">{{ $user->role }}</span></td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger danger-btn">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">Tidak ada akun pengguna yang cocok dengan pencarian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
