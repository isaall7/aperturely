<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aperturely</title>

  <link rel="shortcut icon" type="image/png" href="{{ asset('ui/images/logos/aperturely_logo.png') }}" />
  <link rel="stylesheet" href="{{ asset('ui/css/styles.min.css') }}" />

  <style>
    /* Minimal CSS untuk: navbar fixed atas + space dari sidebar, footer bawah, dan profile tidak hilang */
    html, body { height: 100%; margin: 0; }

    .page-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .left-sidebar {
      position: fixed !important;
      top: 0;
      left: 0;
      width: 270px;
      height: 100vh;
      z-index: 1040;
    }

    .body-wrapper {
      flex: 1;
      margin-left: 270px; /* Space dari sidebar */
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
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Navbar fixed atas, mulai setelah sidebar, dan padding lebih untuk profile */
    .app-header {
      position: fixed;
      top: 10px;
      left: 290px;
      right: 80px;
      z-index: 900px;
      background: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      padding: 0 35px; /* Tambah padding kanan-kiri biar navbar lebih panjang & profile aman */
    }

    .app-header .navbar {
      width: 79%;
      padding: 0;
    }

    /* Jarak konten dari navbar */
    .main-content {
      margin-top: 70px;
      flex: 1;
      padding: 0 20px;
    }

    /* Footer selalu bawah, full width dengan space sidebar */
    .page-footer {
      padding: 20px 0;
      text-align: center;
      background: #f8f9fa;
      border-top: 1px solid #e9ecef;
      margin-left: -270px;
      padding-left: 290px;
      padding-right: 20px;
    }

    /* Mobile responsive */
    @media (max-width: 1199px) {
      .body-wrapper {
        margin-left: 0;
      }
      .app-header {
        left: 0;
        padding: 0 20px;
      }
      .main-content {
        padding: 0 15px;
      }
      .page-footer {
        margin-left: 0;
        padding-left: 20px;
      }
      .left-sidebar {
        transform: translateX(-100%);
      }
      .left-sidebar.show {
        transform: translateX(0);
      }
    }
  </style>
</head>

<body>
  <!-- Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar Start -->
    @auth
        @if (auth()->user()->role === 'admin')
            @include('layouts.ui_admin.sidebar')
        
        @elseif (auth()->user()->role === 'user')
            @include('layouts.ui_user.sidebar')
        @endif
    @endauth

    @guest
            @include('layouts.ui_user.sidebar')
    @endguest

    <!-- Sidebar End -->

    <!-- Main wrapper -->
    <div class="body-wrapper">
      <!-- Header navbar -->
    @auth
        @if (auth()->user()->role === 'admin')
            @include('layouts.ui_admin.navbar')
        
        @elseif (auth()->user()->role === 'user')
            @include('layouts.ui_user.navbar')
        @endif
    @endauth

    @guest
            @include('layouts.ui_user.navbar')
    @endguest

      <div class="body-wrapper-inner">
        <div class="container-fluid pt-6 px-0">
          <!-- Konten utama -->
              @yield('content')
          </div>

          <!-- Footer -->
          <div class="page-footer">
            <p class="mb-0 fs-4">
              Design and Developed by 
              <a href="https://www.instagram.com/isaallajh?igsh=MTIyZTJleDY4Y2tudg==" target="_blank" class="pe-1 text-primary text-decoration-underline">Faisal</a> 
              <!-- Distributed by <a href="https://themewagon.com/">ThemeWagon</a> -->
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('ui/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('ui/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('ui/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('ui/js/app.min.js') }}"></script>
  <script src="{{ asset('ui/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('ui/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('ui/js/dashboard.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>
</html>