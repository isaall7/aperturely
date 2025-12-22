<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Rosella - Login</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link href="{{asset('ui/css/style.css')}}" rel="stylesheet">
    
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
    </style>
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="{{ url('/') }}">
                                    <h4>Aperturely</h4>
                                </a>
        
                                <form method="POST" action="{{ route('login') }}" class="mt-5 mb-5 login-input">
                                    @csrf

                                    <div class="form-group">
                                        <input 
                                            id="email"
                                            type="email" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="Email"
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

                                    <div class="form-group">
                                        <input 
                                            id="password"
                                            type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            name="password"
                                            placeholder="Password"
                                            required
                                            autocomplete="current-password"
                                        >
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn login-form__btn submit w-100">
                                        Sign In
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
                                </form>

                                <p class="mt-5 login-form__footer">
                                    Belum punya akun? 
                                    <a href="{{ route('register') }}" class="text-primary">Daftar</a> sekarang
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('ui/plugins/common/common.min.js')}}"></script>
    <script src="{{asset('ui/js/custom.min.js')}}"></script>
    <script src="{{asset('ui/js/settings.js')}}"></script>
    <script src="{{asset('ui/js/gleek.js')}}"></script>
    <script src="{{asset('ui/js/styleSwitcher.js')}}"></script>
</body>
</html>