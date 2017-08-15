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

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Roles</h2>
                                <button data-toggle="modal" data-target="#addRoleModal" class="btn btn-info plus"><i class="fa fa-plus-circle"></i>Add</button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- start project list -->
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%">ID</th>
                                        <th style="width: 20%">Role Name</th>
                                        <th style="width: 20%">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['roles'] as $key=>$role)
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="updateRole btn btn-info btn-xs" data-id="{{ $role->id }}" data-toggle="modal" data-target="#addRoleModal">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)" class="delRole btn btn-danger btn-xs" data-id="{{ $role->id }}" data-name="{{ $role->name }}"  data-toggle="modal" data-target="#deleteModal">
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

        <!-- Add Role Modal -->
        <div id="addRoleModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="roleModal">Add Project</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">
                                        <br />
                                        <form method="post" action="/addProject" id="roleForm" data-parsley-validate class="form-horizontal form-label-left">

                                            <div class="form-group form-field {{ $errors->has('project_title') ? 'has-error' : ''}}">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_name">Role Name <span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="role_name" name="role_name"  class="form-control col-md-7 col-xs-12">
                                                    {{ csrf_field() }}
                                                    <p class="help-block" id="err_role_name"></p>
                                                    {{-- {!! $errors->first('project_title', '<p class="help-block">:message</p>') !!}--}}
                                                </div>
                                            </div>

                                            <input type="hidden" id="updateRoleField" name="update" value="0" >
                                            <input type="hidden" id="updateRoleID" name="role_id" value="" >

                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" id="addRole" class="btn btn-success">Create</button>
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
                        <h4 class="modal-title">Are you sure?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Role: <strong><span style="color: #d9534f;" id="roleName"></span></strong> will be completely removed and <span style="color: #d9534f;">All</span> the users with this role will be <span style="color: #d9534f;">Inactive</span>.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDel" data-dismiss="modal">Delete</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>


<script>
$(document).ready(function (){
    // Add Project
    $('#addRole').click(function (e){
        e.preventDefault();
        $.ajax({
            url: '/addRole',
            type: "post",
            data: $('#roleForm').serialize(),

            success: function (response){
                console.log('success fn: ', response);
                if(response.status == 'success'){
                    $('#addRoleModal').modal('hide');
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
                console.log('error fn: ', response);
                $('.form-field').addClass('has-error');
                var errors = JSON.parse(response.responseText);
                $.each(errors, function (index, value){
                    $('#err_'+index).text(value);
                });
            }
        });
    });

    // Edit Role
    $('.updateRole').click(function (e){
        var id = $(this).data('id');
        $('#roleModal').text('Update Role');

        $.ajax({
            url: '/getRoleById',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'role_id': id
            },
            success: function (response){
                console.log('success fn: ', response);
                $('#role_name').val(response.name);
                $('#updateRoleField').val('1');
                $('#updateRoleID').val(response.id);
            },
            error: function (response){
                console.log('error fn: ', response);
            }
        });

    });

    // Delete Project
    $('.delRole').click(function (e){
        thisRow = $(this);
        window.role_id = $(this).data('id');
        role_name = $(this).data('name');
        $('#roleName').text(role_name);
    });

    // Confirm Delete Project
    $('#confirmDel').click(function(e){
        e.preventDefault();
        $.ajax({
            url: '/deleteRole',
            type: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'role_id': window.role_id
            },
            success: function (response){
                console.log('success fn: ', response);
                if(response.status == 'success'){
                    thisRow.closest('tr').remove();
                    window.role_id = null;

                    $('#deleteModal').modal('hide');
                    var html = '<div class="alert alert-success"><strong>Success!</strong> '+ response.message +' </div>';
                    $('#status').html(html);
                    $('#status').show();

                    setTimeout(function(){
                        $('#status').css('display', 'none');
                        window.location.reload();
                    }, 2000);
                } else{
                    window.role_id = null;
                    var html = '<div class="alert alert-danger"><strong>Failure!</strong> Something went wrong. Please try again.</div>';
                    $('#status').html(html);
                    $('#status').show();

                    setTimeout(function(){
                        $('#status').css('display', 'none')
                    }, 3000);
                }
            },
            error: function (response){
                console.log('error fn: ', response);
            }
        });
    });

    // Modal Close Function
    $('#addRoleModal').on('hidden.bs.modal', function (e) {
        $('#roleModal').text('Add Role');
        $('#roleForm')[0].reset();
        $('#updateRoleField').val('0');
        $('#updateRoleID').val('');
    });
});

</script>



@endsection