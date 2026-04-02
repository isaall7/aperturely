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

    /* ── Tag suggestions ── */
    .tag-suggestions {
        position: absolute;
        background: #1f2937;
        color: white;
        border-radius: var(--r-sm);
        margin-top: 5px;
        width: 100%;
        max-height: 150px;
        overflow-y: auto;
        z-index: 999;
    }
    .tag-item { padding: 8px 12px; cursor: pointer; font-size: 13.5px; }
    .tag-item:hover { background: #374151; }

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

    .up-heading p { font-size: 13.5px; color: var(--muted); }

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

    .up-alert.success { background: var(--green-soft); color: var(--green); border-left: 3px solid var(--green); }
    .up-alert.error   { background: var(--red-soft);   color: var(--red);   border-left: 3px solid var(--red); }

    .up-alert-icon { flex-shrink: 0; margin-top: 1px; }

    .up-alert-close {
        margin-left: auto;
        background: none; border: none;
        font-size: 16px; cursor: pointer;
        opacity: .6; transition: opacity .2s;
        color: inherit; padding: 0; flex-shrink: 0;
    }
    .up-alert-close:hover { opacity: 1; }
    .up-alert ul { margin: 6px 0 0 16px; }
    .up-alert ul li { margin-bottom: 3px; }

    /* ===================== LABELS ===================== */
    .up-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .up-badge {
        background: var(--cream);
        color: var(--muted);
        border: 1px solid var(--warm-gray);
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 500;
    }

    .up-required { color: var(--accent); margin-left: 2px; }

    /* ===================== EXISTING PHOTOS ===================== */
    .up-existing-photos {
        margin-bottom: 24px;
    }

    .up-existing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        margin-top: 12px;
    }

    .up-existing-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: var(--r-md);
        overflow: hidden;
        background: var(--warm-gray);
        border: 2px solid var(--warm-gray);
        transition: border-color .2s;
    }

    .up-existing-item img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
    }

    .up-existing-item .up-existing-label {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: rgba(10,10,10,.55);
        color: var(--white);
        font-size: 10px;
        font-weight: 600;
        text-align: center;
        padding: 4px;
        letter-spacing: .3px;
    }

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

    /* Current tags display */
    .up-tags-display {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 10px;
    }

    .up-tag-pill {
        background: var(--cream);
        border: 1.5px solid var(--warm-gray);
        color: var(--muted);
        font-size: 12.5px;
        font-weight: 500;
        padding: 3px 12px;
        border-radius: 20px;
    }

    /* Info note */
    .up-info-note {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 11px 14px;
        background: var(--cream);
        border: 1.5px solid var(--warm-gray);
        border-radius: var(--r-md);
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 20px;
    }

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
        background: var(--cream); color: var(--black);
        border: 1.5px solid var(--warm-gray);
    }
    .up-btn-back:hover { background: var(--warm-gray); color: var(--black); }

    .up-btn-submit {
        background: var(--black); color: var(--white);
        min-width: 160px; justify-content: center;
    }
    .up-btn-submit:hover { background: #222; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(10,10,10,.2); }
    .up-btn-submit:disabled { opacity: .45; cursor: not-allowed; transform: none !important; }

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

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 600px) {
        .up-inner { padding: 0 16px; }
        .up-card-body { padding: 28px 22px; }
        .up-actions { flex-direction: column-reverse; }
        .up-btn { width: 100%; justify-content: center; }
        .up-existing-grid { grid-template-columns: repeat(3,1fr); gap: 8px; }
    }
</style>

