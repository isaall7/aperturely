@extends('layouts.index2')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --black:       #0a0a0a;
        --white:       #ffffff;
        --cream:       #f9f7f4;
        --warm-gray:   #e8e4df;
        --mid-gray:    #b8b3ac;
        --muted:       #888077;
        --accent:      #c8533a;
        --accent-h:    #a83f28;
        --accent-soft: #f5ece9;
        --green:       #1a7431;
        --green-soft:  #eaf5ec;
        --red:         #c0392b;
        --red-soft:    #fdf2f2;
        --shadow-sm:   0 1px 3px rgba(10,10,10,0.07);
        --shadow-md:   0 4px 16px rgba(10,10,10,0.10);
        --shadow-lg:   0 12px 40px rgba(10,10,10,0.14);
        --r-sm:  8px;
        --r-md:  14px;
        --r-lg:  20px;
        --r-xl:  28px;
        font-family: 'DM Sans', sans-serif;
    }

    /* bagian tag */
    .tag-suggestions {
    position: absolute;
    background: #1f2937;
    color: white;
    border-radius: 8px;
    margin-top: 5px;
    width: 100%;
    max-height: 150px;
    overflow-y: auto;
    z-index: 999;
    }

    .tag-item {
        padding: 8px 12px;
        cursor: pointer;
    }

    .tag-item:hover {
        background: #374151;
    }
    /* ── Override layout ── */
    .container-fluid { padding: 0 !important; max-width: 100% !important; }
    .body-wrapper    { margin-top: 0 !important; }

    /* ===================== PAGE ===================== */
    .up-page {
        background: var(--cream);
        min-height: calc(100vh - 64px);
        padding: 36px 0 80px;
    }

    .up-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
    }

    /* ── Page heading ── */
    .up-heading {
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .up-heading-icon {
        width: 48px; height: 48px;
        background: var(--black);
        border-radius: var(--r-md);
        display: grid; place-items: center;
        flex-shrink: 0;
    }

    .up-heading h1 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        font-weight: 400;
        color: var(--black);
        line-height: 1.2;
        margin-bottom: 3px;
    }

    .up-heading p {
        font-size: 13.5px;
        color: var(--muted);
    }

    /* ===================== CARD ===================== */
    .up-card {
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        position: relative;
    }

    .up-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), #e07a5f, var(--accent));
    }

    .up-card-body { padding: 40px 44px; }

    /* ===================== ALERTS ===================== */
    .up-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 18px;
        border-radius: var(--r-md);
        margin-bottom: 24px;
        font-size: 13.5px;
        font-weight: 500;
        animation: alertIn .3s ease;
    }

    @keyframes alertIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .up-alert.success {
        background: var(--green-soft);
        color: var(--green);
        border-left: 3px solid var(--green);
    }

    .up-alert.error {
        background: var(--red-soft);
        color: var(--red);
        border-left: 3px solid var(--red);
    }

    .up-alert-icon { flex-shrink: 0; margin-top: 1px; }

    .up-alert-close {
        margin-left: auto;
        background: none; border: none;
        font-size: 16px; cursor: pointer;
        opacity: .6; transition: opacity .2s;
        color: inherit; padding: 0;
        flex-shrink: 0;
    }

    .up-alert-close:hover { opacity: 1; }

    .up-alert ul { margin: 6px 0 0 16px; }
    .up-alert ul li { margin-bottom: 3px; }

    /* ===================== SECTION LABEL ===================== */
    .up-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .up-label .up-badge {
        background: var(--cream);
        color: var(--muted);
        border: 1px solid var(--warm-gray);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 500;
    }

    .up-required { color: var(--accent); margin-left: 2px; }

    /* ===================== DROP ZONE ===================== */
    .up-dropzone {
        border: 2px dashed var(--warm-gray);
        border-radius: var(--r-lg);
        padding: 52px 32px;
        text-align: center;
        background: var(--cream);
        cursor: pointer;
        transition: border-color .2s, background .2s, transform .2s;
        position: relative;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .up-dropzone:hover {
        border-color: var(--accent);
        background: var(--accent-soft);
    }

    .up-dropzone.dragover {
        border-color: var(--accent);
        background: var(--accent-soft);
        transform: scale(1.01);
    }

    .up-dropzone-icon {
        width: 56px; height: 56px;
        background: var(--white);
        border-radius: var(--r-md);
        display: grid; place-items: center;
        margin: 0 auto 18px;
        box-shadow: var(--shadow-sm);
    }

    .up-dropzone h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 6px;
    }

    .up-dropzone p {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 20px;
    }

    .up-choose-btn {
        height: 36px; padding: 0 20px;
        background: var(--black); color: var(--white);
        border: none; border-radius: 36px;
        font-size: 13.5px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; transition: background .2s, transform .15s;
        display: inline-flex; align-items: center; gap: 7px;
    }

    .up-choose-btn:hover { background: #222; transform: translateY(-1px); }

    /* ===================== PHOTO PREVIEW GRID ===================== */
    .up-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .up-preview-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: var(--r-md);
        overflow: hidden;
        background: var(--warm-gray);
        box-shadow: var(--shadow-sm);
        transition: transform .3s, box-shadow .3s;
        animation: previewIn .4s ease both;
    }

    @keyframes previewIn {
        from { opacity: 0; transform: scale(.88); }
        to   { opacity: 1; transform: scale(1); }
    }

    .up-preview-item:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

    .up-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .up-preview-num {
        position: absolute; top: 8px; left: 8px;
        background: rgba(10,10,10,.65);
        color: var(--white); font-size: 11px; font-weight: 600;
        padding: 3px 8px; border-radius: 12px;
        backdrop-filter: blur(4px);
    }

    .up-preview-remove {
        position: absolute; top: 8px; right: 8px;
        width: 28px; height: 28px; border-radius: 50%;
        background: rgba(192,57,43,.9);
        color: var(--white); border: none; cursor: pointer;
        display: grid; place-items: center;
        font-size: 14px; line-height: 1;
        transition: transform .2s, background .2s;
        backdrop-filter: blur(4px);
    }

    .up-preview-remove:hover { transform: scale(1.15) rotate(90deg); background: var(--red); }

    /* ===================== FORM FIELDS ===================== */
    .up-group {
        margin-bottom: 24px; 
        position: relative;
    }

    .up-field {
        width: 100%;
        border: 1.5px solid var(--warm-gray);
        border-radius: var(--r-md);
        padding: 12px 16px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        background: var(--cream);
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }

    .up-field:focus {
        background: var(--white);
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(200,83,58,.12);
    }

    .up-field.is-invalid { border-color: var(--red); background: var(--red-soft); }
    .up-field::placeholder { color: var(--muted); }

    .up-invalid { font-size: 12.5px; color: var(--red); margin-top: 6px; display: block; font-weight: 500; }

    textarea.up-field { resize: vertical; min-height: 110px; line-height: 1.65; }

    .up-char-counter {
        text-align: right; font-size: 12px;
        color: var(--muted); margin-top: 5px;
    }
    .up-char-counter.warn  { color: #d97706; }
    .up-char-counter.limit { color: var(--red); }

    /* Select arrow */
    select.up-field {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23888077' d='M6 8L0 0h12z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
        appearance: none; cursor: pointer;
    }

    select.up-field:disabled {
        opacity: .5; cursor: not-allowed;
        background-color: var(--warm-gray);
    }

    /* Two-col row */
    .up-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 560px) { .up-row { grid-template-columns: 1fr; } }

    /* ===================== ACTION BUTTONS ===================== */
    .up-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-top: 36px;
        padding-top: 28px;
        border-top: 1px solid var(--warm-gray);
    }

    .up-btn {
        height: 42px; padding: 0 28px;
        border-radius: 42px;
        font-size: 14px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; border: none;
        display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none; transition: all .2s;
        white-space: nowrap;
    }

    .up-btn-back {
        background: var(--cream);
        color: var(--black);
        border: 1.5px solid var(--warm-gray);
    }
    .up-btn-back:hover { background: var(--warm-gray); color: var(--black); }

    .up-btn-submit {
        background: var(--black);
        color: var(--white);
        min-width: 160px;
        justify-content: center;
    }
    .up-btn-submit:hover { background: #222; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(10,10,10,.2); }
    .up-btn-submit:disabled { opacity: .45; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

    .up-btn-submit.loading { position: relative; color: transparent; }
    .up-btn-submit.loading::after {
        content: '';
        position: absolute; width: 18px; height: 18px;
        top: 50%; left: 50%;
        margin: -9px 0 0 -9px;
        border: 2px solid rgba(255,255,255,.3);
        border-top-color: var(--white);
        border-radius: 50%;
        animation: spin .8s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* ===================== PROGRESS MODAL ===================== */
    .up-scan-modal {
        display: none;
        position: fixed; inset: 0;
        background: rgba(10,10,10,.7);
        backdrop-filter: blur(8px);
        z-index: 9999;
        align-items: center; justify-content: center;
        animation: fadeOverlay .3s ease;
    }

    @keyframes fadeOverlay { from { opacity: 0; } to { opacity: 1; } }

    .up-scan-panel {
        background: var(--white);
        border-radius: var(--r-xl);
        padding: 36px;
        max-width: 520px; width: 90%;
        box-shadow: var(--shadow-lg);
        animation: panelUp .35s cubic-bezier(.4,0,.2,1);
    }

    @keyframes panelUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .up-scan-header { text-align: center; margin-bottom: 28px; }

    .up-scan-icon {
        width: 64px; height: 64px;
        background: var(--cream); border-radius: var(--r-lg);
        display: grid; place-items: center;
        margin: 0 auto 16px;
    }

    .up-scan-header h3 {
        font-size: 20px; font-weight: 600;
        color: var(--black); margin-bottom: 6px;
    }

    .up-scan-header p { font-size: 13.5px; color: var(--muted); }

    /* Progress bar */
    .up-progress-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px; font-weight: 600; color: var(--black);
    }

    .up-progress-pct { color: var(--accent); }

    .up-progress-track {
        background: var(--warm-gray);
        border-radius: 8px; height: 8px; overflow: hidden;
        margin-bottom: 20px;
    }

    .up-progress-fill {
        height: 100%; width: 0%;
        background: var(--black);
        border-radius: 8px;
        transition: width .4s cubic-bezier(.4,0,.2,1);
        position: relative; overflow: hidden;
    }

    .up-progress-fill::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent);
        animation: shimmer 1.4s infinite;
    }

    @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

    /* File list */
    .up-file-list {
        max-height: 220px; overflow-y: auto;
        margin-bottom: 20px;
    }

    .up-file-list::-webkit-scrollbar { width: 4px; }
    .up-file-list::-webkit-scrollbar-thumb { background: var(--warm-gray); border-radius: 10px; }

    .up-file-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        background: var(--cream); border-radius: var(--r-sm);
        margin-bottom: 8px;
        border-left: 3px solid var(--warm-gray);
        transition: border-color .2s, background .2s;
        animation: fileIn .3s ease;
    }

    @keyframes fileIn { from { opacity: 0; transform: translateX(-12px); } to { opacity: 1; transform: translateX(0); } }

    .up-file-item.safe   { border-color: var(--green); background: var(--green-soft); }
    .up-file-item.unsafe { border-color: var(--red);   background: var(--red-soft); }

    .up-file-status-icon { font-size: 18px; flex-shrink: 0; }

    .up-file-info { flex: 1; min-width: 0; }
    .up-file-name { font-size: 13px; font-weight: 600; color: var(--black); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .up-file-status-text { font-size: 11.5px; color: var(--muted); margin-top: 2px; }
    .up-file-item.safe   .up-file-status-text { color: var(--green); font-weight: 600; }
    .up-file-item.unsafe .up-file-status-text { color: var(--red);   font-weight: 600; }

    .up-cancel-btn {
        width: 100%; height: 40px;
        background: var(--cream);
        color: var(--red);
        border: 1.5px solid #f5c0b8;
        border-radius: var(--r-md);
        font-size: 13.5px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; transition: background .2s, color .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .up-cancel-btn:hover { background: var(--red); color: var(--white); border-color: var(--red); }

    /* ===================== CONFIRM MODAL ===================== */
    .up-confirm-modal {
        display: none;
        position: fixed; inset: 0;
        background: rgba(10,10,10,.8);
        backdrop-filter: blur(10px);
        z-index: 10000;
        align-items: center; justify-content: center;
    }

    .up-confirm-panel {
        background: var(--white);
        border-radius: var(--r-xl);
        padding: 36px 32px;
        max-width: 420px; width: 90%;
        box-shadow: var(--shadow-lg);
        text-align: center;
        animation: panelUp .35s cubic-bezier(.4,0,.2,1);
    }

    .up-confirm-icon {
        width: 56px; height: 56px;
        background: var(--red-soft);
        border-radius: 50%;
        display: grid; place-items: center;
        margin: 0 auto 18px;
    }

    .up-confirm-panel h3 { font-size: 19px; font-weight: 600; color: var(--black); margin-bottom: 10px; }
    .up-confirm-panel p  { font-size: 13.5px; color: var(--muted); line-height: 1.6; margin-bottom: 26px; }

    .up-confirm-btns { display: flex; gap: 10px; }

    .up-confirm-no {
        flex: 1; height: 40px;
        background: var(--cream); color: var(--black);
        border: 1.5px solid var(--warm-gray);
        border-radius: var(--r-md); font-size: 14px; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: background .2s;
    }
    .up-confirm-no:hover { background: var(--warm-gray); }

    .up-confirm-yes {
        flex: 1; height: 40px;
        background: var(--red); color: var(--white);
        border: none; border-radius: var(--r-md);
        font-size: 14px; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        transition: background .2s;
    }
    .up-confirm-yes:hover { background: #a93226; }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 600px) {
        .up-inner { padding: 0 16px; }
        .up-card-body { padding: 28px 22px; }
        .up-actions { flex-direction: column-reverse; }
        .up-btn { width: 100%; justify-content: center; }
        .up-preview-grid { grid-template-columns: repeat(3,1fr); gap: 8px; }
    }
</style>

<div class="up-page">
    <div class="up-inner">

        {{-- ── Heading ── --}}
        <div class="up-heading">
            <div class="up-heading-icon">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <rect x="2" y="4" width="18" height="14" rx="2.5" stroke="white" stroke-width="1.7"/>
                    <circle cx="11" cy="11" r="3.5" stroke="white" stroke-width="1.7"/>
                    <path d="M8 4l1.5-2h3L14 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="17" cy="7" r="1" fill="white"/>
                </svg>
            </div>
            <div>
                <h1>Buat Postingan</h1>
                <p>Bagikan momen terbaik Anda dengan komunitas Aperture</p>
            </div>
        </div>

        {{-- ── Card ── --}}
        <div class="up-card">
            <div class="up-card-body">

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="up-alert success">
                        <span class="up-alert-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M5 8l2.5 2.5L11 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span><strong>Berhasil!</strong> {{ session('success') }}</span>
                        <button class="up-alert-close" onclick="this.closest('.up-alert').remove()">×</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="up-alert error">
                        <span class="up-alert-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span><strong>Gagal!</strong> {{ session('error') }}</span>
                        <button class="up-alert-close" onclick="this.closest('.up-alert').remove()">×</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="up-alert error">
                        <span class="up-alert-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M8 5v4M8 11v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <div>
                            <strong>Terjadi kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button class="up-alert-close" onclick="this.closest('.up-alert').remove()">×</button>
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ route('user.postingan.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    {{-- ── Drop Zone ── --}}
                    <div class="up-group">
                        <div class="up-label">
                            Pilih Foto
                            <span class="up-badge">Maks 8 foto</span>
                        </div>

                        <div class="up-dropzone" id="dropZone" onclick="document.getElementById('photoInput').click()">
                            <div class="up-dropzone-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="5" width="20" height="16" rx="2.5" stroke="#888077" stroke-width="1.7"/>
                                    <circle cx="12" cy="13" r="4" stroke="#888077" stroke-width="1.7"/>
                                    <path d="M9 5l1.5-2h3L15 5" stroke="#888077" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3>Seret & lepas foto di sini</h3>
                            <p>Mendukung JPG, JPEG, PNG, GIF · Maks 8 foto</p>
                            <button type="button" class="up-choose-btn">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <path d="M6.5 2v9M2 6.5h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Pilih dari Perangkat
                            </button>
                            <input type="file" name="photos[]" id="photoInput"
                                   accept="image/*" multiple style="display:none"
                                   onchange="handlePhotoInput(event)">
                        </div>

                        <div class="up-preview-grid" id="photoPreviewGrid"></div>
                    </div>

                    <!-- {{-- ── Caption ── --}} -->
                    <div class="up-group">
                        <label class="up-label" for="captionInput">Caption</label>
                        <textarea name="caption" id="captionInput" rows="4"
                                class="up-field @error('caption') is-invalid @enderror"
                                placeholder="Ceritakan tentang foto Anda… Gunakan # untuk menambahkan tag"
                                maxlength="500">{{ old('caption') }}</textarea>
                        <div id="tagSuggestions" class="tag-suggestions"></div>
                        <div class="up-char-counter" id="charCounter">0 / 500 karakter</div>
                        @error('caption')
                            <span class="up-invalid">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ── Category & Type ── --}}
                    <div class="up-row">
                        <div class="up-group">
                            <label class="up-label" for="categorySelect">
                                Kategori <span class="up-required">*</span>
                            </label>
                            <select id="categorySelect" name="category_id"
                                    class="up-field @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih kategori…</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="up-invalid">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="up-group">
                            <label class="up-label" for="typeCategorySelect">
                                Tipe Foto <span class="up-required">*</span>
                            </label>
                            <select id="typeCategorySelect" name="type_category_id"
                                    class="up-field @error('type_category_id') is-invalid @enderror"
                                    required disabled>
                                <option value="">Pilih kategori dulu</option>
                                @foreach ($typeCategories as $typeCategory)
                                    <option value="{{ $typeCategory->id }}"
                                            data-category-id="{{ $typeCategory->category_id ?? '' }}"
                                            {{ old('type_category_id') == $typeCategory->id ? 'selected' : '' }}>
                                        {{ $typeCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_category_id')
                                <span class="up-invalid">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- {{-- ── Actions ── --}} -->
                    <div class="up-actions">
                        <a href="{{ route('user.profile') }}" class="up-btn up-btn-back">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="up-btn up-btn-submit" id="submitBtn">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M2 12l3-3 3 3 4-8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Upload Postingan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- {{-- ── Scan Progress Modal ── --}} -->
<div id="scanModal" class="up-scan-modal">
    <div class="up-scan-panel">
        <div class="up-scan-header">
            <div class="up-scan-icon">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                    <circle cx="14" cy="14" r="11" stroke="#888077" stroke-width="1.8"/>
                    <path d="M9 14l3.5 3.5L19 10" stroke="#888077" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Memeriksa Foto</h3>
            <p>Memastikan foto sesuai dengan kebijakan komunitas…</p>
        </div>

        <div class="up-progress-meta">
            <span id="scanFileText">Foto 0 dari 0</span>
            <span class="up-progress-pct" id="scanPct">0%</span>
        </div>
        <div class="up-progress-track">
            <div class="up-progress-fill" id="scanBar"></div>
        </div>

        <div class="up-file-list" id="scanFileList"></div>

        <button type="button" id="cancelScanBtn" class="up-cancel-btn">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path d="M1 1l11 11M12 1L1 12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
            Batalkan Pemindaian
        </button>
    </div>
</div>

<!-- {{-- ── Confirm Cancel Modal ── --}} -->
<div id="confirmModal" class="up-confirm-modal">
    <div class="up-confirm-panel">
        <div class="up-confirm-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 9v5M12 16v.5" stroke="#c0392b" stroke-width="2" stroke-linecap="round"/>
                <path d="M10.3 3.5l-8 14A2 2 0 004 21h16a2 2 0 001.7-3.5l-8-14a2 2 0 00-3.4 0z" stroke="#c0392b" stroke-width="1.7"/>
            </svg>
        </div>
        <h3>Batalkan Upload?</h3>
        <p>Pemindaian akan dihentikan dan semua foto yang dipilih akan dihapus. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="up-confirm-btns">
            <button type="button" id="confirmNo"  class="up-confirm-no">Lanjutkan</button>
            <button type="button" id="confirmYes" class="up-confirm-yes">Ya, Batalkan</button>
        </div>
    </div>
</div>

<!-- ini digunakan untuk memuat TensorFlow.js dan NSFWJS dari CDN.
Pastikan untuk menyesuaikan versi jika diperlukan, dan pastikan koneksi internet stabil saat memuat model.
Jika Anda memiliki model NSFWJS yang dihosting secara lokal,
Anda dapat mengganti URL pada fungsi `nsfwjs.load()` dengan path ke model tersebut. -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.7.0/dist/tf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/nsfwjs@2.4.0/dist/nsfwjs.min.js"></script>
<script>
// ── NSFW Model ──────────────────────────────────────────────────────
let model = null, modelReady = false, scanCancelled = false;
let selectedFiles = [];

(async () => {
    try {
        model = await nsfwjs.load('/nsfw-model/', { size: 224 });
        modelReady = true;
        console.log('✅ NSFW model loaded');
    } catch (e) {
        console.error('❌ Model gagal load', e);
    }
})();

function showScanModal()  { document.getElementById('scanModal').style.display = 'flex'; scanCancelled = false; }
function hideScanModal()  { document.getElementById('scanModal').style.display = 'none'; }

function updateScan(cur, total, name, state = 'scanning') {
    const pct = Math.round((cur / total) * 100);
    document.getElementById('scanBar').style.width = pct + '%';
    document.getElementById('scanPct').textContent  = pct + '%';
    document.getElementById('scanFileText').textContent = `Foto ${cur} dari ${total}`;

    const list = document.getElementById('scanFileList');
    let item = document.getElementById(`sf-${cur}`);
    if (!item) {
        item = document.createElement('div');
        item.id = `sf-${cur}`;
        item.className = 'up-file-item';
        item.innerHTML = `
            <span class="up-file-status-icon" id="si-${cur}">⏳</span>
            <div class="up-file-info">
                <div class="up-file-name">${name}</div>
                <div class="up-file-status-text" id="st-${cur}">Memeriksa…</div>
            </div>`;
        list.appendChild(item);
    }
    if (state === 'safe') {
        item.classList.add('safe');
        document.getElementById(`si-${cur}`).textContent = '✅';
        document.getElementById(`st-${cur}`).textContent = 'Aman';
    }
    if (state === 'unsafe') {
        item.classList.add('unsafe');
        document.getElementById(`si-${cur}`).textContent = '❌';
        document.getElementById(`st-${cur}`).textContent = 'Konten tidak pantas';
    }
}

document.getElementById('cancelScanBtn').addEventListener('click', () => {
    document.getElementById('confirmModal').style.display = 'flex';
});
document.getElementById('confirmNo').addEventListener('click', () => {
    document.getElementById('confirmModal').style.display = 'none';
});
document.getElementById('confirmYes').addEventListener('click', () => {
    scanCancelled = true;
    document.getElementById('confirmModal').style.display = 'none';
    hideScanModal();
    document.getElementById('photoInput').value = '';
    selectedFiles = [];
    renderPreview();
});

async function handlePhotoInput(event) {

    if (!modelReady) {
        alert('⏳ Model masih loading, coba lagi sebentar…');
        event.target.value = '';
        return;
    }

    const files = Array.from(event.target.files);
    if (!files.length) return;

    // Reset aiScores setiap upload baru
    let aiScores = { porn: 0, hentai: 0, sexy: 0 };

    showScanModal();
    document.getElementById('scanFileList').innerHTML = '';

    // ✅ Ganti allSafe + break dengan hasUnsafe + lanjut scan semua
    let safeFiles = [];
    let hasUnsafe = false;

    for (let i = 0; i < files.length; i++) {

        if (scanCancelled) return;

        const file = files[i];
        updateScan(i + 1, files.length, file.name, 'scanning');

        try {

            const objectUrl = URL.createObjectURL(file);

            const img = await new Promise((res, rej) => {
                const el = new Image();
                el.crossOrigin = 'anonymous';
                el.onload = () => res(el);
                el.onerror = rej;
                el.src = objectUrl;
            });

            const canvas = document.createElement('canvas');
            canvas.width  = 224;
            canvas.height = 224;
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, 224, 224);
            ctx.drawImage(img, 0, 0, 224, 224);

            URL.revokeObjectURL(objectUrl);

            const preds = await model.classify(canvas);

            const porn   = preds.find(p => p.className === 'Porn')?.probability   || 0;
            const hentai = preds.find(p => p.className === 'Hentai')?.probability || 0;
            const sexy   = preds.find(p => p.className === 'Sexy')?.probability   || 0;

            const nsfwScore = porn + hentai + sexy;

            aiScores.porn   = Math.max(aiScores.porn,   porn);
            aiScores.hentai = Math.max(aiScores.hentai, hentai);
            aiScores.sexy   = Math.max(aiScores.sexy,   sexy);

            console.log("=== AI SCAN RESULT ===");
            console.log("File:",       file.name);
            console.log("Porn:",       porn);
            console.log("Hentai:",     hentai);
            console.log("Sexy:",       sexy);
            console.log("NSFW Score:", nsfwScore);
            console.log("======================");

            const unsafe =
                porn      > 0.35 ||
                hentai    > 0.25 ||
                sexy      > 0.25 ||
                nsfwScore > 0.50;

            if (unsafe) {
                // ✅ Tandai unsafe tapi lanjut scan foto berikutnya
                updateScan(i + 1, files.length, file.name, 'unsafe');
                hasUnsafe = true;
                await new Promise(r => setTimeout(r, 800));

            } else {
                updateScan(i + 1, files.length, file.name, 'safe');
                safeFiles.push(file);
            }

        } catch (e) {

            console.error(e);
            updateScan(i + 1, files.length, file.name, 'unsafe');
            hasUnsafe = true;

        }

        await new Promise(r => setTimeout(r, 300));
    }

    await new Promise(r => setTimeout(r, 900));

    hideScanModal();

    // ✅ Kalau ada yang unsafe, kasih tahu tapi tetap upload yang aman
    if (hasUnsafe) {
        alert(`⚠️ ${files.length - safeFiles.length} foto ditolak karena konten tidak pantas. ${safeFiles.length} foto aman tetap diupload.`);
    }

    // ✅ Kalau semua foto tidak aman
    if (safeFiles.length === 0) {
        document.getElementById('photoInput').value = '';
        selectedFiles = [];
        renderPreview();
        return;
    }

    // ✅ Hanya foto aman yang diupload
    selectedFiles = safeFiles;
    renderPreview();
}

// untuk tag
const textarea = document.getElementById('captionInput');
const suggestionBox = document.getElementById('tagSuggestions');

let timeout = null;

// 🔥 function utama
async function handleTagSearch() {
    const text = textarea.value;
    const cursorPos = textarea.selectionStart;

    // ambil hashtag terakhir
    const match = text.substring(0, cursorPos).match(/#(\w*)$/);

    if (!match) {
        suggestionBox.innerHTML = '';
        return;
    }

    const keyword = match[1] || '';

    try {
        const res = await fetch(`/tags/search?q=${keyword}`);
        const tags = await res.json();

        if (!tags.length) {
            suggestionBox.innerHTML = `<div class="tag-item">Tidak ada tag</div>`;
            return;
        }

        suggestionBox.innerHTML = tags.map(tag => `
            <div class="tag-item" data-tag="${tag.name}">
                #${tag.name} (${tag.posts_count}x)
            </div>
        `).join('');

        // klik tag
        document.querySelectorAll('.tag-item').forEach(item => {
            item.addEventListener('click', () => {
                const tag = item.dataset.tag;

                const newText = text.replace(/#(\w*)$/, '#' + tag + ' ');
                textarea.value = newText;

                suggestionBox.innerHTML = '';
                textarea.focus();
            });
        });

    } catch (err) {
        console.error('Tag search error:', err);
    }
}

// 🔥 debounce biar gak spam
textarea.addEventListener('keyup', () => {
    clearTimeout(timeout);
    timeout = setTimeout(handleTagSearch, 300);
});

// 🔥 klik luar = tutup dropdown
document.addEventListener('click', function(e) {
    if (!e.target.closest('.up-group')) {
        suggestionBox.innerHTML = '';
    }
});

// ── Drag & drop ─────────────────────────────────────────────────────
const dropZone = document.getElementById('dropZone');
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('dragover'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
    if (!files.length) return;
    const dt = new DataTransfer();
    files.forEach(f => dt.items.add(f));
    const input = document.getElementById('photoInput');
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
});

// ── Preview ─────────────────────────────────────────────────────────
function renderPreview() {
    const grid = document.getElementById('photoPreviewGrid');
    grid.innerHTML = '';
    selectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'up-preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="">
                <div class="up-preview-num">${i + 1}</div>
                <button type="button" class="up-preview-remove" onclick="removePhoto(${i})">×</button>`;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    syncInput();
}

function removePhoto(i) { selectedFiles.splice(i, 1); renderPreview(); }

function syncInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('photoInput').files = dt.files;
}

// ── Caption counter ──────────────────────────────────────────────────
document.getElementById('captionInput')?.addEventListener('input', function () {
    const len = this.value.length;
    const el  = document.getElementById('charCounter');
    el.textContent = `${len} / 500 karakter`;
    el.className = 'up-char-counter' + (len > 480 ? ' limit' : len > 400 ? ' warn' : '');
});

// ── Category → type filter ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const catSel  = document.getElementById('categorySelect');
    const typeSel = document.getElementById('typeCategorySelect');
    if (!catSel || !typeSel) return;

    const placeholder = typeSel.querySelector('option[value=""]');
    const typeOpts    = Array.from(typeSel.querySelectorAll('option')).filter(o => o.value !== '');

    const oldCat  = @json(old('category_id'));
    const oldType = @json(old('type_category_id'));

    function filter() {
        const catId = String(catSel.value || '');
        let any = false;
        typeOpts.forEach(opt => {
            const match = catId !== '' && String(opt.dataset.categoryId || '') === catId;
            opt.hidden = !match; opt.disabled = !match;
            if (match) any = true;
        });
        if (placeholder) {
            placeholder.hidden = false; placeholder.disabled = false;
            placeholder.textContent = catId ? 'Pilih tipe foto…' : 'Pilih kategori dulu';
        }
        typeSel.disabled = !any;
        const cur = typeSel.querySelector(`option[value="${typeSel.value}"]`);
        if (!cur || cur.disabled) typeSel.value = '';
    }

    if (oldCat) catSel.value = oldCat;
    filter();
    if (oldType) {
        const o = typeSel.querySelector(`option[value="${oldType}"]`);
        if (o && !o.disabled) typeSel.value = oldType;
    }

    catSel.addEventListener('change', () => { filter(); typeSel.value = ''; });
});

// ── Form submit ──────────────────────────────────────────────────────
document.getElementById('uploadForm')?.addEventListener('submit', function (e) {
    if (selectedFiles.length === 0) {
        e.preventDefault();
        alert('⚠️ Minimal 1 foto harus dipilih.');
        return;
    }
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.classList.add('loading');
});
</script>
@endsection