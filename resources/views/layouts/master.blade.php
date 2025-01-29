<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="horizontal" data-topbar="light" data-sidebar="light"
    data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="interactive"
    data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Aloha Reseller </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('layouts.head-css')
</head>

<body data-bs-theme="light" data-topbar="light" data-sidebar="light">    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
{{--        @include('layouts.sidebar')--}}
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

                    @yield('content')

    </div>

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

</html>
