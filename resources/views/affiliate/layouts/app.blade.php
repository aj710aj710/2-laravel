<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ getOption('app_name') }} - @stack('title' ?? '')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}">

    <!-- fonts file -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    @include('affiliate.layouts.style')
</head>

<body>
    <!-- Pre Loader Area start -->
    @if (getOption('app_preloader_status', 0) == STATUS_ACTIVE)
        <div id="preloader">
            <div id="preloader_status">
                <img src="{{ getSettingImage('app_preloader') }}" alt="{{ getOption('app_name') }}" />
            </div>
        </div>
    @endif
    <!-- Main Content -->
    <div class="zMain-wrap">
        <!-- Sidebar -->
        @include('affiliate.layouts.sidebar')
        <!-- Main Content -->
        <div class="zMainContent zMain-header-before-1">
            <!-- Header -->
            @include('affiliate.layouts.header')
            <!-- Content -->
            @yield('content')
        </div>
    </div>
    <!-- js file  -->
    @include('affiliate.layouts.script')
</body>

</html>
