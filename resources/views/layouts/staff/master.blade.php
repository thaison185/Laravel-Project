<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>X University's Staff - @yield('title')</title>
    <link href="{{asset('staff/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Custom Css -->
    <link href="{{asset('staff/css/main.css')}}" rel="stylesheet">

    <link href="{{asset('staff/css/themes/all-themes.css')}}" rel="stylesheet" />
</head>
<body class="theme-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-blush">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->

<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

<!--Search -->
@include('layouts.staff.search')

<!-- Header -->
@include('layouts.staff.header')

<!-- Side Bar -->
@include('layouts.staff.sidebar')

<!-- Content -->
<!-- main content -->
<section class="content home">
    <div class="container-fluid full-height">
        <div class="block-header">
            <h2>@yield('title')</h2>
            <small class="text-muted">X University Application</small>
        </div>

        @yield('content')
    </div>
</section>
<!-- #END# main content -->

<div class="color-bg"></div>
<!-- JS Stuff -->
<script src="{{asset('staff/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('staff/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('staff/bundles/morphingsearchscripts.bundle.js')}}"></script> <!-- Main top morphing search -->

<script src="{{asset('staff/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script> <!-- Sparkline Plugin Js -->
<script src="{{asset('staff/plugins/chartjs/Chart.bundle.min.js')}}"></script> <!-- Chart Plugins Js -->

<script src="{{asset('staff/bundles/mainscripts.bundle.js')}}"></script><!-- Custom Js -->
<script src="{{asset('staff/js/pages/charts/sparkline.min.js')}}"></script>
@yield('js')
</body>
</html>
