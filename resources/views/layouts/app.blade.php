<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>{{ config('app.name', 'Virtual Base') }}</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="employee management system">
    <!-- END META -->
    @if(Request::path() != 'register')
        <!-- BEGIN STYLESHEETS -->
        <link href="{{asset('css/materialize.css')}}" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="{{asset('css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection">

        <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
        <link href="{{asset('css/prism.css')}}" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="{{asset('css/perfect-scrollbar.css')}}" type="text/css" rel="stylesheet" media="screen,projection">
        <!-- <link href="{{asset('css/chartist.min.css')}}" type="text/css" rel="stylesheet" media="screen,projection"> -->
        <!-- END STYLESHEETS -->

        <!-- ================================================
        Scripts
        ================================================ -->

        <!-- jQuery Library -->
        <script type="text/javascript" src="{{asset('js/jquery-1.11.2.min.js')}}"></script>
        <!--materialize js-->
        <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
        <!--prism-->
        <script type="text/javascript" src="{{asset('js/prism.js')}}"></script>
        <!--scrollbar-->
        <script type="text/javascript" src="{{asset('js/perfect-scrollbar.min.js')}}"></script>
        <!-- chartist -->
        <!-- <script type="text/javascript" src="{{asset('js/chartist.min.js')}}"></script> -->
        <!--plugins.js - Some Specific JS codes for Plugin Settings-->
        <script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>

    @endif
    <meta>
</head>

<body style="background-color:#ffffff;">
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<style>
    .section {
        padding-top: 42px !important
    }
</style>
<script>
    var route = "{{\Route::current()->getName()}}";
</script>
<!-- End Page Loading -->
    @yield('content')

</body>
</html>