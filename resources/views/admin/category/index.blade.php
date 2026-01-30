@extends('layouts.index')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Data Kategori</h4>
        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('admin.category.index') }}" method="GET" class="mt-4">
        <div class="input-group">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari kategori..."
                   value="{{ request('search') }}">
            <button class="btn btn-outline-primary">Cari</button>
        </div>
    </form>

    {{-- Table --}}
    <div class="card mt-3">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <a href="{{ route('admin.category.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning">
                                   Edit
                                </a>

                                <form action="{{ route('admin.category.destroy', $category->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Data kategori tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
