@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Assign Task
@stop
{{--{{ dd($data['projects'][0]->getAllProjectsWithDetail()) }}--}}
{{--{{ dd($data['users'][1]->hasOrg($data['users'][0]->id)) }}--}}
{{--{{ dd($data['users'][1]->hasRole('abc', $data['users'][1]->id)) }}--}}

<div class="container body">
    <div class="main_container">

    @include('partials.adminAside')
    @include('partials.adminHeader')

    <!-- page content -->
        <div class="right_col" role="main">
            <div class="">

                <div class="row">
                    {{-- Add New User Form --}}
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        @if($data['employees']->count() == 0)
                            <div class="alert alert-warning" id="warning">
                                <strong>Warning!</strong> No record found.
                            </div>
                            <script>
                                setTimeout(function(){
                                    $('#projects').prop('disabled', true);
                                    $('#employees').prop('disabled', true);
                                    $('#tasks').prop('disabled', true);
                                    $('#addBtn').prop('disabled', true);
                                }, 10);

                            </script>
                        @endif

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

                        <div class="alert alert-danger" id="failure2" style="display: none;">
                            <strong>Failure!</strong> Please select a Project first!
                        </div>

                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Assign Task</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <form method="post" action="/assignTaskToEmployee" id="assignTaskForm" class="form-horizontal form-label-left">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-1 col-sm-2 col-xs-12">Projects</label>
                                                <div class="col-md-11 col-sm-10 col-xs-12">
                                                    <div class="controls">
                                                        <select id="projects" name="projects" required class="form-control col-md-7 col-xs-12"  style="width:400px;">
                                                            <option selected disabled>Select Project</option>
                                                            @foreach($data['projects'] as $project)
                                                                <option value="{{ $project->id }}" id="prj_{{ $project->id }}">{{ $project->project_title }}</option>
                                                            @endforeach
                                                        </select><br><br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Tasks</label>
                                                <div class="col-md-10 col-sm-10 col-xs-12">
                                                    <div class="controls">
                                                        <select id="tasks" disabled name="tasks" required class="form-control col-md-7 col-xs-12"  style="width:400px;">
                                                            <option selected disabled>Select Project First</option>
                                                            {{--@foreach($data['tasks'] as $task)--}}
                                                                {{--<option value="{{ $task->id }}" id="task_{{ $task->id }}">{{ $task->task_title }}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Employees</label>
                                                <div class="col-md-10 col-sm-10 col-xs-12">
                                                    <div class="controls">
                                                        <select id="employees" disabled name="employees" required class="form-control col-md-7 col-xs-12" style="width:400px;">
                                                            <option selected disabled>Select Project First</option>
                                                            {{--@foreach($data['employees'] as $employee)--}}
                                                                {{--<option value="{{ $employee->id }}" id="emp_{{ $employee->id }}">{{ $employee->username }}</option>--}}
                                                            {{--@endforeach--}}
                                                        </select>
                                                    </div>
                                                    {{ csrf_field() }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="col-md-12">
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="reset" class="btn btn-primary">Cancel</button>
                                                <button type="submit" id="addBtn" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /page content -->

        <!-- jQuery autocomplete -->
        <script>
            $(function (){
                $.get( "/getProjectsWithDetail", function( data ) {
                    window.projectsWithDetails = data;
//                    console.log(data);
                });
                $('#addBtn').prop('disabled', true);
            });

            $(document).ready(function() {
                $('.select2').select2({ placeholder : '' });


                $('button[data-select2-open]').click(function(){
                    $('#' + $(this).data('select2-open')).select2('open');
                });

                $('#addBtn').click(function (e){
                    //var emp = $('#employees').val();
                    var proj = $('#projects').val();
                    if(proj == null){
                        e.preventDefault();
//                        console.log("error");
                        $('#failure2').show();
                        setTimeout(function(){
                            $('#failure2').css('display', 'none')
                        }, 3000);
                    }
                });

                $('#projects').change(function (e){
                    $('#employees').prop('disabled', false);
                    $('#addBtn').prop('disabled', false);
                    $('#tasks').prop('disabled', false);
                    var val = $(this).val();
                    var html = '';
                    $.each(window.projectsWithDetails, function (index, value){
                        if(value.id == val){
                            $.each(value.tasks, function (key, val){
                                html += '<option value="'+val.id+'" id="task_'+val.id+'">'+val.task_title+'</option>';
                            });
                        }
                    });
                    $('#tasks').html(html);

                    var data = {
                        '_token': '{{ csrf_token() }}',
                        'project_id': val
                    };
                    $.post('/getProjectEmployees', data, function (response){
//                        console.log(response);
                        if(response.length == 0){
                            var emp = '<option selected disabled>No employee found!</option>';
                            $('#employees').html(emp);
                            $('#addBtn').prop('disabled', true);
                        } else {
                            var emp = '';
                            $.each(response, function (key, val){
                                emp += '<option value="'+val.id+'" id="emp_'+val.id+'">'+val.username+'</option>'
                            });
                            $('#employees').html(emp);
                        }
                    });

                });

                $('#tasks').change(function (e){

                });
            });
        </script>

    </div>
</div>

@endsection

@section('page_scripts')

@endsection
