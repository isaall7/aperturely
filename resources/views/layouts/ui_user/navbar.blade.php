<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet">

<style>
  /* ===================== NAVBAR ===================== */
  :root {
      --ap-black:      #0a0a0a;
      --ap-white:      #ffffff;
      --ap-cream:      #f9f7f4;
      --ap-warm-gray:  #e8e4df;
      --ap-mid-gray:   #b8b3ac;
      --ap-muted:      #888077;
      --ap-accent:     #c8533a;
      --ap-accent-h:   #a83f28;
      --ap-shadow-sm:  0 1px 3px rgba(10,10,10,0.08);
      --ap-shadow-md:  0 4px 16px rgba(10,10,10,0.10);
      --ap-r-sm:       8px;
      --ap-r-md:       14px;
  }

  .ap-navbar {
      position: sticky;
      top: 0;
      z-index: 1030;
      background: rgba(249,247,244,0.88);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border-bottom: 1px solid var(--ap-warm-gray);
      height: 64px;
      padding: 0 32px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
      font-family: 'DM Sans', sans-serif;
  }

  /* ── Brand ── */
  .ap-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      flex-shrink: 0;
      transition: opacity .2s;
  }
  .ap-brand:hover { opacity: .8; }

  .ap-brand img {
      height: 34px;
      width: auto;
      display: block;
  }

  /* ── Nav icons ── */
  .ap-nav-center {
      display: flex;
      align-items: center;
      gap: 15px;
  }

  .ap-nav-link {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      text-decoration: none;
      color: var(--ap-muted);
      background: transparent;
      border: none;
      cursor: pointer;
      position: relative;
      transition: background .2s, color .2s;
      font-family: 'DM Sans', sans-serif;
  }
  .ap-nav-link:hover,
  .ap-nav-link.active {
      background: var(--ap-warm-gray);
      color: var(--ap-black);
  }
  .ap-nav-link.active { color: var(--ap-accent); }

  /* Override padding dari container-fluid di layout */
  .container-fluid {
      padding: 0 !important;
      max-width: 100% !important;
  }

  /* Sesuaikan margin-top body-wrapper dengan tinggi navbar baru */
  .body-wrapper {
      margin-top: 0 !important;
  }
  /* Active indicator dot */
  .ap-nav-link.active::after {
      content: '';
      position: absolute;
      bottom: 5px;
      left: 50%;
      transform: translateX(-50%);
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background: var(--ap-accent);
  }

  /* Tooltip */
  .ap-nav-link[title]:hover::before {
      content: attr(title);
      position: absolute;
      bottom: -30px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--ap-black);
      color: var(--ap-white);
      font-size: 11px;
      font-weight: 500;
      padding: 4px 10px;
      border-radius: 6px;
      white-space: nowrap;
      pointer-events: none;
      z-index: 100;
      font-family: 'DM Sans', sans-serif;
  }

  /* ── Notification badge ── */
  .ap-nav-link .ap-badge {
      position: absolute;
      top: 7px;
      right: 7px;
      width: 8px;
      height: 8px;
      background: var(--ap-accent);
      border-radius: 50%;
      border: 2px solid var(--ap-cream);
  }

  /* ── Divider ── */
  .ap-nav-divider {
      width: 1px;
      height: 22px;
      background: var(--ap-warm-gray);
      margin: 0 6px;
      flex-shrink: 0;
  }

  /* ── Upload button ── */
  .ap-upload-btn {
      height: 36px;
      padding: 0 18px;
      background: var(--ap-black);
      color: var(--ap-white) !important;
      border: none;
      border-radius: 36px;
      font-size: 13.5px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      text-decoration: none;
      white-space: nowrap;
      transition: background .2s, transform .15s, box-shadow .2s;
      flex-shrink: 0;
  }
  .ap-upload-btn:hover {
      background: #222;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(10,10,10,.18);
  }

  /* ── Profile dropdown ── */
  .ap-profile-wrap {
      position: relative;
      flex-shrink: 0;
  }
  .ap-avatar-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 2px solid var(--ap-warm-gray);
      overflow: hidden;
      cursor: pointer;
      transition: border-color .2s, transform .15s;
      display: block;
      background: var(--ap-warm-gray);
  }
  .ap-avatar-btn:hover {
      border-color: var(--ap-accent);
      transform: scale(1.06);
  }
  .ap-avatar-btn img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
  }

  /* Dropdown panel */
  .ap-dropdown {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      width: 220px;
      background: var(--ap-white);
      border: 1px solid var(--ap-warm-gray);
      border-radius: var(--ap-r-md);
      box-shadow: var(--ap-shadow-md);
      padding: 8px;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-6px);
      transition: opacity .2s, transform .2s, visibility .2s;
      z-index: 200;
      font-family: 'DM Sans', sans-serif;
  }
  .ap-profile-wrap:hover .ap-dropdown,
  .ap-dropdown.open {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
  }

  .ap-dd-user {
      padding: 10px 12px 12px;
      border-bottom: 1px solid var(--ap-warm-gray);
      margin-bottom: 6px;
  }
  .ap-dd-name {
      font-size: 14px;
      font-weight: 600;
      color: var(--ap-black);
      display: block;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }
  .ap-dd-handle {
      font-size: 12px;
      color: var(--ap-muted);
  }

  .ap-dd-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 12px;
      border-radius: var(--ap-r-sm);
      font-size: 13.5px;
      color: var(--ap-black);
      text-decoration: none;
      transition: background .15s, color .15s;
      font-family: 'DM Sans', sans-serif;
      background: none;
      border: none;
      width: 100%;
      cursor: pointer;
      text-align: left;
  }
  .ap-dd-item:hover { background: var(--ap-cream); color: var(--ap-black); }
  .ap-dd-item.danger { color: #c0392b; }
  .ap-dd-item.danger:hover { background: #fdf2f2; }

  .ap-dd-sep {
      height: 1px;
      background: var(--ap-warm-gray);
      margin: 6px 0;
  }

  /* ── History dropdown ── */
  .ap-history-wrap { position: relative; }
  .ap-history-menu {
      position: absolute;
      top: calc(100% + 10px);
      left: 50%;
      transform: translateX(-50%) translateY(-6px);
      width: 180px;
      background: var(--ap-white);
      border: 1px solid var(--ap-warm-gray);
      border-radius: var(--ap-r-md);
      box-shadow: var(--ap-shadow-md);
      padding: 6px;
      opacity: 0;
      visibility: hidden;
      transition: opacity .2s, transform .2s, visibility .2s;
      z-index: 200;
      font-family: 'DM Sans', sans-serif;
  }
  .ap-history-wrap:hover .ap-history-menu,
  .ap-history-menu.open {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(0);
  }

  /* ── Login Modal ── */
  .ap-login-modal .modal-content {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(10,10,10,.2);
      font-family: 'DM Sans', sans-serif;
  }
  .ap-login-modal .modal-header {
      border-bottom: 1px solid var(--ap-warm-gray);
      padding: 22px 28px 16px;
  }
  .ap-login-modal .modal-title {
      font-size: 17px;
      font-weight: 600;
      color: var(--ap-black);
  }
  .ap-login-modal .modal-body {
      padding: 24px 28px 28px;
  }
  .ap-login-modal p {
      font-size: 14px;
      color: var(--ap-muted);
      margin-bottom: 20px;
  }
  .ap-login-modal .ap-login-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      height: 44px;
      border-radius: 44px;
      font-size: 14px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: opacity .2s, transform .15s;
      margin-bottom: 10px;
  }
  .ap-login-modal .ap-login-btn:hover { opacity: .88; transform: translateY(-1px); }
  .ap-login-modal .ap-btn-google {
      background: var(--ap-black);
      color: var(--ap-white);
  }
  .ap-login-modal .ap-btn-email {
      background: var(--ap-cream);
      color: var(--ap-black);
      border: 1.5px solid var(--ap-warm-gray) !important;
  }

  /* ── Responsive ── */
  @media (max-width: 768px) {
  /* Sembunyikan semua nav center di desktop navbar */
  .ap-nav-center { display: none; }

  /* Sembunyikan tombol Unggah, gantikan dengan bottom nav */
  .ap-upload-btn { display: none; }

  /* Navbar lebih compact */
  .ap-navbar { height: 56px; padding: 0 16px; }

  /* Bottom Navigation Bar */
  .ap-bottom-nav {
    display: flex;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    height: 66px;
    background: rgba(249,247,244,0.96);
    backdrop-filter: blur(18px);
    border-top: 1px solid var(--ap-warm-gray);
    align-items: center;
    justify-content: space-around;
    padding: 0 4px env(safe-area-inset-bottom);
    z-index: 1040;
  }

  .ap-bn-item {
    flex: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 3px; color: var(--ap-muted);
    background: none; border: none;
    font-size: 9.5px; font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer; text-decoration: none;
  }
  .ap-bn-item.active { color: var(--ap-accent); }

  .ap-bn-create {
    width: 44px; height: 44px; border-radius: 50%;
    background: var(--ap-black); color: #fff;
    display: grid; place-items: center;
    border: none; cursor: pointer;
    box-shadow: 0 2px 10px rgba(10,10,10,.2);
    margin-top: -8px;
  }

  /* Padding bawah konten agar tidak tertutup bottom nav */
  .body-wrapper { padding-bottom: 74px; }
  }

  /* Sembunyikan bottom nav di desktop */
  .ap-bottom-nav { display: none; }

  /* Mobile nav di dalam dropdown — hidden di desktop */
  .ap-dd-mobile-nav { display: none; }
  .ap-dd-mobile-label {
      font-size: 10px;
      font-weight: 600;
      color: var(--ap-muted);
      letter-spacing: .06em;
      text-transform: uppercase;
      padding: 4px 12px 2px;
      margin: 0;
  }

  /* Muncul hanya di mobile */
  @media (max-width: 768px) {
      .ap-dd-mobile-nav { display: block; }

      /* Perlebar dropdown agar nyaman di mobile */
      .ap-dropdown {
          width: 260px;
          right: 0;
      }

      /* Sembunyikan nav center & tombol unggah di navbar */
      .ap-nav-center { display: none; }
      .ap-upload-btn { display: none; }
  }
</style>

<header class="ap-navbar">

    {{-- ── Brand ── --}}
    <a href="{{ route('user.dashboard') }}" class="ap-brand">
        <img src="{{ asset('ui/images/logos/aperturely.png') }}" alt="Aperture">
    </a>

    {{-- ── Center nav icons ── --}}
    <nav class="ap-nav-center">

        {{-- Beranda --}}
        <a class="ap-nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
        href="{{ route('user.dashboard') }}" title="Beranda">
            <svg width="35" height="25" viewBox="0 0 20 20" fill="none">
                <rect x="2" y="2" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                <rect x="11" y="2" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                <rect x="2" y="11" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                <rect x="11" y="11" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
            </svg>
        </a>

        {{-- Notifikasi --}}
        <a class="ap-nav-link {{ request()->routeIs('user.riwayat.postingan') ? 'active' : '' }}"
        href="{{ route('user.riwayat.postingan') }}" title="Notifikasi">
            <svg width="35" height="25" viewBox="0 0 20 20" fill="none">
                <path d="M10 2C7.24 2 5 4.24 5 7v5l-1.5 2h13L15 12V7c0-2.76-2.24-5-5-5z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                <path d="M8.5 17a1.5 1.5 0 003 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
            <span class="ap-badge"></span>
        </a>

        {{-- Buat postingan --}}
        <a class="ap-nav-link {{ request()->routeIs('user.postingan.create') ? 'active' : '' }}"
        href="{{ auth()->check() ? route('user.postingan.create') : '#' }}"
        @guest data-bs-toggle="modal" data-bs-target="#apLoginModal" @endguest
        title="Buat Postingan">
            <svg width="35" height="25" viewBox="0 0 20 20" fill="none">
                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7"/>
                <path d="M10 6.5v7M6.5 10h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
        </a>

        {{-- Trending --}}
        <a class="ap-nav-link {{ request()->routeIs('user.explore.trending') ? 'active' : '' }}"
        href="{{ route('user.explore.trending') }}" title="Trending">
                <svg width="35" height="25" viewBox="0 0 20 20" fill="none">
                <polyline points="3,14 7,9 11,11 17,5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                <polyline points="13,5 17,5 17,9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        {{-- Eksplor --}}
        <a class="ap-nav-link {{ request()->routeIs('user.explore.halaman') ? 'active' : '' }}"
        href="{{ route('user.explore.halaman') }}" title="Eksplor">
               <svg width="35" height="25" viewBox="0 0 20 20" fill="none">
                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7"/>
                <polygon points="13,7 8,9 7,13 12,11" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" fill="none"/>
            </svg>
        </a>

        {{-- Riwayat dropdown --}}
        <div class="ap-history-wrap">
            <button class="ap-nav-link" type="button" title="Riwayat">
                <svg width="35" height="25" viewBox="0 0 20 20" fill="none">
                    <path d="M3 10a7 7 0 107-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <path d="M3 6v4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 7v3.5l2.5 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="ap-history-menu">
                <a class="ap-dd-item" href="{{ route('user.riwayat.komentar') }}">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path d="M12 1.5H3a.5.5 0 00-.5.5v7a.5.5 0 00.5.5h2l2.5 2.5L10 9.5h2a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5z" stroke="currentColor" stroke-width="1.4"/>
                    </svg>
                    Komentar
                </a>
                <a class="ap-dd-item" href="{{ route('user.riwayat.like') }}">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path d="M7.5 12.5S2 9.5 2 5.5A3.5 3.5 0 017.5 3 3.5 3.5 0 0113 5.5C13 9.5 7.5 12.5 7.5 12.5z" stroke="currentColor" stroke-width="1.4"/>
                    </svg>
                    Menyukai
                </a>
            </div>
        </div>

    </nav>

    {{-- ── Right side ── --}}
    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">

        @auth
        {{-- Upload button --}}
        <a href="{{ route('user.postingan.create') }}" class="ap-upload-btn">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path d="M6.5 2v9M2 6.5h9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>Unggah</span>
        </a>

        {{-- Avatar dropdown --}}
        <div class="ap-profile-wrap">
            <div class="ap-avatar-btn">
                <img src="{{ auth()->user()->avatar_display }}" alt="{{ auth()->user()->name }}">
            </div>
            <div class="ap-dropdown">
                <div class="ap-dd-user">
                    <span class="ap-dd-name">{{ auth()->user()->name }}</span>
                    <span class="ap-dd-handle">@<i>{{ auth()->user()->username ?? strtolower(str_replace(' ','', auth()->user()->name)) }}</i></span>
                </div>
                <a class="ap-dd-item" href="{{ route('user.profile') }}">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="5" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M2 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    Profil
                </a>
                <a class="ap-dd-item" href="{{ route('user.riwayat.postingan') }}">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path d="M13 2H2a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h4l1.5 1.5L9 12h4a.5.5 0 00.5-.5v-9A.5.5 0 0013 2z" stroke="currentColor" stroke-width="1.4"/>
                    </svg>
                    Notifikasi
                </a>
                <a class="ap-dd-item" href="#">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="7.5" r="6" stroke="currentColor" stroke-width="1.4"/>
                        <circle cx="7.5" cy="7.5" r="2" stroke="currentColor" stroke-width="1.4"/>
                        <line x1="7.5" y1="1.5" x2="7.5" y2="3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <line x1="7.5" y1="11.5" x2="7.5" y2="13.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <line x1="1.5" y1="7.5" x2="3.5" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <line x1="11.5" y1="7.5" x2="13.5" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    Pengaturan Akun
                </a>

                <!-- tampilan mobile -->
                <div class="ap-dd-mobile-nav">
                    <div class="ap-dd-sep"></div>
                    <p class="ap-dd-mobile-label">Navigasi</p>
                    <a class="ap-dd-item" href="{{ route('user.dashboard') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <rect x="2" y="2" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="11" y="2" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="2" y="11" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="11" y="11" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                        </svg>
                        Beranda
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.explore.trending') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <polyline points="3,14 7,9 11,11 17,5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="13,5 17,5 17,9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Trending
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.postingan.create') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M10 6.5v7M6.5 10h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                        Unggah Foto
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.explore.halaman') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7"/>
                            <polygon points="13,7 8,9 7,13 12,11" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" fill="none"/>
                        </svg>
                        Eksplor
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.riwayat.postingan') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <path d="M3 10a7 7 0 107-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            <path d="M3 6v4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Riwayat
                    </a>
                </div>

                <div class="ap-dd-sep"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="ap-dd-item danger">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path d="M5.5 2H3a1 1 0 00-1 1v9a1 1 0 001 1h2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M10 5l3 2.5L10 10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="13" y1="7.5" x2="6" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        @else
        {{-- Guest --}}
        @guest
        <button class="ap-upload-btn" data-bs-toggle="modal" data-bs-target="#apLoginModal">
            Masuk
        </button>
        <div class="ap-profile-wrap">
            <div class="ap-avatar-btn">
                <img src="{{ asset('ui\images\profile\user3.jpg') }}" alt="Guest">
            </div>
            <div class="ap-dropdown">
                <div class="ap-dd-user">
                    <span class="ap-dd-name">Guest User</span>
                    <span class="ap-dd-handle">@<i>guestuser</i></span>
                </div>
                <a class="ap-dd-item" href="{{ route('user.profile') }}">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="5" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M2 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    Profil
                </a>
                <a class="ap-dd-item" href="{{ route('user.riwayat.postingan') }}">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <path d="M13 2H2a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h4l1.5 1.5L9 12h4a.5.5 0 00.5-.5v-9A.5.5 0 0013 2z" stroke="currentColor" stroke-width="1.4"/>
                    </svg>
                    Notifikasi
                </a>
                <a class="ap-dd-item" href="#">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                        <circle cx="7.5" cy="7.5" r="6" stroke="currentColor" stroke-width="1.4"/>
                        <circle cx="7.5" cy="7.5" r="2" stroke="currentColor" stroke-width="1.4"/>
                        <line x1="7.5" y1="1.5" x2="7.5" y2="3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <line x1="7.5" y1="11.5" x2="7.5" y2="13.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <line x1="1.5" y1="7.5" x2="3.5" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        <line x1="11.5" y1="7.5" x2="13.5" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                    Pengaturan Akun
                </a>

                <!-- tampilan mobile -->
                <div class="ap-dd-mobile-nav">
                    <div class="ap-dd-sep"></div>
                    <p class="ap-dd-mobile-label">Navigasi</p>
                    <a class="ap-dd-item" href="{{ route('user.dashboard') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <rect x="2" y="2" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="11" y="2" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="2" y="11" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="11" y="11" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.7"/>
                        </svg>
                        Beranda
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.explore.trending') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <polyline points="3,14 7,9 11,11 17,5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="13,5 17,5 17,9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Trending
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.postingan.create') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M10 6.5v7M6.5 10h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                        Unggah Foto
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.explore.halaman') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7"/>
                            <polygon points="13,7 8,9 7,13 12,11" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" fill="none"/>
                        </svg>
                        Eksplor
                    </a>
                    <a class="ap-dd-item" href="{{ route('user.riwayat.postingan') }}">
                        <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                            <path d="M3 10a7 7 0 107-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            <path d="M3 6v4h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Riwayat
                    </a>
                </div>

                <div class="ap-dd-sep"></div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="ap-dd-item danger">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                            <path d="M5.5 2H3a1 1 0 00-1 1v9a1 1 0 001 1h2.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M10 5l3 2.5L10 10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <line x1="13" y1="7.5" x2="6" y2="7.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endguest
        @endauth

    </div>

</header>

{{-- ── Login Modal ── --}}
<div class="modal fade ap-login-modal" id="apLoginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Selamat Datang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Masuk untuk menyimpan foto, berkomentar, dan terhubung dengan fotografer lain.</p>
                <a href="{{ url('/auth/google-redirect') }}" class="ap-login-btn ap-btn-google">
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                        <path d="M16.3 8.7c0-.6 0-1.2-.1-1.7H8.5v3.2h4.4a3.7 3.7 0 01-1.6 2.4v2h2.6c1.5-1.4 2.4-3.5 2.4-5.9z" fill="white"/>
                        <path d="M8.5 17c2.2 0 4-.7 5.3-2l-2.6-2a5 5 0 01-7.5-2.6H1v2A8.5 8.5 0 008.5 17z" fill="#ccc"/>
                        <path d="M3.7 10.4A5 5 0 013.5 8.5c0-.65.12-1.28.3-1.87V4.57H1A8.5 8.5 0 000 8.5c0 1.37.33 2.67.9 3.82l2.8-2z" fill="#ddd"/>
                        <path d="M8.5 3.4c1.2 0 2.3.42 3.1 1.23l2.3-2.3A8.5 8.5 0 001 4.57l2.7 2.07A5 5 0 018.5 3.4z" fill="#eee"/>
                    </svg>
                    Masuk dengan Google
                </a>
                <a href="{{ route('login') }}" class="ap-login-btn ap-btn-email">
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none">
                        <rect x="1.5" y="3.5" width="14" height="10" rx="1.5" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M1.5 5.5l7 5 7-5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Masuk dengan Email
                </a>
            </div>
        </div>
    </div>
</div>