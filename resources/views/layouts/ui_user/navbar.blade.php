<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <!-- Logo Kiri -->
    <div class="navbar-brand">
      <a href="{{ route('user.dashboard') }}" class="logo-img">
        <img 
          src="{{ asset('ui/images/logos/aperturely.png') }}" 
          style="max-height: 40px;"
          alt="Aperturely Logo"
        />
      </a>
    </div>

    <!-- Menu Tengah - Icon Only -->
    <div class="navbar-center">
      <ul class="navbar-nav">
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Beranda">
          <a class="nav-link" href="{{route('user.dashboard')}}">
            <iconify-icon icon="solar:widget-line-duotone" width="24"></iconify-icon>
          </a>
        </li>
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifikasi">
          <a class="nav-link" href="{{route('user.riwayat.notifikasi')}}">
            <iconify-icon icon="solar:bell-line-duotone" width="24"></iconify-icon>
          </a>
        </li>
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Buat Postingan">
          <a class="nav-link" href="{{ auth()->check() ? route('user.postingan.create') : route('login') }}">
            <iconify-icon icon="solar:add-circle-line-duotone" width="24"></iconify-icon>
          </a>
        </li>
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Trending">
          <a class="nav-link" href="#">
            <iconify-icon icon="solar:chart-line-duotone" width="24"></iconify-icon>
          </a>
        </li>
        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eksplor">
          <a class="nav-link" href="#">
            <iconify-icon icon="solar:compass-line-duotone" width="24"></iconify-icon>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" 
             data-bs-title="Riwayat">
            <iconify-icon icon="solar:history-line-duotone" width="24"></iconify-icon>
          </a>
          <ul class="dropdown-menu dropdown-menu-center">
            <li>
              <a class="dropdown-item" href="#">
                <i class="ti ti-message-circle me-2"></i>Komentar
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <i class="ti ti-thumb-up me-2"></i>Menyukai
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    <!-- Profile Kanan -->
    <div class="navbar-profile">
      <div class="nav-item dropdown">
        <a class="nav-link p-0" href="#" id="drop2" data-bs-toggle="dropdown">
          @auth 
            <img src="{{ auth()->user()->avatar_display }}" alt="" width="36" height="36" class="rounded-circle">
          @endauth
          @guest
            <img src="{{ asset('ui/images/profile/user3.jpg') }}" alt="" width="36" height="36" class="rounded-circle">
          @endguest
        </a>
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="drop2">
          <div class="message-body">
            <a href="{{ auth()->check() ? route('user.profile') : route('login') }}" class="dropdown-item">
              <i class="ti ti-user fs-6 me-2"></i>
              <span>Profile</span>
            </a>
            <a href="#" class="dropdown-item">
              <i class="ti ti-mail fs-6 me-2"></i>
              <span>Notifikasi</span>
            </a>
            @auth
              <a href="{{ route('logout') }}" 
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                 class="btn btn-outline-primary mx-3 mt-2 d-block shadow-none">
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            @endauth
            @guest
              <a href="#" class="btn btn-outline-primary mx-3 mt-2 d-block shadow-none" 
                 data-bs-toggle="modal" data-bs-target="#loginModal">
                Login
              </a>
            @endguest
          </div>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Silahkan Login</p>
        <a href="{{ url('/auth/google-redirect') }}" class="btn btn-danger w-100 mb-2">
          <i class="fab fa-google"></i> Login dengan Google
        </a>
        <a href="{{ route('login') }}" class="btn btn-primary w-100">
          Login dengan Email
        </a>
      </div>
    </div>
  </div>
</div>