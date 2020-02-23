<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title', config('app.name'))</title>
    <meta name="_token" content="{{csrf_token()}}">
    <!-- Favicon-->
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/admin/css/app.css')}}">
    <!-- Custom Css -->
    @stack('style')
</head>

<body class="theme-blush">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/loader.svg')}}" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
<div id="search">
    <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
    <form>
        <input type="search" value="" placeholder="Search..." />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<!-- Right Icon menu Sidebar -->
@include('admin.layouts.menu_sidebar')


<!-- Left Sidebar -->
@include('admin.layouts.left_sidebar')

<!-- Right Sidebar -->
@include('admin.layouts.right_sidebar')


<!-- Main Content -->
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>@yield('title')</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="zmdi zmdi-home"></i> {{config('app.name')}}</a></li>
                        @if (trim($__env->yieldContent('parentPageTitle')))
                            <li class="breadcrumb-item">@yield('parentPageTitle')</li>
                        @endif
                        @if (trim($__env->yieldContent('title')))
                            <li class="breadcrumb-item active">@yield('title')</li>
                        @endif
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</section>
<!-- Jquery Core Js -->
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->

<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
@stack('script')
</body>
</html>
