<header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
         
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              
                <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                @auth 
                  <img src="{{ auth()->user()->avatar_display }}" alt="" width="60" height="60" class="rounded-circle">
                @endauth
                @guest
                  <img src="{{ asset('ui/images/profile/user3.jpg') }}" alt="" width="60" height="60" class="rounded-circle">
                @endguest
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="{{route('user.profile')}}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">Notifikasi</p>
                    </a>
                @auth
                    <a href=href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                @endauth

                @guest
                  <a href="#"
                    class="btn btn-outline-primary mx-3 mt-2 d-block"
                    data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    Login
                  </a>
                @endguest
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>

<!-- ================= MODAL LOGIN ================= -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p>Silahkan Login</p>

        <a href="{{ url('/auth/google-redirect') }}" class="btn btn-danger w-100">
          <i class="fab fa-google"></i> Login dengan Google
        </a>
        <hr/>
        <a href="{{ route('login') }}" class="btn btn-primary w-100">
          <i class="fab fa-google"></i> Login dengan Email
        </a>
      </div>

    </div>
  </div>
</div>

