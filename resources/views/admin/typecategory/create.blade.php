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

    .admin-form-card .form-control,
    .admin-form-card .form-select {
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
            <h1>Tambah Sub Kategori</h1>
            <p>Tambahkan turunan kategori agar klasifikasi postingan lebih detail.</p>

            <form action="{{ route('admin.typecategory.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Kategori</label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Sub Kategori</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Street Photography">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.typecategory.index') }}" class="btn btn-light border">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
