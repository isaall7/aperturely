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
        margin-bottom: 1rem;
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

    .admin-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.06);
    }

    .admin-toolbar {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
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
        color: #334155;
        vertical-align: middle;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
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

    .meta-title {
        font-weight: 700;
        color: #0f172a;
    }

    .meta-subtitle {
        color: #64748b;
        font-size: 0.88rem;
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

    @media (max-width: 768px) {
        .admin-page {
            padding-top: 0.75rem;
        }

        .admin-page-shell {
            padding: 0 0.9rem;
        }

        .admin-page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .admin-toolbar,
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
                <h1>Kategori</h1>
                <p>Kelola kategori utama yang dipakai untuk postingan.</p>
            </div>
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>

        <div class="admin-card">
            <form action="{{ route('admin.category.index') }}" method="GET" class="admin-toolbar">
                <div class="row g-3">
                    <div class="col-md-9">
                        <input type="text" name="search" class="form-control search-input" placeholder="Cari kategori..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-outline-primary">Cari</button>
                    </div>
                </div>
            </form>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="meta-title">{{ $category->name }}</div>
                                    <div class="meta-subtitle">Kategori utama</div>
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <div class="action-row">
                                        <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">Data kategori tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
