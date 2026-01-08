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
