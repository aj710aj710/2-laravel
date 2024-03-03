<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@stack('title' ?? '') - {{ getOption('app_name') }}</title>
    @hasSection('meta')
        @stack('meta')
    @else
        @php
            $metaData = getMeta('home');
        @endphp

        <!-- Open Graph meta tags for social sharing -->
        <meta property="og:type" content="{{ __('zaisub') }}">
        <meta property="og:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
        <meta property="og:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
        <meta property="og:image" content="{{ $metaData['og_image'] ?? getSettingImage('app_logo') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ getOption('app_name') }}">

        <!-- Twitter Card meta tags for Twitter sharing -->
        <meta name="twitter:card" content="{{ __('zaisub') }}">
        <meta name="twitter:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
        <meta name="twitter:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
        <meta name="twitter:image" content="{{ $metaData['og_image'] ?? getSettingImage('app_logo') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endif
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{{ asset('user/images/favicon.png') }}" type="image/x-icon" />
    <!-- css file  -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/dataTables.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/dataTables.responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/summernote/summernote-lite.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/scss/style.css') }}" />
</head>

<body>
    <!-- Main Content -->
    @yield('content')

    <!-- js file  -->
    <script src="{{ asset('user/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('user/js/plugins.js') }}"></script>
    <script src="{{ asset('user/js/dataTables.js') }}"></script>
    <script src="{{ asset('user/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('user/css/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>
    @stack('script')
    <script>
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if (Session::has('info'))
            toastr.info("{{ session('info') }}");
        @endif
        @if (Session::has('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (@$errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
</body>

</html>