<div class="up-page">
    <div class="up-inner">

        {{-- ── Heading ── --}}
        <div class="up-heading">
            <div class="up-heading-icon">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M15 3l4 4-10 10H5v-4L15 3z" stroke="white" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 5l4 4" stroke="white" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h1>Edit Postingan</h1>
                <p>Perbarui caption, kategori, dan tipe foto postinganmu</p>
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
                <form action="{{ route('user.postingan.update', $post->id) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    {{-- ── Info note ── --}}
                    <div class="up-info-note">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <circle cx="7.5" cy="7.5" r="6.5" stroke="currentColor" stroke-width="1.3"/>
                            <path d="M7.5 5v4M7.5 11v.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>
                        </svg>
                        Edit hanya tersedia untuk caption, kategori, dan tipe foto. Foto tidak dapat diubah.
                    </div>

                    {{-- ── Existing Photos (read-only preview) ── --}}
                    @if($post->photos && $post->photos->count() > 0)
                        <div class="up-existing-photos">
                            <div class="up-label">
                                Foto Postingan
                                <span class="up-badge">{{ $post->photos->count() }} foto</span>
                            </div>
                            <div class="up-existing-grid">
                                @foreach($post->photos as $i => $photo)
                                    <div class="up-existing-item">
                                        <img src="{{ asset('storage/'.$photo->photo) }}" alt="Foto {{ $i+1 }}">
                                        <div class="up-existing-label">Foto {{ $i+1 }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- ── Caption ── --}}
                    <div class="up-group">
                        <label class="up-label" for="captionInput">Caption</label>
                        <textarea name="caption" id="captionInput" rows="5"
                                  class="up-field @error('caption') is-invalid @enderror"
                                  placeholder="Ceritakan tentang foto Anda… Gunakan # untuk menambahkan tag"
                                  maxlength="500">{{ old('caption', $post->caption) }}</textarea>
                        <div id="tagSuggestions" class="tag-suggestions"></div>
                        <div class="up-char-counter" id="charCounter">{{ strlen($post->caption ?? '') }} / 500 karakter</div>
                        @error('caption')
                            <span class="up-invalid">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ── Current Tags ── --}}
                    @if($post->tags && $post->tags->count() > 0)
                        <div class="up-group" style="margin-top: -16px;">
                            <div class="up-label" style="font-size:12.5px;color:var(--muted)">Tag saat ini</div>
                            <div class="up-tags-display">
                                @foreach($post->tags as $tag)
                                    <span class="up-tag-pill">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

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
                                    <option value="{{ $category->id }}"
                                        {{ (old('category_id', $post->category_id) == $category->id) ? 'selected' : '' }}>
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
                                    class="up-field @error('type_category_id') is-invalid @enderror" required>
                                <option value="">Pilih tipe foto…</option>
                                @foreach ($typeCategories as $typeCategory)
                                    <option value="{{ $typeCategory->id }}"
                                            data-category-id="{{ $typeCategory->category_id ?? '' }}"
                                            {{ (old('type_category_id', $post->type_category_id) == $typeCategory->id) ? 'selected' : '' }}>
                                        {{ $typeCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_category_id')
                                <span class="up-invalid">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- ── Actions ── --}}
                    <div class="up-actions">
                        <a href="{{ route('user.dashboard') }}" class="up-btn up-btn-back">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M9 2L4 7l5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="up-btn up-btn-submit" id="submitBtn">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M2 7l3 3 7-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
// ── Tag suggestions ──────────────────────────────────────────────────
const textarea    = document.getElementById('captionInput');
const suggestionBox = document.getElementById('tagSuggestions');
let timeout = null;

async function handleTagSearch() {
    const text      = textarea.value;
    const cursorPos = textarea.selectionStart;
    const match     = text.substring(0, cursorPos).match(/#(\w*)$/);

    if (!match) { suggestionBox.innerHTML = ''; return; }

    const keyword = match[1] || '';

    try {
        const res  = await fetch(`/tags/search?q=${keyword}`);
        const tags = await res.json();

        if (!tags.length) {
            suggestionBox.innerHTML = `<div class="tag-item">Tidak ada tag</div>`;
            return;
        }

        suggestionBox.innerHTML = tags.map(tag =>
            `<div class="tag-item" data-tag="${tag.name}">#${tag.name} (${tag.posts_count}x)</div>`
        ).join('');

        document.querySelectorAll('.tag-item').forEach(item => {
            item.addEventListener('click', () => {
                textarea.value = text.replace(/#(\w*)$/, '#' + item.dataset.tag + ' ');
                suggestionBox.innerHTML = '';
                textarea.focus();
            });
        });
    } catch (err) {
        console.error('Tag search error:', err);
    }
}

textarea.addEventListener('keyup', () => {
    clearTimeout(timeout);
    timeout = setTimeout(handleTagSearch, 300);
});

document.addEventListener('click', e => {
    if (!e.target.closest('.up-group')) suggestionBox.innerHTML = '';
});

// ── Caption counter ──────────────────────────────────────────────────
textarea.addEventListener('input', function () {
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

    const typeOpts = Array.from(typeSel.querySelectorAll('option')).filter(o => o.value !== '');

    // Save current selected type before filter
    const currentTypeId = String(typeSel.value || '');

    function filter(restoreType) {
        const catId = String(catSel.value || '');
        typeOpts.forEach(opt => {
            const match = catId !== '' && String(opt.dataset.categoryId || '') === catId;
            opt.hidden   = !match;
            opt.disabled = !match;
        });
        typeSel.disabled = catId === '' || typeOpts.every(o => o.disabled);

        if (restoreType) {
            const opt = typeSel.querySelector(`option[value="${restoreType}"]`);
            if (opt && !opt.disabled) typeSel.value = restoreType;
            else typeSel.value = '';
        } else {
            const cur = typeSel.querySelector(`option[value="${typeSel.value}"]`);
            if (!cur || cur.disabled) typeSel.value = '';
        }
    }

    // Initial filter — restore existing type
    filter(currentTypeId);

    catSel.addEventListener('change', () => filter(null));
});

// ── Form submit ──────────────────────────────────────────────────────
document.getElementById('editForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.classList.add('loading');
});
</script>

@endsection