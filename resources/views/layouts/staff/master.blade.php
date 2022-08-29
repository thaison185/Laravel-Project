<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>X University's Staff - @yield('title')</title>
    <link href="{{asset('staff-asset/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    @stack('css')
    <!-- Custom Css -->
    <link href="{{asset('staff-asset/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('staff-asset/css/themes/all-themes.css')}}" rel="stylesheet" />
</head>
<body class="theme-blue">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-light-blue">
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
<section class="content @yield('section-content-class')">
    <div class="container-fluid full-height">
        @yield('content-header')
        @yield('content')
    </div>
</section>
@yield('modal')
<!-- #END# main content -->
<div class="color-bg"></div>
<!-- JS Stuff -->
<script src="{{asset('staff-asset/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('staff-asset/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('staff-asset/bundles/morphingsearchscripts.bundle.js')}}"></script> <!-- Main top morphing search -->

<script src="{{asset('staff-asset/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script> <!-- Sparkline Plugin Js -->
<script src="{{asset('staff-asset/plugins/chartjs/Chart.bundle.min.js')}}"></script> <!-- Chart Plugins Js -->

<script src="{{asset('staff-asset/bundles/mainscripts.bundle.js')}}"></script><!-- Custom Js -->
<script src="{{asset('staff-asset/js/pages/charts/sparkline.min.js')}}"></script>
<script>
    $(function(){
        $(".menu .active").removeClass('active');
        $(".menu .open").removeClass('open');
        $(".ml-menu").css("display","none");
        $(".toggled").removeClass('toggled')
        $("#{{$focus}}").addClass('active');
        $("#{{$focus}}").parents(".li-parent").addClass('active').addClass('open');
        $("#{{$focus}}").parents(".ml-menu").css("display","block");
        $("#{{$focus}}").parent(".ml-menu").siblings(".menu-toggle").addClass('toggled');
    });
</script>
@stack('js')
</body>
</html>
