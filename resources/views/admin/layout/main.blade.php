<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', env('APP_NAME'))</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.urls = @json($admin->request_routes());
    </script>

    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/iziToast/css/iziToast.min.css">

    @stack('style')

    <link rel="stylesheet" href="/assets/admin/stisla/css/style.css">
    <link rel="stylesheet" href="/assets/admin/stisla/css/components.css">
    <link rel="stylesheet" href="/assets/admin/stisla/css/common.css">
</head>

<body class="">
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            @include('admin.partial.header')
            @include('admin.partial.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                  


                    <div class="section-body">
                        @hasSection('banner-title')
                        <div class="section-header flex flex-col space-y-4 p-6 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-lg shadow-lg">
                            <h1 class="text-4xl font-semibold">{{ $bannerTitle ?? 'Başlık' }}</h1>
                        
                            @isset($breadcrumbs)
                                <div class="section-header-breadcrumb flex items-center space-x-2">
                                    <div class="breadcrumb-item">
                                        <a href="/" class="text-gray-200 hover:text-white transition-colors">@lang('title.homepage')</a>
                                    </div>
                        
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        @if ($loop->last)
                                            <div class="breadcrumb-item text-gray-300">
                                                {{ $breadcrumb['title'] }}
                                            </div>
                                        @else
                                            <div class="breadcrumb-item">
                                                <a href="{{ route($breadcrumb['route']) }}" class="text-gray-200 hover:text-white transition-colors">
                                                    {{ $breadcrumb['title'] }}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endisset
                        </div>
                        
                        @endif
                        @yield('content')
                    </div>
                </section>
            </div>

            @include('admin.partial.footer')
        </div>
    </div>

    @stack('modal')

    <script src="/assets/admin/vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="/assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/vendor/jquery/jquery.nicescroll.min.js"></script>
    <script src="/assets/admin/vendor/moment/moment.min.js"></script>
    <script src="/assets/admin/vendor/iziToast/js/iziToast.min.js"></script>

    @stack('script')

    <script src="/assets/admin/stisla/js/stisla.js"></script>
    <script src="/assets/admin/stisla/js/scripts.js"></script>
    <script src="/assets/admin/js/plugins.js?v=1.1.1"></script>
    <script src="/assets/admin/js/masks.js?v=1.1.1"></script>
    <script src="/assets/admin/js/modals.js?v=1.1.1"></script>
    <script src="/assets/admin/js/common.js?v=1.1.1"></script>
</body>

</html>
