<div class="header">    
    <div class="header-content clearfix">

        <div class="nav-control">
            <div class="hamburger">
                <span class="toggle-icon"><i class="icon-menu"></i></span>
            </div>
        </div>

        <div class="header-left">
            <div class="input-group icons">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3">
                        <i class="mdi mdi-magnify"></i>
                    </span>
                </div>
                <input type="search" class="form-control" placeholder="Search Dashboard">
            </div>
        </div>

        <div class="header-right">
            <ul class="clearfix">

                <!-- USER DROPDOWN -->
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                        <span class="activity active"></span>
                        <img src="{{ asset('ui/images/user/1.png') }}" height="40" width="40" alt="">
                    </div>

                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="icon-user"></i> <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="icon-envelope-open"></i> <span>Pesan</span>
                                    </a>
                                </li>

                                <hr class="my-2">

                                {{-- JIKA LOGIN --}}
                                @auth
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="icon-key"></i> <span>Logout</span>
                                        </a>
                                    </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endauth

                                {{-- JIKA BELUM LOGIN --}}
                                @guest
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#loginModal">
                                            <i class="icon-key"></i> <span>Login</span>
                                        </a>
                                    </li>
                                @endguest

                            </ul>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>

<!-- ================= MODAL LOGIN ================= -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <p>Login menggunakan akun Google Anda</p>

                <a href="{{ url('/auth/google-redirect') }}" class="btn btn-danger btn-block">
                    <i class="fab fa-google"></i> Login dengan Google
                </a>
            </div>

        </div>
    </div>
</div>
