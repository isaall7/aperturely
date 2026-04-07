<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aperture</title>

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
      margin-left: 200px; /* Space dari sidebar */
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

    @auth
      @if (auth()->user()->role === 'admin')
        body.admin-layout {
          background: #f1f5f9;
        }

        .admin-layout .left-sidebar {
          width: 270px;
          background: linear-gradient(180deg, #0f172a 0%, #172554 100%);
          box-shadow: 18px 0 40px rgba(15, 23, 42, 0.18);
        }

        .admin-layout .body-wrapper {
          margin-left: 270px;
        }

        .admin-layout .app-header {
          left: 290px;
          right: 24px;
          top: 16px;
          border-radius: 22px;
          padding: 0 22px;
          border: 1px solid rgba(148, 163, 184, 0.2);
          box-shadow: 0 16px 30px rgba(15, 23, 42, 0.08);
        }

        .admin-layout .app-header .navbar {
          width: 100%;
          min-height: 72px;
        }

        .admin-layout .body-wrapper-inner {
          padding: 102px 18px 24px;
        }

        .admin-layout .container-fluid {
          padding: 0;
        }

        .admin-layout .left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link {
          color: rgba(255, 255, 255, 0.78);
          border-radius: 16px;
          margin: 4px 16px;
          padding: 14px 16px;
        }

        .admin-layout .left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link:hover,
        .admin-layout .left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link.active-admin-link {
          background: rgba(255, 255, 255, 0.1);
          color: #fff;
        }

        .admin-layout .left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link iconify-icon,
        .admin-layout .left-sidebar .sidebar-nav ul .sidebar-item .sidebar-link i {
          color: inherit;
        }

        .admin-layout .left-sidebar .brand-logo {
          border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        @media (max-width: 1199px) {
          .admin-layout .left-sidebar {
            display: none !important;
          }

          .admin-layout .body-wrapper {
            margin-left: 0;
          }

          .admin-layout .app-header {
            left: 16px;
            right: 16px;
            top: 12px;
          }

          .admin-layout .body-wrapper-inner {
            padding: 96px 12px 20px;
          }
        }
      @endif
    @endauth
  </style>
</head>

<body class="@auth{{ auth()->user()->role === 'admin' ? 'admin-layout' : '' }}@endauth">
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
        <div class="container-fluid">
          <!-- Konten utama -->
              @yield('content')
          </div>

          <!-- Footer -->
          <!-- <div class="page-footer">
            <p class="mb-0 fs-4">
              Design and Developed by 
              <a href="https://www.instagram.com/isaallajh?igsh=MTIyZTJleDY4Y2tudg==" target="_blank" class="pe-1 text-primary text-decoration-underline">Faisal</a> 
              Distributed by <a href="https://themewagon.com/">ThemeWagon</a>
            </p>
          </div> -->
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- notifikasi -->
  @if (session('success'))
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: @json(session('success')),
              confirmButtonColor: '#22c55e'
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
