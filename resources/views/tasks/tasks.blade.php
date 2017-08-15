@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Tasks
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tasks</h2>
                                <button data-toggle="modal" data-target="#addTaskModal" class="btn btn-info plus"><i class="fa fa-plus-circle"></i>Add</button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <!-- start Tasks list -->
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%">ID</th>
                                        <th style="width: 20%">Task Title</th>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th style="width: 20%">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['tasks'] as $task)
                                            <tr>
                                                <td>{{ $task->id }}</td>
                                                <td>
                                                    <a>{{ $task->task_title }}</a>
                                                    <br />
                                                    <small>{{  str_limit($task->task_desc, 30) }}</small>
                                                </td>
                                                <td>{{  $task->projects[0]->project_title ? $task->projects[0]->project_title : '' }}</td>
                                                <td>{{ $task->status[0]->name ? $task->status[0]->name : '' }}</td>
                                                <td>
                                                    <ul class="list-inline members">
                                                        @if($task->employees->count() == 0)
                                                            <li>No employee assigned to this task.<br> <a href="/assign-task">Assign Now!</a></li>
                                                        @else
                                                            <li>
                                                                <img src="{{ asset('images/user.png') }}" class="avatar" title="{{ $task->employees[0]->username }}" alt="{{ $task->employees[0]->username }}">
                                                                <small style="padding: 5px 10px;"> {{ $task->employees[0]->username }}</small>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{--<a href="javascript:void(0)" class="viewTask btn btn-primary btn-xs" data-id="{{ $task->id }}" data-toggle="modal" data-target="#viewTaskModal">--}}
                                                        {{--<i class="fa fa-folder"></i> View--}}
                                                    {{--</a>--}}

                                                    <a href="/report/{{ $task->id }}" class="btn btn-primary btn-xs" data-id="{{ $task->id }}">
                                                        <i class="fa fa-folder"></i> View
                                                    </a>

                                                    <a href="javascript:void(0)" class="updateTask btn btn-info btn-xs" data-id="{{ $task->id }}" data-toggle="modal" data-target="#addTaskModal">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
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

        <!-- Add Task Modal -->
        <div id="addTaskModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="taskModal">Add Task</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <br />
                                        <form id="taskForm" data-parsley-validate class="form-horizontal form-label-left">

                                            <div class="form-group form-field">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Project</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select id="task_project" name="task_project" required class="form-control col-md-7 col-xs-12">
                                                        <option selected disabled>Select Project</option>
                                                        @foreach($data['projects'] as $project)
                                                            <option value="{{ $project->id }}">{{ $project->project_title }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p class="help-block error" id="err_task_project"></p>
                                                </div>
                                            </div>

                                            <div class="form-group form-field">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="task_title">Title <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="task_title" name="task_title"  class="form-control col-md-7 col-xs-12">
                                                    {{ csrf_field() }}
                                                    <p class="help-block error" id="err_task_title"></p>
                                                </div>
                                            </div>
                                            <div class="form-group form-field">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="task_desc">Description <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea class="form-control" rows="3" name="task_desc" id="task_desc" maxlength="500"></textarea>
                                                    <small>Maximum limit: 500 characters</small>
                                                    <p class="help-block error" id="err_task_desc"></p>
                                                </div>
                                            </div>

                                            <div class="form-group form-field">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select id="task_status" name="task_status" required class="form-control col-md-7 col-xs-12">
                                                        @foreach($data['status'] as $status)
                                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p class="help-block error" id="err_task_status"></p>
                                                </div>
                                            </div>

                                            <div class="form-group form-field">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Assign To</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select id="task_employee" disabled name="task_employee" required class="select2_single form-control" style="width:100%;" >
                                                        <option disabled selected value="">Select Employee</option>
                                                        {{--@foreach($data['employees'] as $employee)--}}
                                                            {{--<option value="{{ $employee->id }}">{{ $employee->username }}</option>--}}
                                                        {{--@endforeach--}}
                                                    </select>
                                                    <p class="help-block error" id="err_task_status"></p>
                                                </div>
                                            </div>

                                            <input type="hidden" id="updateTaskField" name="update" value="0" >
                                            <input type="hidden" id="updateTaskID" name="task_id" value="" >

                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" id="addTask" class="btn btn-success">Create</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>


        {{-- Delete Task Modal --}}

        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete Task</h4>
                    </div>
                    <div class="modal-body">
                        <p> Are you sure you want to delete this task?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDel" data-dismiss="modal">Delete</button>
                    </div>
                </div>

            </div>
        </div>


        {{-- View Project Modal --}}

        <div id="viewTaskModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="taskTitle"></h4>
                        <small>Project: <strong id="taskProject"></strong></small><br>
                        <small>Status: <strong id="taskStatus"></strong></small><br>
                        <small>Assigned To: <strong id="taskAssignedTo"></strong></small>
                    </div>
                    <div class="modal-body">
                        <p><strong>Description:</strong></p>
                        <p id="taskDesc"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


        <!-- jQuery autocomplete -->
        <script>
            $(document).ready(function() {
                // Add Project

                $('#addTask').click(function (e){
                    e.preventDefault();
                    $.ajax({
                        url: '/addTask',
                        type: "post",
                        data: $('#taskForm').serialize(),

                        success: function (response){
                            console.log('success fn: ', response);
                            if(response.status == 'success'){
                                $('#addTaskModal').modal('hide');
                                var html = '<div class="alert alert-success"><strong>Success!</strong> '+ response.message +' </div>';
                                $('#status').html(html);
                                $('#status').show();

                                setTimeout(function(){
                                    $('#status').css('display', 'none');
                                    window.location.reload();
                                }, 2000);

                            } else{
                                var html = '<div class="alert alert-danger"><strong>Failure!</strong> Something went wrong. Please try again.</div>';
                                $('#status').html(html);
                                $('#status').show();

                                setTimeout(function(){
                                    $('#status').css('display', 'none')
                                }, 3000);
                            }
                        },
                        error: function (response){
                            //console.log('error fn: ', response);
                            if(response.statusText == "Unprocessable Entity"){
//                                $('.form-field').addClass('has-error');
                                var errors = JSON.parse(response.responseText);
                                $.each(errors, function (index, value){
                                    $('#err_'+index).text(value);
                                });
                            }
                        }
                    });
                });

                // Delete Project

                $('.delProject').click(function (e){
                    thisRow = $(this);
                    window.task_id = $(this).data('id');
                });

                // Confirm Delete Project

                $('#confirmDel').click(function(e){
                    e.preventDefault();
                    $.ajax({
                        url: '/deleteTask',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'project_id': window.task_id
                        },
                        type: 'POST',

                        success: function (response){
                            console.log('success fn: ', response);
                            if(response == 1){
                                thisRow.closest('tr').remove();
                                window.id = null;
                            }
                        },
                        error: function (response){
                            console.log('error fn: ', response);
                        }
                    });
                });

                // Edit Project

                $('.updateTask').click(function (e){
                    var id = $(this).data('id');
                    $('#projectModal').text('Update Project');

                    $.ajax({
                        url: '/getTaskAdmin',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'task_id': id
                        },

                        success: function (response){
                            console.log('success fn: ', response);
                            $('#task_title').val(response['taskDetail'].task_title);
                            $('#task_desc').val(response['taskDetail'].task_desc);
                            var project = response['taskDetail'].projects[0].project_title;
                            var projectID = response['taskDetail'].projects[0].id;
                            var status = response['taskDetail'].status[0].name;
                            var statusID = response['taskDetail'].status[0].id;
                            $('#task_project').val(projectID);
                            $('#task_status').val(statusID);
                            var projectEmployees = response['projectEmployees'];

                            if(projectEmployees.length > 0){
                                var taskEmployee = response['taskDetail'].employees[0].id;
                                var html = '';

                                for(var i=0; i<projectEmployees.length; i++){
                                    html += '<option value="'+projectEmployees[i].id+'">'+projectEmployees[i].username+'</option>';
                                    if(projectEmployees[i].id == taskEmployee){
                                        empID = taskEmployee;
                                    }
                                }
                                $('#task_employee').prop('disabled', false);
                                $('#task_employee').html(html);
                                $('#task_employee').val(empID);
                            } else {
                                $('#task_employee').prop('disabled', true);
                                $('#task_employee').html('<option selected disabled>No Employees Found!</option>');
                            }
                            $('#updateTaskField').val('1');
                            $('#updateTaskID').val(response['taskDetail'].id);
                        },
                        error: function (response){
                            console.log('error fn: ', response);
                        }
                    });

                });

                // Get Project Employees

                $('#task_project').change(function (e){
                    var val = $(this).val();
                    $('#task_employee').prop('disabled', false);
                    $.ajax({
                        url: '/getProjectEmployees',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'project_id': val
                        },

                        success: function (response){
//                            console.log(response);
                            if(response.length > 0){
                                var data = response;
                                var html = '';
                                for(var i=0; i<data.length; i++){
                                    html += '<option value="'+data[i].id+'">'+data[i].username+'</option>';
                                }
                                $('#task_employee').html(html);
                            } else {
                                var html = '<option disabled selected>No Employee Found!</option>';
                                $('#task_employee').html(html);
                                $('#task_employee').prop('disabled', true);
                            }
                        },
                        error: function (response){
                            console.log(response);
                        }
                    });
                });

                $('#addTaskModal').on('hidden.bs.modal', function (e) {
                    $('#taskModal').text('Add Project');
                    $('#taskForm')[0].reset();
                    $("select option").each(function(e){
                        $(this).removeAttr("selected","selected");
                    });
                    //$('.select2_single').select2("val", "0");
                    $('#updateTaskField').val('0');
                    $('#updateTaskID').val('');
                    $('#task_employee').html('');
                    $('#task_employee').prop('disabled', true);
                });

                $('.viewTask').click(function (e){
                    var id = $(this).data('id');
                    $.ajax({
                        url: '/getTaskAdmin',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'task_id': id
                        },

                        success: function (response){
                            console.log('success fn: ', response);
                            $('#taskTitle').text(response['taskDetail'].task_title);
                            $('#taskDesc').text(response['taskDetail'].task_desc);
                            $('#taskProject').text(response['taskDetail'].projects[0].project_title);
                            $('#taskStatus').text(response['taskDetail'].status[0].name);
                            $('#taskAssignedTo').text(response['taskDetail'].employees[0].username);
                        },
                        error: function (response){
                            console.log('error fn: ', response);
                        }
                    });
                });

            });
        </script>

    </div>
</div>
@endsection