@extends('layouts.adminapp')
@section('body')
    @if (\Route::current()->getName() == 'login')
        <body class="login">
        @yield('content')
        </body>
    @else
        <body class="nav-md">
        {{--https://github.com/devbridge/jQuery-Autocomplete--}}
        <script src="{{asset('/admin/js/jquery.min.js')}}"></script>

        @yield('content')

        {{--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>--}}
        <script src="{{asset('/admin/js/jquery.autocomplete.min.js')}}"></script>

        <script src="{{asset('/admin/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('/admin/js/fastclick.js')}}"></script>
        <script src="{{asset('/admin/js/nprogress.js')}}"></script>
        <script src="{{asset('/admin/js/Chart.min.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('/admin/js/raphael.min.js')}}"></script>
        <script src="{{asset('/admin/js/morris.min.js')}}"></script>
        <script src="{{asset('/admin/js/gauge.min.js')}}"></script>
        <script src="{{asset('/admin/js/bootstrap-progressbar.min.js')}}"></script>
        <script src="{{asset('/admin/js/icheck.min.js')}}"></script>
        <script src="{{asset('/admin/js/skycons.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.pie.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.time.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.orderBars.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.flot.spline.min.js')}}"></script>
        <script src="{{asset('/admin/js/curvedLines.js')}}"></script>
        <script src="{{asset('/admin/js/date.js')}}"></script>
        <script src="{{asset('/admin/js/moment.min.js')}}"></script>
        <script src="{{asset('/admin/js/daterangepicker.js')}}"></script>
        <script src="{{asset('/admin/js/select2.full.min.js')}}"></script>

        <script src="{{asset('/admin/js/custom.js')}}"></script>


        <script src="{{asset('/admin/js/jquery.hotkeys.js')}}"></script>
        <script src="{{asset('/admin/js/jquery.tagsinput.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-wysiwyg.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/prettify.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/async.js') }}"></script>
        @yield('page_script')

        </body>
    @endif
@endsection