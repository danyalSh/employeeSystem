@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Roles
@stop

<div class="container body">
    <div class="main_container">

    {{--        {{ dd($data) }}--}}

    @include('partials.adminAside')
    @include('partials.adminHeader')

    <!-- page content -->
        <div class="right_col" role="main">
            <div class="">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div id="status"  style="display: none;"></div>

                    </div>
                </div>


            </div>
        </div>
        <!-- /page content -->

    </div>
</div>

@endsection