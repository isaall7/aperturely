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
    --shadow-sm:   0 1px 3px rgba(10,10,10,0.07);
    --shadow-md:   0 4px 16px rgba(10,10,10,0.10);
    --shadow-lg:   0 12px 40px rgba(10,10,10,0.14);
    --r-sm:  8px;
    --r-md:  14px;
    --r-lg:  20px;
    --r-xl:  28px;
    font-family: 'DM Sans', sans-serif;
}

/* ── Override layout ── */
.container-fluid { padding: 0 !important; max-width: 100% !important; }
.body-wrapper    { margin-top: 0 !important; }

/* ===================== PAGE ===================== */
.ep-page {
    background: var(--cream);
    min-height: calc(100vh - 64px);
    padding: 40px 24px 80px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
}

/* ===================== CARD ===================== */
.ep-card {
    background: var(--white);
    border-radius: var(--r-xl);
    box-shadow: var(--shadow-lg);
    width: 100%;
    max-width: 520px;
    position: relative;
    overflow: hidden;
}

.ep-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--accent), #e07a5f, var(--accent));
}

.ep-card-body { padding: 40px 44px 36px; }

/* ── Heading ── */
.ep-heading {
    text-align: center;
    margin-bottom: 32px;
}

.ep-heading h1 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 400;
    color: var(--black);
    margin-bottom: 6px;
}

.ep-heading p {
    font-size: 13.5px;
    color: var(--muted);
}

/* ── Alert ── */
.ep-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--r-md);
    margin-bottom: 24px;
    font-size: 13.5px;
    font-weight: 500;
    animation: alertIn .3s ease;
}

@keyframes alertIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

.ep-alert.success {
    background: var(--green-soft);
    color: var(--green);
    border-left: 3px solid var(--green);
}

/* ── Avatar ── */
.ep-avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 32px;
}

.ep-avatar-wrap {
    position: relative;
    width: 96px;
    height: 96px;
    margin-bottom: 12px;
}

.ep-avatar-img {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--white);
    box-shadow: var(--shadow-md);
    display: block;
    transition: opacity .2s;
}

.ep-avatar-wrap:hover .ep-avatar-img { opacity: .85; }

.ep-avatar-btn {
    position: absolute;
    bottom: 0; right: 0;
    width: 30px; height: 30px;
    background: var(--black);
    border-radius: 50%;
    display: grid; place-items: center;
    cursor: pointer;
    transition: background .2s, transform .15s;
    border: 2.5px solid var(--white);
}

.ep-avatar-btn:hover {
    background: #333;
    transform: scale(1.1);
}

.ep-avatar-hint {
    font-size: 12px;
    color: var(--muted);
}

.ep-avatar-hint span {
    color: var(--accent);
    font-weight: 600;
    cursor: pointer;
}

.ep-avatar-hint span:hover { color: var(--accent-h); }

/* ── Form ── */
.ep-group { margin-bottom: 22px; }

.ep-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--black);
    margin-bottom: 7px;
}

.ep-field {
    width: 100%;
    border: 1.5px solid var(--warm-gray);
    border-radius: var(--r-md);
    padding: 11px 16px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    color: var(--black);
    background: var(--cream);
    outline: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
}

.ep-field:focus {
    background: var(--white);
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(200,83,58,.12);
}

.ep-field::placeholder { color: var(--muted); }

.ep-field.is-invalid {
    border-color: #c0392b;
    background: #fdf2f2;
}

textarea.ep-field {
    resize: vertical;
    min-height: 110px;
    line-height: 1.65;
}

.ep-invalid {
    font-size: 12px;
    color: #c0392b;
    font-weight: 500;
    margin-top: 5px;
    display: block;
}

/* ── Username prefix ── */
.ep-input-wrap {
    position: relative;
}

.ep-input-prefix {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    color: var(--muted);
    pointer-events: none;
    font-weight: 500;
}

.ep-field.has-prefix { padding-left: 28px; }

/* ── Char counter ── */
.ep-char {
    text-align: right;
    font-size: 12px;
    color: var(--muted);
    margin-top: 5px;
}

/* ── Divider ── */
.ep-divider {
    height: 1px;
    background: var(--warm-gray);
    margin: 28px 0;
}

/* ── Actions ── */
.ep-actions {
    display: flex;
    gap: 12px;
}

.ep-btn {
    height: 42px; padding: 0 24px;
    border-radius: 42px;
    font-size: 14px; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; border: none;
    display: inline-flex; align-items: center; gap: 8px;
    text-decoration: none; transition: all .2s;
    white-space: nowrap;
}

