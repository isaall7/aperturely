<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <!-- theme meta -->
    <meta name="theme-name" content="quixlab" />
  
    <title>Quixlab - Bootstrap Admin Dashboard Template by Themefisher.com</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('ui/images/favicon.png')}}">
    <!-- Pignose Calender -->
    <link href="{{asset('ui/plugins/pg-calendar/css/pignose.calendar.min.css')}}" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="{{asset('ui/plugins/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{asset('ui/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css')}}">
    <!-- Custom Stylesheet -->
    <link href="{{asset('ui/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

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

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!-- logo -->
        @include('layouts.ui_admin.logo')
        <!-- end logo -->
    @auth
        @if (auth()->user()->role === 'admin')
            @include('layouts.ui_admin.navbar') 
            @include('layouts.ui_admin.sidebar')
        
        @elseif (auth()->user()->role === 'user')
            @include('layouts.ui_user.navbar') 
            @include('layouts.ui_user.sidebar')
        @endif
    @endauth

        @guest
            @include('layouts.ui_user.navbar')
            @include('layouts.ui_user.sidebar')
        @endguest

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
                @yield('content')
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('ui/plugins/common/common.min.js')}}"></script>
    <script src="{{asset('ui/js/custom.min.js')}}"></script>
    <script src="{{asset('ui/js/settings.js')}}"></script>
    <script src="{{asset('ui/js/gleek.js')}}"></script>
    <script src="{{asset('ui/js/styleSwitcher.js')}}"></script>

    <!-- Chartjs -->
    <script src="{{asset('ui/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- Circle progress -->
    <script src="{{asset('ui/plugins/circle-progress/circle-progress.min.js')}}"></script>
    <!-- Datamap -->
    <script src="{{asset('ui/plugins/d3v3/index.js')}}"></script>
    <script src="{{asset('ui/plugins/topojson/topojson.min.js')}}"></script>
    <script src="{{asset('ui/plugins/datamaps/datamaps.world.min.js')}}"></script>
    <!-- Morrisjs -->
    <script src="{{asset('ui/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('ui/plugins/morris/morris.min.js')}}"></script>
    <!-- Pignose Calender -->
    <script src="{{asset('ui/plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('ui/plugins/pg-calendar/js/pignose.calendar.min.js')}}"></script>
    <!-- ChartistJS -->
    <script src="{{asset('ui/plugins/chartist/js/chartist.min.js')}}"></script>
    <script src="{{asset('ui/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js')}}"></script>

    <script src="{{asset('ui/js/dashboard/dashboard-1.js')}}"></script>

</body>

</html>
