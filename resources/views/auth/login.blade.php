<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aperture - Login</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('ui/images/logos/aperturely_logo.png')}}" />
  <link rel="stylesheet" href="{{asset('ui/css/styles.min.css')}}" />
  
  <style>
    .btn-google {
      width: 100%;
      padding: 12px;
      background: #ffffff;
      color: #2d2d2d;
      border: 2px solid #e0e0e0;
      border-radius: 5px;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      margin-top: 15px;
    }

    .btn-google:hover {
      background: #f8f8f8;
      border-color: #7571f9;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      color: #2d2d2d;
    }

    .btn-google svg {
      margin-right: 10px;
    }

    .divider {
      text-align: center;
      margin: 20px 0;
      position: relative;
    }

    .divider::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      width: 100%;
      height: 1px;
      background: #e0e0e0;
    }

    .divider span {
      background: #ffffff;
      padding: 0 15px;
      color: #999;
      font-size: 13px;
      position: relative;
      z-index: 1;
    }

    .logo-img img {
      max-width: 180px;
      height: auto;
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{asset('ui/images/logos/aperturely.png')}}" alt="Aperturely Logo" />
                </a>
                <!-- <p class="text-center">Isilah Dengan Tepat</p> -->
                
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                      type="email" 
                      class="form-control @error('email') is-invalid @enderror" 
                      id="email"
                      name="email"
                      value="{{ old('email') }}"
                      required
                      autocomplete="email"
                      autofocus
                    >
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input 
                      type="password" 
                      class="form-control @error('password') is-invalid @enderror" 
                      id="password"
                      name="password"
                      required
                      autocomplete="current-password"
                    >
                    @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4">
                    Masuk
                  </button>
                  
                  <div class="divider">
                    <span>ATAU</span>
                  </div>

                  <a href="/auth/google-redirect" class="btn-google">
                    <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                      <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                      <path d="M9.003 18c2.43 0 4.467-.806 5.956-2.184l-2.909-2.258c-.806.54-1.836.86-3.047.86-2.344 0-4.328-1.584-5.036-3.711H.96v2.332C2.44 15.983 5.485 18 9.003 18z" fill="#34A853"/>
                      <path d="M3.964 10.71c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V4.958H.957C.347 6.173 0 7.548 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
                      <path d="M9.003 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.464.891 11.426 0 9.003 0 5.485 0 2.44 2.017.96 4.958L3.967 7.29c.708-2.127 2.692-3.71 5.036-3.71z" fill="#EA4335"/>
                    </svg>
                    Login dengan Google
                  </a>
                  
                  <div class="d-flex align-items-center justify-content-center mt-4">
                    <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Daftar sekarang</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="{{asset('ui/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('ui/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>