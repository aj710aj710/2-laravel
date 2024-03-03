<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ getOption('app_name') }} - @stack('title' ?? '')</title>
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
        <meta property="og:site_name" content="{{getOption('app_name') }}">

        <!-- Twitter Card meta tags for Twitter sharing -->
        <meta name="twitter:card" content="{{ __('zaisub') }}">
        <meta name="twitter:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
        <meta name="twitter:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
        <meta name="twitter:image" content="{{ $metaData['og_image'] ?? getSettingImage('app_logo') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}" />
    @endif
    <link rel="icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}">
    <!-- fonts file -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    @include('user.layouts.style')
    @stack('style')
</head>

<body>
    @yield('content')
    @include('user.layouts.script')
</body>

</html>
