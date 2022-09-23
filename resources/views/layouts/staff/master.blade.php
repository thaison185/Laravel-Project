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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- Chart Plugins Js -->

<script src="{{asset('staff-asset/bundles/mainscripts.bundle.js')}}"></script><!-- Custom Js -->

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

<script>
    $(function(){
        function debounce(callback, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(function () { callback.apply(this, args); }, wait);
            };
        }

        $(".morphsearch-form").submit(function (e) {
            e.preventDefault();
            let actURL = $(this).attr("action");
            const formData = new FormData(this);
            if ($(this).valid()) {
                callAJAX(actURL, formData);
            }
        });
        function callAJAX(actURL,formData=''){
            $.ajax({
                type: "POST",
                url: actURL,
                data: formData,
                dataType: "json",
                success: function(response) {
                    if(response.status==="success"){
                        $('.morphsearch-content').removeClass('d-none')
                        if(response.lecturers.length>0) {
                            $('#search-lecturer').empty();
                            $('#search-lecturer').append($('<h2>Lecturers</h2>'))
                            response.lecturers.forEach(each=>{
                                let avatar;
                                if(each.avatar==null) avatar='{{asset('/img/staff/placeholder.jpg')}}'
                                else avatar = '{{asset('/storage')}}'+'/'+each.avatar
                                $('#search-lecturer').append('<a class="dummy-media-object" href="#"><img class="round" src="'+avatar+'" alt="" style="height: 50px"/><h3>'+each.name+'</h3></a>')
                            })
                        }
                        if(response.students.length>0) {
                            $('#search-student').empty();
                            $('#search-student').append($('<h2>Students</h2>'))
                            response.students.forEach(each=>{
                                let avatar;
                                if(each.avatar==null) avatar='{{asset('/img/staff/placeholder.jpg')}}'
                                else avatar = '{{asset('/storage')}}'+'/'+each.avatar
                                $('#search-student').append('<a class="dummy-media-object" href="#"><img class="round" src="'+avatar+'" alt="" style="height: 50px"/><h3>'+each.name+'</h3></a>')
                            })
                        }
                        if(response.staff.length>0) {
                            $('#search-staff').empty();
                            $('#search-staff').append($('<h2>Staff</h2>'))
                            response.staff.forEach(each=>{
                                let avatar;
                                if(each.avatar==null) avatar='{{asset('/img/staff/placeholder.jpg')}}'
                                else avatar = '{{asset('/storage')}}'+'/'+each.avatar
                                $('#search-staff').append('<a class="dummy-media-object" href="#"><img class="round" src="'+avatar+'" alt="" style="height: 50px"/><h3>'+each.name+'</h3></a>')
                            })
                        }
                    }else{
                        if(response.status==="empty"){
                            $('.morphsearch-content').addClass('d-none')
                            $('#search-lecturer').empty();
                            $('#search-student').empty();
                            $('#search-staff').empty();
                        }
                    }
                },
                error: function (response){
                    let error ='';
                    if(response.responseJSON.errors){
                        let errors = Object.values(response.responseJSON.errors);
                        if(Array.isArray(errors)){
                            errors.forEach(function (each){
                                each.forEach(function(message){
                                    error+=`${message}<br>`;
                                });
                            });
                        }
                        else{
                            error+=`${errors}`;
                        }
                    }
                    else {
                        error = response.responseJSON.message;
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                enctype: "multipart/form-data",
                async: false,
            });
        }

        $('.morphsearch-input').on('keyup',debounce( () => {
            let search = $('.morphsearch-input').val();
            $('.morphsearch-form').submit();
        }, 500))
    });
</script>

@stack('js')
</body>
</html>
