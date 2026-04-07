@extends('layouts.index')

@section('content')
<style>
    .admin-form-page {
        padding: 1.5rem 0 2.5rem;
        background: linear-gradient(180deg, #f8fafc 0%, #eff4f9 100%);
        min-height: calc(100vh - 80px);
    }

    .admin-form-shell {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 1.25rem;
    }

    .admin-form-card {
        background: #fff;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.06);
        padding: 1.6rem;
    }

    .admin-form-card h1 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        color: #0f172a;
    }

    .admin-form-card p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .admin-form-card .form-control {
        border-radius: 16px;
        padding: 0.85rem 1rem;
    }

    .form-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .admin-form-page {
            padding-top: 0.75rem;
        }

        .admin-form-shell {
            padding: 0 0.9rem;
        }

        .admin-form-card {
            padding: 1.2rem;
        }
    }
</style>

<div class="admin-form-page">
    <div class="admin-form-shell">
        <div class="admin-form-card">
            <h1>Edit Kategori</h1>
            <p>Perbarui nama kategori utama agar tetap konsisten dengan struktur konten.</p>

            <form action="{{ route('admin.category.update', $categories->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $categories->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.category.index') }}" class="btn btn-light border">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
