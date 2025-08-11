<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', env('APP_NAME'))</title>

    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="/assets/admin/stisla/css/style.css">
    <link rel="stylesheet" href="/assets/admin/stisla/css/components.css">
    <link rel="stylesheet" href="/assets/admin/stisla/css/common.css">

    @yield('style')
</head>

<body style="background-image: url('{{ asset('assets/images/backgroans.png') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
 <video autoplay muted loop playsinline 
    style="position: fixed; right: 0; bottom: 0; min-width: 100%; min-height: 100%; 
           width: 100vw; height: 100vh; object-fit: cover; z-index: -1;">
    <source src="{{ asset('assets/images/backlog2.mp4') }}" type="video/mp4">
    Tarayıcınız video etiketini desteklemiyor.
</video>
    <div id="app">
        <section class="section">
            <div class="container ">
                <div class="row">
                   
                                               <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">

                        <div class="login-brand">
                            <img src="/assets/images/logo_white.png" alt="{{ env('APP_NAME') }}" width="200">
                        </div>

                        @yield('content')

                       
                    
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="/assets/admin/vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="/assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/vendor/jquery/jquery.nicescroll.min.js"></script>
    <script src="/assets/admin/vendor/moment/moment.min.js"></script>
    <script src="/assets/admin/stisla/js/stisla.js"></script>
    <script src="/assets/admin/stisla/js/scripts.js"></script>
    <script src="/assets/admin/stisla/js/common.js"></script>

    @yield('script')
</body>

</html>