.ep-btn-back {
    background: var(--cream);
    color: var(--black);
    border: 1.5px solid var(--warm-gray);
}
.ep-btn-back:hover { background: var(--warm-gray); color: var(--black); }

.ep-btn-save {
    flex: 1;
    justify-content: center;
    background: var(--black);
    color: var(--white);
}
.ep-btn-save:hover {
    background: #222;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(10,10,10,.2);
}
.ep-btn-save:disabled { opacity: .45; cursor: not-allowed; transform: none !important; }

@media (max-width: 560px) {
    .ep-card-body { padding: 32px 24px 28px; }
    .ep-actions { flex-direction: column-reverse; }
    .ep-btn { width: 100%; justify-content: center; }
}
</style>

<div class="ep-page">
    <div class="ep-card">
        <div class="ep-card-body">

            {{-- Heading --}}
            <div class="ep-heading">
                <h1>Edit Profil</h1>
                <p>Perbarui foto dan informasi akunmu</p>
            </div>

            {{-- Success alert --}}
            @if(session('success'))
                <div class="ep-alert success">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="7.5" r="6.5" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M4.5 7.5l2 2 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('user.avatar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ── Avatar ── --}}
                <div class="ep-avatar-section">
                    <div class="ep-avatar-wrap">
                        <img id="avatarPreview"
                             src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('ui/images/profile/default.jpg') }}"
                             alt="Avatar"
                             class="ep-avatar-img">
                        <label for="avatarInput" class="ep-avatar-btn" title="Ganti foto">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M2 4.5A1.5 1.5 0 013.5 3h.44a1.5 1.5 0 001.22-.63l.47-.74A1.5 1.5 0 017 1h0a1.5 1.5 0 011.37.63l.47.74A1.5 1.5 0 0010.06 3h.44A1.5 1.5 0 0112 4.5v6A1.5 1.5 0 0110.5 12h-7A1.5 1.5 0 012 10.5v-6z" stroke="white" stroke-width="1.3"/>
                                <circle cx="7" cy="7.5" r="1.8" stroke="white" stroke-width="1.3"/>
                            </svg>
                        </label>
                        <input type="file" name="avatar" id="avatarInput"
                               class="d-none" accept="image/*"
                               onchange="previewAvatar(event)" style="display:none">
                    </div>
                    <div class="ep-avatar-hint">
                        <label for="avatarInput"><span>Pilih foto</span></label> · JPG, PNG maks 2MB
                    </div>
                    @error('avatar')
                        <span class="ep-invalid" style="text-align:center;margin-top:6px;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Username ── --}}
                <div class="ep-group">
                    <label class="ep-label" for="usernameInput">Username</label>
                    <div class="ep-input-wrap">
                        <span class="ep-input-prefix">@</span>
                        <input type="text" id="usernameInput" name="username"
                               class="ep-field has-prefix {{ $errors->has('username') ? 'is-invalid' : '' }}"
                               placeholder="username_kamu"
                               value="{{ old('username', auth()->user()->username) }}"
                               maxlength="30">
                    </div>
                    @error('username')
                        <span class="ep-invalid">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Bio ── --}}
                <div class="ep-group">
                    <label class="ep-label" for="bioInput">Bio</label>
                    <textarea id="bioInput" name="bio" rows="4"
                              class="ep-field {{ $errors->has('bio') ? 'is-invalid' : '' }}"
                              placeholder="Ceritakan tentang dirimu…"
                              maxlength="160">{{ old('bio', auth()->user()->profile->bio ?? '') }}</textarea>
                    <div class="ep-char" id="bioCounter">0 / 160 karakter</div>
                    @error('bio')
                        <span class="ep-invalid">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ep-divider"></div>

                {{-- ── Actions ── --}}
                <div class="ep-actions">
                    <a href="{{ route('user.profile') }}" class="ep-btn ep-btn-back">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M8 2L3 6.5 8 11" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="ep-btn ep-btn-save">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M2 7l3 3 6-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Simpan Profil
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('avatarPreview').src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// Bio char counter
const bioInput   = document.getElementById('bioInput');
const bioCounter = document.getElementById('bioCounter');

function updateBioCounter() {
    const len = bioInput.value.length;
    bioCounter.textContent = `${len} / 160 karakter`;
    bioCounter.style.color = len > 140 ? '#c8533a' : '';
}

bioInput?.addEventListener('input', updateBioCounter);
updateBioCounter();
</script>

@endsection