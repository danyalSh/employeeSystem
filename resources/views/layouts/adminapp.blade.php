<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


        @if(Auth::user() && Auth::user()->is_admin)
            <title>Admin|{{ config('app.name', 'Virtual Base') }}</title>
        @else
            <title>Employee|{{ config('app.name', 'Virtual Base') }}</title>
        @endif

    <!-- Bootstrap -->
    <link href="{{asset('/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/select2-bootstrap.css')}}" rel="stylesheet">
{{--    <link href="{{asset('/css/select2.css')}}" rel="stylesheet">--}}
    <link href="{{asset('/admin/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/css/nprogress.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/css/green.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('/admin/css/custom.css')}}" rel="stylesheet">
{{--    <link href="{{asset('css/tabelizer.css')}}" type="text/css" rel="stylesheet" media="screen,projection">--}}

</head>

@yield('body')


</html>
