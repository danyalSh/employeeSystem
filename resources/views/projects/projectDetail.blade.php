@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Project Details
@stop

{{--{{ dd($data) }}--}}

{{--@foreach($data[0]->tasks as $task)--}}
    {{--<p>{{ $task->task_title }}</p>--}}
{{--@endforeach--}}

{{--{{ exit }}--}}
<div class="container body">
    <div class="main_container">

    @include('partials.adminAside')
    @include('partials.adminHeader')

    <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        @if(Session::has('success'))
                            <div class="alert alert-success" id="success">
                                <strong>Success!</strong> {{ Session::get('success') }}
                            </div>
                            <script>
                                setTimeout(function(){
                                    $('#success').css('display', 'none')
                                }, 3000);
                            </script>
                        @endif
                        @if(Session::has('failure'))
                            <div class="alert alert-danger" id="failure">
                                <strong>Failure!</strong> {{ Session::get('failure') }}
                            </div>
                            <script>
                                setTimeout(function(){
                                    $('#failure').css('display', 'none')
                                }, 3000);
                            </script>
                        @endif
                    </div>
                </div>

                {{-- Display Project Details --}}

                <div class="row prjRow" >
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>{{ $data[0]->project_title }}</h2><br>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">{{ $data[0]->project_desc }}</p>
                                <p><b>Organization:</b> <span>{{ $data[0]->organization[0]->name }}</span></p>
                                <p><b>Total Tasks:</b> <span>{{ count($data[0]->tasks) }}</span></p>
                                <p><b>Team Members:</b>
                                    @if(count($data[0]->user) > 0)
                                        @foreach($data[0]->user as $user)
                                            <span>{{ $user->username }}, </span>
                                        @endforeach
                                    @else
                                        <span id="taskEmp">
                                            Unassigned. <a href="assign-project">Assign Now!</a>
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tasks</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <!-- start Tasks list -->
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%">ID</th>
                                        <th style="width: 20%">Task Title</th>
                                        {{--<th>Project</th>--}}
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th style="width: 20%">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data[0]->tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>
                                                <a>{{ $task->task_title }}</a>
                                                <br />
                                                <small>{{  str_limit($task->task_desc, 30) }}</small>
                                            </td>
{{--                                            <td>{{  $task->projects[0]->project_title ? $task->projects[0]->project_title : '' }}</td>--}}
                                            <td>{{ $task->status[0]->name ? $task->status[0]->name : '' }}</td>
                                            <td>
                                                <ul class="list-inline members">
                                                    @if(count($task->employees) == 0)
                                                        <li>Unassigned. <a href="/assign-task">Assign Now!</a></li>
                                                    @else
                                                        <li>
                                                            <img src="{{ asset('images/user.png') }}" class="avatar" title="{{ $task->employees[0]->username }}" alt="{{ $task->employees[0]->username }}">
                                                            <small style="padding: 5px 10px;"> {{ $task->employees[0]->username }}</small>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="/report/{{ $task->id }}" class="btn btn-primary btn-xs" data-id="{{ $task->id }}">
                                                    <i class="fa fa-folder"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- end Tasks list -->
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- /page content -->

    </div>
</div>
@endsection