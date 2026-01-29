@extends('layouts.index')

@section('content')
<style>
    .create-post-container {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 40px 0;
    }
    
    .post-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 1040px;
        margin: 0 auto;
    }
    
    .card-header {
        background: #4a90e2;
        color: white;
        padding: 20px;
        border-radius: 12px 12px 0 0;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
    }
    
    .card-body {
        padding: 30px;
    }
    
    /* Alert Styles */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .alert i {
        font-size: 18px;
    }
    
    .btn-close {
        background: transparent;
        border: none;
        font-size: 20px;
        cursor: pointer;
        margin-left: auto;
        opacity: 0.5;
        transition: opacity 0.3s;
    }
    
    .btn-close:hover {
        opacity: 1;
    }
    
    .photo-preview-section {
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        margin-bottom: 25px;
        background: #f8f9fa;
        transition: all 0.3s;
    }
    
    .photo-preview-section:hover {
        border-color: #4a90e2;
        background: #f0f7ff;
    }
    
    .photo-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .photo-preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .photo-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .remove-photo-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        transition: all 0.3s;
    }
    
    .remove-photo-btn:hover {
        background: #c0392b;
        transform: scale(1.1);
    }
    
    .upload-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }
    
    .upload-text {
        color: #8e8e8e;
        margin-bottom: 15px;
    }
    
    .form-label {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control, .form-select {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px 15px;
        width: 100%;
        transition: all 0.3s;
        font-size: 14px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #e74c3c;
    }
    
    .invalid-feedback {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
    
    .mb-3 {
        margin-bottom: 20px;
    }
    
    .row {
        display: flex;
        margin: 0 -10px;
    }
    
    .col-md-6 {
        flex: 0 0 50%;
        padding: 0 10px;
    }
    
    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }
    
    .btn-primary {
        background: #4a90e2;
        color: white;
    }
    
    .btn-primary:hover {
        background: #357abd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }
    
    .btn-secondary {
        background: #e0e0e0;
        color: #4a4a4a;
    }
    
    .btn-secondary:hover {
        background: #d0d0d0;
    }
    
    .d-flex {
        display: flex;
    }
    
    .justify-content-between {
        justify-content: space-between;
    }
    
    .gap-2 {
        gap: 10px;
    }
    
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
        
        .col-md-6 {
            flex: 0 0 100%;
            margin-bottom: 20px;
        }
        
        .photo-preview-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="create-post-container mt-5">
    <div class="container">
        <div class="post-card">
            <div class="card-header">
                <h5 class="text-white text-center">📸 Upload Postingan Baru</h5>
            </div>

            <div class="card-body">
                {{-- SUCCESS ALERT --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> 
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                {{-- ERROR ALERT --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> 
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                {{-- VALIDATION ERRORS --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul style="margin: 10px 0 0 20px; padding: 0;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('user.postingan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- PHOTO UPLOAD --}}
                    <div class="mb-3">
                        <label class="form-label">Foto (Maksimal 10 foto)</label>
                        <div class="photo-preview-section">
                            <div class="upload-icon">🖼️</div>
                            <div class="upload-text">
                                Silahkan pilih foto untuk diunggah
                            </div>
                            <input
                                type="file"
                                name="photos[]"
                                id="photoInput"
                                class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
                                accept="image/*"
                                multiple
                                onchange="previewPhotos(event)"
                            >
                        </div>

                        <div id="photoPreviewContainer" class="photo-preview-container"></div>

                        @error('photos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('photos.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CAPTION --}}
                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <textarea
                            name="caption"
                            rows="4"
                            class="form-control @error('caption') is-invalid @enderror"
                            placeholder="Tulis caption untuk postingan Anda..."
                        >{{ old('caption') }}</textarea>

                        @error('caption')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CAMERA TYPE & GENRE --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipe Kamera</label>
                                <select name="camera_type" class="form-select @error('camera_type') is-invalid @enderror" required>
                                    <option value="">Pilih Tipe Kamera</option>
                                    <option value="DSLR" {{ old('camera_type') == 'DSLR' ? 'selected' : '' }}>DSLR</option>
                                    <option value="Mirrorless" {{ old('camera_type') == 'Mirrorless' ? 'selected' : '' }}>Mirrorless</option>
                                    <option value="Phone" {{ old('camera_type') == 'Phone' ? 'selected' : '' }}>Phone</option>
                                </select>

                                @error('camera_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Genre Foto</label>
                                <select name="genre" class="form-select @error('genre') is-invalid @enderror" required>
                                    <option value="">Pilih Genre</option>
                                    <option value="Landscape" {{ old('genre') == 'Landscape' ? 'selected' : '' }}>Landscape</option>
                                    <option value="Portrait" {{ old('genre') == 'Portrait' ? 'selected' : '' }}>Portrait</option>
                                    <option value="Street" {{ old('genre') == 'Street' ? 'selected' : '' }}>Street</option>
                                    <option value="Macro" {{ old('genre') == 'Macro' ? 'selected' : '' }}>Macro</option>
                                </select>

                                @error('genre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('user.profile') }}" class="btn btn-secondary">
                            ← Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            📤 Upload Postingan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- PREVIEW PHOTOS SCRIPT --}}
<script>
let selectedFiles = [];

function previewPhotos(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('photoPreviewContainer');
    
    // Limit to 10 photos
    if (selectedFiles.length + files.length > 10) {
        alert('Maksimal 10 foto!');
        return;
    }
    
    files.forEach((file, index) => {
        selectedFiles.push(file);
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'photo-preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-photo-btn" onclick="removePhoto(${selectedFiles.length - 1})">×</button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    // Update file input dengan file yang sudah dipilih
    updateFileInput();  // ← GANTI dari event.target.value = ''
}

function removePhoto(index) {
    selectedFiles.splice(index, 1);
    
    // Rebuild preview
    const container = document.getElementById('photoPreviewContainer');
    container.innerHTML = '';
    
    selectedFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'photo-preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-photo-btn" onclick="removePhoto(${idx})">×</button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    // Update file input
    updateFileInput();
}

function updateFileInput() {
    const input = document.getElementById('photoInput');
    const dataTransfer = new DataTransfer();
    
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    
    input.files = dataTransfer.files;
}

// Auto hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection