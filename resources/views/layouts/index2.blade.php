<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aperture</title>

  <link rel="shortcut icon" type="image/png" href="{{ asset('ui/images/logos/aperturely_logo.png') }}" />
  <link rel="stylesheet" href="{{ asset('ui/css/styles.min.css') }}" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body { 
      height: 100%; 
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    
    .page-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ========== NAVBAR MINIMALIS ========== */
    .app-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1040;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      height: 60px;
      display: flex;
      align-items: center;
      transition: all 0.3s ease;
    }

    .app-header .navbar {
      width: 100%;
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100%;
    }

    /* Logo */
    .navbar-brand {
      display: flex;
      align-items: center;
    }

    .navbar-brand img {
      transition: transform 0.3s ease;
    }

    .navbar-brand img:hover {
      transform: scale(1.05);
    }

    /* Center Menu - Icon Only */
    .navbar-center {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    .navbar-center .navbar-nav {
      display: flex;
      gap: 25px;
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .navbar-center .nav-item {
      position: relative;
    }

    .navbar-center .nav-link {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      color: #5d596c;
      border-radius: 12px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      cursor: pointer;
    }

    .navbar-center .nav-link:hover {
      background: linear-gradient(135deg, rgba(93, 135, 255, 0.1), rgba(139, 92, 246, 0.1));
      color: #5d87ff;
      transform: translateY(-2px);
    }

    .navbar-center .nav-link:active {
      transform: translateY(0);
    }

    /* Tooltip Custom */
    .tooltip {
      font-size: 13px;
      font-weight: 500;
    }

    .tooltip-inner {
      background: #2c2c2c;
      padding: 6px 12px;
      border-radius: 6px;
    }

    .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
      border-bottom-color: #2c2c2c;
    }

    /* Dropdown */
    .navbar-center .dropdown-menu {
      border: none;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      border-radius: 12px;
      margin-top: 8px;
      padding: 8px;
      min-width: 180px;
    }

    .navbar-center .dropdown-item {
      border-radius: 8px;
      padding: 10px 12px;
      transition: all 0.2s;
      font-size: 14px;
    }

    .navbar-center .dropdown-item:hover {
      background: rgba(93, 135, 255, 0.1);
      color: #5d87ff;
      transform: translateX(4px);
    }

    /* Profile */
    .navbar-profile {
      display: flex;
      align-items: center;
    }

    .navbar-profile img {
      border: 2px solid #f0f0f0;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .navbar-profile img:hover {
      border-color: #5d87ff;
      transform: scale(1.1);
      box-shadow: 0 4px 12px rgba(93, 135, 255, 0.3);
    }

    .navbar-profile .dropdown-menu {
      border: none;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
      border-radius: 12px;
      margin-top: 12px;
      padding: 12px;
      min-width: 220px;
    }

    .navbar-profile .dropdown-item {
      border-radius: 8px;
      padding: 10px 12px;
      transition: all 0.2s;
      font-size: 14px;
    }

    .navbar-profile .dropdown-item:hover {
      background: rgba(93, 135, 255, 0.1);
      color: #5d87ff;
    }

    .navbar-profile .btn {
      font-size: 14px;
      padding: 8px 16px;
      border-radius: 8px;
    }

    /* Body Content */
    .body-wrapper {
      flex: 1;
      margin-top: 60px;
      display: flex;
      flex-direction: column;
    }

    .body-wrapper-inner {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .container-fluid {
      flex: 1;
      max-width: 1400px;
      margin: 0 auto;
      padding: 30px 20px;
      width: 100%;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
      .app-header {
        height: 56px;
      }

      .navbar-brand img {
        max-height: 32px !important;
      }

      .navbar-center {
        position: static;
        transform: none;
        flex: 1;
        display: flex;
        justify-content: center;
        margin: 0 10px;
      }

      .navbar-center .navbar-nav {
        gap: 4px;
      }

      .navbar-center .nav-link {
        width: 40px;
        height: 40px;
      }

      .navbar-profile img {
        width: 32px !important;
        height: 32px !important;
      }

      .container-fluid {
        padding: 20px 15px;
      }
    }

    @media (max-width: 480px) {
      .navbar-center .navbar-nav {
        gap: 2px;
      }

      .navbar-center .nav-link {
        width: 36px;
        height: 36px;
      }

      .navbar-center .nav-link iconify-icon {
        width: 20px !important;
      }
    }

    /* Smooth Scroll */
    html {
      scroll-behavior: smooth;
    }

    /* Loading Animation */
    iconify-icon {
      transition: all 0.3s ease;
    }

    .nav-link:hover iconify-icon {
      animation: iconPulse 0.6s ease;
    }

    @keyframes iconPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.15); }
    }
  </style>
</head>

<body>
  <div class="page-wrapper">
    <!-- Navbar -->
    @auth
      @if (auth()->user()->role === 'admin')
        @include('layouts.ui_user.navbar')
      @elseif (auth()->user()->role === 'user')
        @include('layouts.ui_user.navbar')
      @endif
    @endauth

    @guest
      @include('layouts.ui_user.navbar')
    @endguest

    <!-- Main Content -->
    <div class="body-wrapper">
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('ui/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('ui/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('ui/js/app.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Initialize Tooltips -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Enable Bootstrap Tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>

  @if (session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        confirmButtonColor: '#22c55e',
        timer: 3000
      });
    });
  </script>
  @endif

  @if (session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#ef4444'
      });
    });
  </script>
  @endif
</body>
</html>