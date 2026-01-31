@extends('layouts.index2')

@section('content')
<style>
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Container - Minimal Padding */
    .create-post-container {
        background: transparent; /* Hapus background */
        min-height: calc(100vh - 60px);
        padding: 3px 0; /* Lebih dekat ke navbar */
    }
    
    .post-wrapper {
        max-width: 1400px; /* Lebih lebar */
        margin: 0 auto;
        padding: 0 40px;
    }
    
    /* Header Section - Compact */
    .page-header {
        text-align: center;
        margin-bottom: 24px; /* Lebih kecil */
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-header p {
        font-size: 16px;
        color: #8e8e8e;
        font-weight: 500;
    }

    /* Post Card - Lebih Lebar */
    .post-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .card-body {
        padding: 50px 60px; /* Padding lebih besar untuk card lebar */
    }
    
    /* Alert Styles - Modern */
    .alert {
        border-radius: 16px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    .alert i {
        font-size: 20px;
        margin-top: 2px;
    }

    .alert ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
        list-style: none;
    }

    .alert ul li:before {
        content: "•";
        color: #721c24;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
    
    .btn-close {
        background: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
        margin-left: auto;
        opacity: 0.6;
        transition: all 0.3s;
        line-height: 1;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }
    
    /* Photo Upload Section - Drag & Drop Style */
    .photo-upload-wrapper {
        margin-bottom: 32px;
    }

    .section-label {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-label .badge {
        background: #e8f4f8;
        color: #4a90e2;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .photo-preview-section {
        border: 3px dashed #d0d0d0;
        border-radius: 20px;
        padding: 50px 40px;
        text-align: center;
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .photo-preview-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(74, 144, 226, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .photo-preview-section:hover {
        border-color: #4a90e2;
        background: linear-gradient(135deg, #f0f7ff 0%, #e8f4f8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(74, 144, 226, 0.15);
    }

    .photo-preview-section:hover::before {
        opacity: 1;
    }

    .photo-preview-section.dragover {
        border-color: #4a90e2;
        background: linear-gradient(135deg, #e8f4f8 0%, #d4edff 100%);
        transform: scale(1.02);
    }
    
    .upload-icon {
        font-size: 64px;
        margin-bottom: 16px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .upload-text {
        color: #4a4a4a;
        margin-bottom: 12px;
        font-size: 16px;
        font-weight: 600;
    }

    .upload-subtext {
        color: #8e8e8e;
        font-size: 14px;
        margin-bottom: 20px;
    }

    #photoInput {
        display: none;
    }

    .upload-button {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 28px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .upload-button:hover {
        background: linear-gradient(135deg, #357abd, #2868a8);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(74, 144, 226, 0.4);
    }
    
    /* Photo Preview Grid - Wider Layout */
    .photo-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Lebih lebar */
        gap: 20px;
        margin-top: 24px;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .photo-preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f0f0f0;
    }

    .photo-preview-item:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 12px 24px rgba(0,0,0,0.2);
    }
    
    .photo-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .photo-preview-item:hover img {
        transform: scale(1.1);
    }

    .photo-number {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(10px);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        z-index: 1;
    }
    
    .remove-photo-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(231, 76, 60, 0.95);
        backdrop-filter: blur(10px);
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }
    
    .remove-photo-btn:hover {
        background: #c0392b;
        transform: scale(1.15) rotate(90deg);
        box-shadow: 0 6px 16px rgba(231, 76, 60, 0.5);
    }
    
    /* Form Elements - Modern */
    .form-group {
        margin-bottom: 28px;
    }

    .form-label {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
        display: block;
        font-size: 15px;
    }

    .form-label .required {
        color: #e74c3c;
        margin-left: 4px;
    }
    
    .form-control, .form-select {
        border: 2px solid #e8e8e8;
        border-radius: 14px;
        padding: 14px 20px;
        width: 100%;
        transition: all 0.3s ease;
        font-size: 15px;
        color: #262626;
        background: #fafafa;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.1);
        background: white;
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #e74c3c;
        background: #fff5f5;
    }
    
    .invalid-feedback {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 8px;
        display: block;
        font-weight: 500;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.6;
        font-family: inherit;
    }

    /* Character Counter */
    .char-counter {
        text-align: right;
        font-size: 13px;
        color: #8e8e8e;
        margin-top: 6px;
        font-weight: 500;
    }

    .char-counter.warning {
        color: #f39c12;
    }

    .char-counter.danger {
        color: #e74c3c;
    }
    
    /* Grid Layout for Form - Lebih Lebar */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 28px;
    }
    
    /* Buttons - Modern & Gradient */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 40px;
        padding-top: 32px;
        border-top: 2px solid #f0f0f0;
    }
    
    .btn {
        padding: 14px 32px;
        border-radius: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        color: white;
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #357abd, #2868a8);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(74, 144, 226, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }
    
    .btn-secondary {
        background: white;
        color: #4a4a4a;
        border: 2px solid #e8e8e8;
    }
    
    .btn-secondary:hover {
        background: #f8f8f8;
        border-color: #d0d0d0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Loading State */
    .btn-primary:disabled {
        background: #dbdbdb;
        cursor: not-allowed;
        opacity: 0.7;
        transform: none !important;
    }

    .btn-primary.loading {
        position: relative;
        color: transparent;
    }

    .btn-primary.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 3px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Select Enhancement */
    .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234a4a4a' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 20px center;
        padding-right: 50px;
        appearance: none;
        cursor: pointer;
    }

    .form-select:disabled {
        background-color: #f5f5f5;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    /* Responsive Design */
    @media (max-width: 1400px) {
        .post-wrapper {
            padding: 0 30px;
        }
    }

    @media (max-width: 1024px) {
        .post-wrapper {
            padding: 0 25px;
        }

        .card-body {
            padding: 40px 50px;
        }
    }

    @media (max-width: 768px) {
        .create-post-container {
            padding: 15px 0;
        }

        .post-wrapper {
            padding: 0 15px;
        }

        .page-header h1 {
            font-size: 26px;
        }

        .page-header p {
            font-size: 14px;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .card-body {
            padding: 30px 24px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 24px;
        }
        
        .photo-preview-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .photo-preview-section {
            padding: 40px 20px;
        }

        .upload-icon {
            font-size: 48px;
        }

        .upload-text {
            font-size: 15px;
        }

        .upload-subtext {
            font-size: 13px;
        }

        .action-buttons {
            flex-direction: column-reverse;
            gap: 12px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .alert {
            padding: 14px 16px;
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .photo-preview-container {
            grid-template-columns: 1fr;
        }

        .section-label {
            font-size: 15px;
        }

        .form-label {
            font-size: 14px;
        }

        .card-body {
            padding: 24px 20px;
        }
    }

    /* Smooth Transitions */
    * {
        transition: background 0.3s ease, border 0.3s ease, transform 0.3s ease;
    }

    /* Focus Visible for Accessibility */
    *:focus-visible {
        outline: 2px solid #4a90e2;
        outline-offset: 2px;
    }
</style>

<div class="create-post-container">
    <div class="post-wrapper">
        <!-- Page Header - Compact -->
        <div class="page-header">
            <h1>📸 Buat Postingan Baru</h1>
            <p>Bagikan momen terbaik Anda dengan dunia</p>
        </div>

        <div class="post-card">
            <div class="card-body">
                {{-- SUCCESS ALERT --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i>✓</i> 
                        <span><strong>Berhasil!</strong> {{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                    </div>
                @endif

                {{-- ERROR ALERT --}}
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i>⚠</i> 
                        <span><strong>Gagal!</strong> {{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                    </div>
                @endif

                {{-- VALIDATION ERRORS --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i>⚠</i>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('user.postingan.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    {{-- PHOTO UPLOAD --}}
                    <div class="photo-upload-wrapper">
                        <div class="section-label">
                            <span>Pilih Foto</span>
                            <span class="badge">Maks 8 foto</span>
                        </div>
                        
                        <div class="photo-preview-section" id="dropZone" onclick="document.getElementById('photoInput').click()">
                            <div class="upload-icon">🖼️</div>
                            <div class="upload-text">Tambahkan fotomu disini</div>
                            <div class="upload-subtext">Mendukung JPG, JPEG, PNG, GIFT</div>
                            <button type="button" class="upload-button">
                                <span>📁</span>
                                <span>Pilih Foto</span>
                            </button>
                            <input
                                type="file"
                                name="photos[]"
                                id="photoInput"
                                accept="image/*"
                                multiple
                                onchange="previewPhotos(event)"
                            >
                        </div>

                        <div id="photoPreviewContainer" class="photo-preview-container"></div>
                    </div>

                    {{-- CAPTION --}}
                    <div class="form-group">
                        <label class="form-label">Caption</label>
                        <textarea
                            name="caption"
                            id="captionInput"
                            rows="4"
                            class="form-control @error('caption') is-invalid @enderror"
                            placeholder="Ceritakan tentang foto Anda..."
                            maxlength="500"
                        >{{ old('caption') }}</textarea>
                        <div class="char-counter" id="charCounter">0 / 500 karakter</div>
                        @error('caption')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CATEGORY & TYPE --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Kategori
                                <span class="required">*</span>
                            </label>
                            <select id="categorySelect" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach                                    
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Tipe Foto
                                <span class="required">*</span>
                            </label>
                            <select id="typeCategorySelect" name="type_category_id" class="form-select @error('type_category_id') is-invalid @enderror" required disabled>
                                <option value="">Pilih Kategori Dulu</option>
                                @foreach ($typeCategories as $typeCategory)
                                    <option
                                        value="{{ $typeCategory->id }}"
                                        data-category-id="{{ $typeCategory->category_id ?? '' }}"
                                        {{ old('type_category_id') == $typeCategory->id ? 'selected' : '' }}
                                    >
                                        {{ $typeCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="action-buttons">
                        <a href="{{ route('user.profile') }}" class="btn btn-secondary">
                            <span>←</span>
                            <span>Kembali</span>
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span>📤</span>
                            <span>Upload Postingan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let selectedFiles = [];

// Drag & Drop functionality
const dropZone = document.getElementById('dropZone');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    e.stopPropagation();
    dropZone.classList.remove('dragover');
    
    const files = Array.from(e.dataTransfer.files);
    const imageFiles = files.filter(file => file.type.startsWith('image/'));
    
    if (imageFiles.length > 0) {
        handleFiles(imageFiles);
    }
});

// Preview photos function
function previewPhotos(event) {
    const files = Array.from(event.target.files);
    handleFiles(files);
}

function handleFiles(files) {
    if (selectedFiles.length + files.length > 10) {
        alert('⚠️ Maksimal 10 foto!\nAnda sudah memilih ' + selectedFiles.length + ' foto.');
        return;
    }
    
    files.forEach((file) => {
        if (file.size > 15 * 1024 * 1024) {
            alert('⚠️ File ' + file.name + ' terlalu besar! Maksimal 15MB per foto.');
            return;
        }

        selectedFiles.push(file);
        
        const reader = new FileReader();
        reader.onload = function(e) {
            renderPreview();
        };
        reader.readAsDataURL(file);
    });
}

function renderPreview() {
    const container = document.getElementById('photoPreviewContainer');
    container.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'photo-preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${index + 1}">
                <div class="photo-number">${index + 1}</div>
                <button type="button" class="remove-photo-btn" onclick="removePhoto(${index})">×</button>
            `;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    updateFileInput();
}

function removePhoto(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

function updateFileInput() {
    const input = document.getElementById('photoInput');
    const dataTransfer = new DataTransfer();
    
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    
    input.files = dataTransfer.files;
}

// Character counter
const captionInput = document.getElementById('captionInput');
const charCounter = document.getElementById('charCounter');

if (captionInput && charCounter) {
    captionInput.addEventListener('input', function() {
        const length = this.value.length;
        const maxLength = 500;
        charCounter.textContent = `${length} / ${maxLength} karakter`;
        
        if (length > maxLength * 0.9) {
            charCounter.classList.add('danger');
            charCounter.classList.remove('warning');
        } else if (length > maxLength * 0.7) {
            charCounter.classList.add('warning');
            charCounter.classList.remove('danger');
        } else {
            charCounter.classList.remove('warning', 'danger');
        }
    });
}

// Auto hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch(e) {}
        }, 5000);
    });
});

// Dependent select
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('categorySelect');
    const typeSelect = document.getElementById('typeCategorySelect');
    if (!categorySelect || !typeSelect) return;

    const placeholderOption = typeSelect.querySelector('option[value=""]');
    const typeOptions = Array.from(typeSelect.querySelectorAll('option')).filter(o => o.value !== '');

    const oldCategory = @json(old('category_id'));
    const oldType = @json(old('type_category_id'));

    function filterTypeOptions() {
        const catId = String(categorySelect.value || '');
        let anyVisible = false;

        typeOptions.forEach(opt => {
            const optCat = String(opt.dataset.categoryId || '');
            if (catId !== '' && optCat === catId) {
                opt.hidden = false;
                opt.disabled = false;
                anyVisible = true;
            } else {
                opt.hidden = true;
                opt.disabled = true;
            }
        });

        if (placeholderOption) {
            placeholderOption.hidden = false;
            placeholderOption.disabled = false;
            placeholderOption.textContent = catId ? 'Pilih Tipe Foto' : 'Pilih Kategori Dulu';
        }

        typeSelect.disabled = !anyVisible;

        if (typeSelect.value) {
            const selOpt = typeSelect.querySelector(`option[value="${typeSelect.value}"]`);
            if (!selOpt || selOpt.disabled) {
                typeSelect.value = '';
            }
        }
    }

    if (oldCategory) {
        categorySelect.value = oldCategory;
    }

    filterTypeOptions();

    if (oldType) {
        const oldOpt = typeSelect.querySelector(`option[value="${oldType}"]`);
        if (oldOpt && !oldOpt.disabled) {
            typeSelect.value = oldType;
        } else {
            typeSelect.value = '';
        }
    }

    categorySelect.addEventListener('change', function () {
        filterTypeOptions();
        typeSelect.value = '';
    });
});

// Form submission
const uploadForm = document.getElementById('uploadForm');
const submitBtn = document.getElementById('submitBtn');

if (uploadForm && submitBtn) {
    uploadForm.addEventListener('submit', function(e) {
        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('⚠️ Minimal 1 foto harus dipilih!');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
    });
}
</script>
@endsection