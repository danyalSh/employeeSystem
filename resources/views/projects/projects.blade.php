@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Projects
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
                                <h2>Projects</h2>
                                <button data-toggle="modal" data-target="#addProjectModal" class="btn btn-info plus"><i class="fa fa-plus-circle"></i>Add</button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- start project list -->
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%">ID</th>
                                        <th style="width: 20%">Project Name</th>
                                        <th>Team Members</th>
                                        <th>Organization</th>
                                        {{--<th>Status</th>--}}
                                        <th style="width: 20%">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['projects'] as $project)
                                            <tr>
                                                <td>{{ $project->id }}</td>
                                                <td>
                                                    <a>{{ $project->project_title }}</a>
                                                    <br />
                                                    <small>{{  str_limit($project->project_desc, 30) }}</small>
                                                </td>
                                                <td>
                                                    <ul class="list-inline members">
                                                        @if($project->user()->get()->count() == 0)
                                                            <li>Unassigned. <a href="/assign-project">Assign Now!</a></li>
                                                        @else
                                                            @foreach($project->user()->get() as $employee)
                                                                <li>
                                                                    <img src="{{ asset('images/user.png') }}" class="avatar" title="{{ $employee->username }}" alt="{{ $employee->username }}">
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </td>
                                                <td>{{ $project->getProjectOrganization($project)->name }}</td>
                                                <td>
                                                    {{--<a href="javascript:void(0)" class="viewProject btn btn-primary btn-xs" data-id="{{ $project->id }}" data-toggle="modal" data-target="#viewProjectModal">--}}
                                                        {{--<i class="fa fa-folder"></i> View--}}
                                                    {{--</a>--}}

                                                    <a href="/project/{{ $project->id }}" class="btn btn-primary btn-xs" data-id="{{ $project->id }}">
                                                        <i class="fa fa-folder"></i> View
                                                    </a>

                                                    <a href="javascript:void(0)" class="updateProject btn btn-info btn-xs" data-id="{{ $project->id }}" data-toggle="modal" data-target="#addProjectModal">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)" class="delProject btn btn-danger btn-xs" data-id="{{ $project->id }}" data-name="{{ $project->project_title }}" data-org="{{ $project->getProjectOrganization($project) }}"  data-toggle="modal" data-target="#deleteModal">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- end project list -->

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /page content -->

    <!-- Add Project Modal -->
    <div id="addProjectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="projectModal">Add Project</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <br />
                                    <form method="post" action="/addProject" id="projectForm" data-parsley-validate class="form-horizontal form-label-left">

                                        <div class="form-group form-field {{ $errors->has('project_title') ? 'has-error' : ''}}">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_title">Title <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="project_title" name="project_title"  class="form-control col-md-7 col-xs-12">
                                                {{ csrf_field() }}
                                                <p class="help-block" id="err_project_title"></p>
{{--                                                {!! $errors->first('project_title', '<p class="help-block">:message</p>') !!}--}}
                                            </div>
                                        </div>
                                        <div class="form-group form-field {{ $errors->has('project_desc') ? 'has-error' : ''}}">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="project_desc">Description <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea class="form-control" rows="3" name="project_desc" id="project_desc" maxlength="300"></textarea>
                                                <small>Maximum limit: 300 characters</small>
                                                <p class="help-block" id="err_project_desc"></p>
                                            </div>
                                        </div>

                                        <div class="form-group form-field {{ $errors->has('project_org') ? 'has-error' : ''}}">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Organization</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select id="project_org" name="project_org" required class="form-control col-md-7 col-xs-12">
                                                    @foreach($data['org'] as $org)
                                                        <option value="{{ $org->id }}">{{ $org->name }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="help-block" id="err_project_org"></p>
                                            </div>
                                        </div>
                                        <input type="hidden" id="updateProjectField" name="update" value="0" >
                                        <input type="hidden" id="updateProjectID" name="project_id" value="" >

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" id="addProject" class="btn btn-success">Create</button>
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


    {{-- Delete Project Modal --}}

    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Project</h4>
                </div>
                <div class="modal-body">
                    <p> Are you Sure? <br><strong><span style="color: #d9534f;" id="projectName"></span></strong> will be completely removed from <strong><span style="color: #d9534f;" id="projectOrg"></span></strong> Organization.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDel" data-dismiss="modal">Delete</button>
                </div>
            </div>

        </div>
    </div>


    {{-- View Project Modal --}}

    <div id="viewProjectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="prjTitle"></h4><br>
                    <small>Organization: <strong id="prjOrg"></strong></small>
                </div>
                <div class="modal-body">
                    <p><strong>Description:</strong></p>
                    <p id="prjDesc"></p>
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

                $('#addProject').click(function (e){
                    e.preventDefault();
                    $.ajax({
                        url: '/addProject',
                        type: "post",
                        data: $('#projectForm').serialize(),

                        success: function (response){
                            console.log('success fn: ', response);
                            if(response.status == 'success'){
                                $('#addProjectModal').modal('hide');
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
//                            console.log('error fn: ', response);
                            $('.form-field').addClass('has-error');
                            var errors = JSON.parse(response.responseText);
                            $.each(errors, function (index, value){
                                $('#err_'+index).text(value);
                            });

                        }
                    });
                });

                // Delete Project

                $('.delProject').click(function (e){
                    thisRow = $(this);
                    window.project_id = $(this).data('id');
                    project_name = $(this).data('name');
                    project_org = $(this).data('org');

                    $('#projectName').text(project_name);
                    $('#projectOrg').text(project_org.name);
                });

                // Confirm Delete Project

                $('#confirmDel').click(function(e){
                    e.preventDefault();
                    $.ajax({
                        url: '/deleteProject',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'project_id': window.project_id
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

                $('.updateProject').click(function (e){
                    var id = $(this).data('id');
                    $('#projectModal').text('Update Project');

                    $.ajax({
                        url: '/getProject',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'project_id': id
                        },
                        type: 'POST',

                        success: function (response){
//                            console.log('success fn: ', response);
                            $('#project_title').val(response.project.project_title);
                            $('#project_desc').val(response.project.project_desc);
                            $("select option").each(function(e){
                                if ($(this).text() == response.projectOrg.name){
                                    $(this).attr("selected","selected");
                                }
                            });
                            $('#updateProjectField').val('1');
                            $('#updateProjectID').val(response.project.id);
                        },
                        error: function (response){
                            console.log('error fn: ', response);
                        }
                    });

                });

                $('#addProjectModal').on('hidden.bs.modal', function (e) {
                    $('#projectModal').text('Add Project');
                    $('#projectForm')[0].reset();
                    $("select option").each(function(e){
                        console.log('removed attr');
                        $(this).removeAttr("selected","selected");
                    });
                    $('#updateProjectField').val('0');
                    $('#updateProjectID').val('');
                });

                $('.viewProject').click(function (e){
                    var id = $(this).data('id');
                    $.ajax({
                        url: '/getProject',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'project_id': id
                        },

                        success: function (response){
//                            console.log('success fn: ', response);
                            $('#prjTitle').text(response.project.project_title);
                            $('#prjDesc').text(response.project.project_desc);
                            $('#prjOrg').text(response.projectOrg.name);
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