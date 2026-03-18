<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aperture — Daftar</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('ui/images/logos/aperturely_logo.png') }}"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --black:      #0a0a0a;
        --white:      #ffffff;
        --cream:      #f9f7f4;
        --warm-gray:  #e8e4df;
        --mid-gray:   #b8b3ac;
        --muted:      #888077;
        --accent:     #c8533a;
        --accent-h:   #a83f28;
        --accent-soft:#f5ece9;
        --shadow-md:  0 4px 16px rgba(10,10,10,0.10);
        --shadow-lg:  0 12px 40px rgba(10,10,10,0.14);
        --r-md: 14px;
        --r-lg: 20px;
        --r-xl: 28px;
        font-family: 'DM Sans', sans-serif;
    }

    html, body { height: 100%; }

    body {
        background: var(--cream);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 24px 16px;
    }

    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 10% 20%, rgba(200,83,58,.06) 0%, transparent 60%),
            radial-gradient(ellipse 50% 40% at 90% 80%, rgba(10,10,10,.04) 0%, transparent 60%);
        pointer-events: none;
        z-index: 0;
    }

    .auth-card {
        background: var(--white);
        border-radius: var(--r-xl);
        box-shadow: var(--shadow-lg);
        width: 100%;
        max-width: 420px;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), #e07a5f, var(--accent));
    }

    .auth-body { padding: 40px 40px 36px; }

    .auth-brand {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 32px;
        text-decoration: none;
    }

    .auth-brand img {
        height: 38px;
        width: auto;
        margin-bottom: 10px;
    }

    .auth-brand-sub {
        font-size: 12px;
        color: var(--muted);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-weight: 500;
    }

    .auth-heading { margin-bottom: 28px; }

    .auth-heading h1 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 400;
        color: var(--black);
        margin-bottom: 6px;
    }

    .auth-heading p { font-size: 13.5px; color: var(--muted); }

    .auth-group { margin-bottom: 16px; }

    .auth-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--black);
        margin-bottom: 7px;
    }

    .auth-field {
        width: 100%;
        height: 44px;
        background: var(--cream);
        border: 1.5px solid var(--warm-gray);
        border-radius: var(--r-md);
        padding: 0 16px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: var(--black);
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
    }

    .auth-field:focus {
        background: var(--white);
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(200,83,58,.12);
    }

    .auth-field::placeholder { color: var(--muted); }

    .auth-field.is-invalid {
        border-color: #c0392b;
        background: #fdf2f2;
    }

    .auth-invalid {
        font-size: 12px;
        color: #c0392b;
        font-weight: 500;
        margin-top: 5px;
        display: block;
    }

    /* Two-col row for password fields */
    .auth-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 16px;
    }

    @media (max-width: 440px) { .auth-row { grid-template-columns: 1fr; } }

    .auth-submit {
        width: 100%;
        height: 44px;
        background: var(--black);
        color: var(--white);
        border: none;
        border-radius: var(--r-md);
        font-size: 14.5px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background .2s, transform .15s, box-shadow .2s;
        margin-top: 8px;
    }

    .auth-submit:hover {
        background: #222;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(10,10,10,.2);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 22px 0;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--warm-gray);
    }

    .auth-divider span {
        font-size: 11.5px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .auth-google {
        width: 100%;
        height: 44px;
        background: var(--white);
        color: var(--black);
        border: 1.5px solid var(--warm-gray);
        border-radius: var(--r-md);
        font-size: 14px;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: background .2s, border-color .2s, transform .15s, box-shadow .2s;
    }

    .auth-google:hover {
        background: var(--cream);
        border-color: var(--mid-gray);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: var(--black);
    }

    /* Password strength indicator */
    .auth-password-wrap { position: relative; }

    .auth-eye {
        position: absolute;
        right: 14px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        cursor: pointer; color: var(--muted);
        display: flex; align-items: center;
        transition: color .2s;
        padding: 0;
    }

    .auth-eye:hover { color: var(--black); }

    .auth-footer {
        text-align: center;
        margin-top: 24px;
        font-size: 13.5px;
        color: var(--muted);
    }

    .auth-footer a {
        color: var(--accent);
        font-weight: 600;
        text-decoration: none;
        margin-left: 5px;
        transition: color .2s;
    }

    .auth-footer a:hover { color: var(--accent-h); }

    /* Terms note */
    .auth-terms {
        font-size: 12px;
        color: var(--muted);
        text-align: center;
        margin-top: 14px;
        line-height: 1.6;
    }

    .auth-terms a { color: var(--accent); text-decoration: none; }

    @media (max-width: 480px) {
        .auth-body { padding: 32px 24px 28px; }
    }
  </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-body">

            {{-- Brand --}}
            <a href="{{ url('/') }}" class="auth-brand">
                <img src="{{ asset('ui/images/logos/aperturely.png') }}" alt="Aperture">
                <span class="auth-brand-sub">Photography Platform</span>
            </a>

            {{-- Heading --}}
            <div class="auth-heading">
                <h1>Buat akun baru</h1>
                <p>Bergabung dengan komunitas fotografer Aperture</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="auth-group">
                    <label class="auth-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                           class="auth-field {{ $errors->has('name') ? 'is-invalid' : '' }}"
                           value="{{ old('name') }}"
                           placeholder="Nama kamu"
                           required autocomplete="name" autofocus>
                    @error('name')
                        <span class="auth-invalid">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="auth-group">
                    <label class="auth-label" for="email">Email</label>
                    <input type="email" id="email" name="email"
                           class="auth-field {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           value="{{ old('email') }}"
                           placeholder="nama@email.com"
                           required autocomplete="email">
                    @error('email')
                        <span class="auth-invalid">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password row --}}
                <div class="auth-row">
                    <div>
                        <label class="auth-label" for="password">Password</label>
                        <div class="auth-password-wrap">
                            <input type="password" id="password" name="password"
                                   class="auth-field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   placeholder="Min. 8 karakter"
                                   style="padding-right:40px"
                                   required autocomplete="new-password">
                            <button type="button" class="auth-eye" onclick="togglePw('password', this)">
                                <svg id="eye-password" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <ellipse cx="8" cy="8" rx="7" ry="4.5" stroke="currentColor" stroke-width="1.4"/>
                                    <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.4"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="auth-invalid">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="auth-label" for="password-confirm">Konfirmasi</label>
                        <div class="auth-password-wrap">
                            <input type="password" id="password-confirm" name="password_confirmation"
                                   class="auth-field"
                                   placeholder="Ulangi password"
                                   style="padding-right:40px"
                                   required autocomplete="new-password">
                            <button type="button" class="auth-eye" onclick="togglePw('password-confirm', this)">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <ellipse cx="8" cy="8" rx="7" ry="4.5" stroke="currentColor" stroke-width="1.4"/>
                                    <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="auth-submit">Buat Akun</button>

                <div class="auth-divider"><span>atau</span></div>

                <a href="/auth/google-redirect" class="auth-google">
                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                        <path d="M9.003 18c2.43 0 4.467-.806 5.956-2.184l-2.909-2.258c-.806.54-1.836.86-3.047.86-2.344 0-4.328-1.584-5.036-3.711H.96v2.332C2.44 15.983 5.485 18 9.003 18z" fill="#34A853"/>
                        <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V4.958H.957C.347 6.173 0 7.548 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
                        <path d="M9.003 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.464.891 11.426 0 9.003 0 5.485 0 2.44 2.017.96 4.958L3.967 7.29c.708-2.127 2.692-3.71 5.036-3.71z" fill="#EA4335"/>
                    </svg>
                    Daftar dengan Google
                </a>

                <p class="auth-terms">
                    Dengan mendaftar kamu menyetujui syarat & ketentuan Aperture
                </p>
            </form>

            <div class="auth-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

        </div>
    </div>

    <script src="{{ asset('ui/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('ui/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.innerHTML = isHidden
            ? `<svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M2 2l12 12M6.5 6.6A2 2 0 009.4 9.5M4.2 4.3C2.8 5.3 1.7 6.5 1 8c1.5 3 4 5 7 5 1.3 0 2.5-.4 3.6-1M7 3.1C7.3 3 7.7 3 8 3c3 0 5.5 2 7 5-.5 1-1.2 2-2.1 2.7" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>`
            : `<svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <ellipse cx="8" cy="8" rx="7" ry="4.5" stroke="currentColor" stroke-width="1.4"/>
                <circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.4"/></svg>`;
    }
    </script>
</body>
</html>