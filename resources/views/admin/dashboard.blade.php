@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
    @section('title')
        Dashboard

    @stop

    <div class="container body">
        <div class="main_container">

        @include('partials.adminAside')
        @include('partials.adminHeader')

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="row top_tiles">
                        @if(\Auth::user()->hasRole('Super Admin') || \Auth::user()->hasRole('Admin'))
                            @if(\Auth::user()->hasRole('Super Admin'))
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/organizations" class="tile-stats">
                                    <div class="icon"><i class="fa fa-sitemap"></i></div>
                                    <div class="count">{{ $organizations }}</div>
                                    <h3>Organizations</h3>
                                    <p>Manage organizations</p>
                                </a>
                            </div>
                            @endif
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/projects" class="tile-stats">
                                    <div class="icon"><i class="fa fa-tasks"></i></div>
                                    <div class="count">{{ $projects }}</div>
                                    <h3>Projects</h3>
                                    <p>Manage projects</p>
                                </a>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/employees" class="tile-stats">
                                    <div class="icon"><i class="fa fa-users"></i></div>
                                    <div class="count">{{ $users }}</div>
                                    <h3>Employees</h3>
                                    <p>Manage employees</p>
                                </a>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/tasks" class="tile-stats">
                                    <div class="icon"><i class="fa fa-file-text"></i></div>
                                    <div class="count">{{ $tasks }}</div>
                                    <h3>Tasks</h3>
                                    <p>Manage Tasks</p>
                                </a>
                            </div>
                        @else
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a href="/tasks" class="tile-stats">
                                    <div class="icon"><i class="fa fa-file-text"></i></div>
                                    <div class="count">{{ $tasks }}</div>
                                    <h3>Tasks</h3>
                                    <p>Manage Tasks</p>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /page content -->


        </div>
    </div>
@endsection