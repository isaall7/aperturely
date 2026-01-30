@extends('layouts.index')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Data Kategori</h4>
        <a href="{{ route('admin.typecategory.create') }}" class="btn btn-primary">
            + Tambah Tipe Kategori 
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('admin.typecategory.index') }}" method="GET" class="mt-4">
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
                        <th>Nama Kategori</th>
                        <th>Tipe</th>
                        <th>Slug</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($type as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->category->name }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <a href="{{ route('admin.typecategory.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning">
                                   Edit
                                </a>
                                <form action="{{ route('admin.typecategory.destroy', $category->id) }}"
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
                                Tidak ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
</div>
@endsection