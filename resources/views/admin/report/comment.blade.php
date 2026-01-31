@extends('layouts.index')

@section('title', 'Laporan Komentar')

@section('content')
<div class="container px-4 mt-5 ">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Laporan Komentar</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.report.comment') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari berdasarkan nama pelapor, terlapor, alasan..." 
                           value="{{ $search ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Daftar Laporan Komentar</h5>
        </div>
        <div class="card-body p-0">
            @if($reports->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Tidak ada laporan komentar</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Pelapor</th>
                                <th>Terlapor</th>
                                <th>Komentar</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $report->reporter->avatar ?? 'https://ui-avatars.com/api/?name='.$report->reporter->name }}" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <div>
                                            <div class="fw-semibold">{{ $report->reporter->name }}</div>
                                            <small class="text-muted"> {{ $report->reporter->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $report->reportedUser->avatar ?? 'https://ui-avatars.com/api/?name='.$report->reportedUser->name }}" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <div>
                                            <div class="fw-semibold">{{ $report->reportedUser->name }}</div>
                                            <small class="text-muted">{{ $report->reportedUser->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($report->comment)
                                        <div>{{ Str::limit($report->comment->content, 80) }}</div>
                                        <small class="text-muted">
                                            Status: 
                                            <span class="badge {{ $report->comment->status === 'banned' ? 'bg-danger' : 'bg-success' }}">
                                                {{ ucfirst($report->comment->status) }}
                                            </span>
                                        </small>
                                    @else
                                        <span class="text-muted">Komentar dihapus</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $report->reason }}</span>
                                </td>
                                <td>
                                    @if($report->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-success">Reviewed</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $report->created_at->format('d M Y') }}</small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal{{ $report->id }}">Detail
                                    </button>
                                    @if($report->comment && $report->comment->status !== 'banned')
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#banModal{{ $report->id }}">Ban
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal{{ $report->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Laporan #{{ $report->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <h6>Pelapor</h6>
                                                    <p>{{ $report->reporter->name }} ({{ $report->reporter->email }})</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Terlapor</h6>
                                                    <p>{{ $report->reportedUser->name }} ({{ $report->reportedUser->email }})</p>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Alasan</h6>
                                                <p>{{ $report->reason }}</p>
                                            </div>
                                            @if($report->description)
                                                <div class="mb-3">
                                                    <h6>Deskripsi</h6>
                                                    <p>{{ $report->description }}</p>
                                                </div>
                                            @endif
                                            @if($report->comment)
                                                <div class="mb-3">
                                                    <h6>Konten Komentar</h6>
                                                    <div class="border rounded p-3 bg-light">
                                                        {{ $report->comment->comment }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Ban -->
                            @if($report->comment && $report->comment->status !== 'banned')
                                <div class="modal fade" id="banModal{{ $report->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.post.bancomment', $report->comment->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Ban Komentar</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-warning">
                                                        <i class="bi bi-exclamation-triangle"></i>
                                                        Anda akan memban komentar dari <strong>{{ $report->reportedUser->name }}</strong>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alasan Ban <span class="text-danger">*</span></label>
                                                        <input type="text" name="reason" class="form-control" required
                                                               value="{{ $report->reason }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Catatan Tambahan</label>
                                                        <textarea name="notes" class="form-control" rows="3">{{ $report->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="bi bi-ban"></i> Ban Komentar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection