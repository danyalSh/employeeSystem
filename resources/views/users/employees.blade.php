@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
    @section('title')
        Employees
    @stop

{{-- {{ dd($data['roles']) }}--}}

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

                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Add Employee</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" action="/addEmployee" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                        <div class="form-group {{ $errors->has('employee_fname') ? 'has-error' : ''}}">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="employee_fname">First Name <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="employee_fname" name="employee_fname"  class="form-control col-md-7 col-xs-12">
                                                {!! $errors->first('employee_fname', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('employee_lname') ? 'has-error' : ''}}">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="employee_lname">Last Name <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="employee_lname" name="employee_lname"  class="form-control col-md-7 col-xs-12">
                                                {!! $errors->first('employee_lname', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('employee_username') ? 'has-error' : ''}}">
                                            <label for="employee_username" class="control-label col-md-3 col-sm-3 col-xs-12">Username  <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="employee_username" class="form-control col-md-7 col-xs-12" type="text" name="employee_username">
                                                {!! $errors->first('employee_username', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('employee_email') ? 'has-error' : ''}}">
                                            <label for="employee_email" class="control-label col-md-3 col-sm-3 col-xs-12">Email  <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="employee_email" class="form-control col-md-7 col-xs-12" type="email" name="employee_email">
                                                {!! $errors->first('employee_email', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('employee_password') ? 'has-error' : ''}}">
                                            <label for="employee_password" class="control-label col-md-3 col-sm-3 col-xs-12">Password  <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="employee_password" class="form-control col-md-7 col-xs-12" type="password" name="employee_password" value="{{ env('DEFAULT_USER_PASSWORD') }}">
                                                <small>Default password is: vbase1200</small>
                                                {!! $errors->first('employee_password', '<p class="help-block">:message</p>') !!}
                                                {{ csrf_field() }}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('employee_designation') ? 'has-error' : ''}}" >
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Designation</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select id="employee_designation" name="employee_designation" required class="form-control col-md-7 col-xs-12">
                                                    <option value="Developer">Developer</option>
                                                    <option value="Software Engineer">Software Engineer</option>
                                                    <option value="Sr. Software Engineer">Sr. Software Engineer</option>
                                                    <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                                                    <option value="Accountant / HR">Accountant / HR</option>
                                                    <option value="SEO">SEO</option>
                                                    <option value="Network Admin">Network Admin</option>
                                                    <option value="Marketing Executive">Marketing Executive</option>
                                                    <option value="Brand Executive">Brand Executive</option>
                                                    <option value="Video Maker & Editor">Video Maker & Editor</option>
                                                    <option value="Content Writer">Content Writer</option>
                                                </select>
                                                {!! $errors->first('employee_designation', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('employee_role') ? 'has-error' : ''}}">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select id="employee_role" name="employee_role" required class="form-control col-md-7 col-xs-12">
                                                    @foreach($data['roles'] as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('employee_role', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="reset" class="btn btn-primary">Cancel</button>
                                                <button type="submit" class="btn btn-success">Create</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Show All Users Table --}}
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Employees</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Designation</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['users'] as $user)
                                            <tr>
                                                <td> {{ $user->first_name }} </td>
                                                <td> {{ $user->last_name }} </td>
                                                <td> {{ $user->username }} </td>
                                                <td> {{ $user->email }} </td>
                                                <td>
                                                    {{ $user->designation && $user->designation != ''? $user->designation : 'Not Assigned' }}
                                                </td>
                                                <td> {{ $user->roles()->first()->name or 'Unassigned!' }} </td>
                                                <td> {{ $user->is_active == '1' ? 'Active' : 'Inactive' }} </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="updateUser btn btn-info btn-xs" data-id="{{ $user->id }}" data-username="{{ $user->username }}" data-toggle="modal" data-target="#updateModal">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)" class="delUser btn btn-danger btn-xs" data-id="{{ $user->id }}" data-name="{{ $user->first_name . ' ' . $user->last_name }}" data-toggle="modal" data-target="#deleteModal">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- /page content -->

            <!-- Delete Employee Modal -->
            <div id="deleteModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Employee</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to remove <strong><span style="color: #d9534f;" id="empName"></span></strong> from company?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDel" data-dismiss="modal">Delete</button>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Edit Employee Modal -->
            <div id="updateModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Employee</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                {{-- Add New User Form --}}
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    @if(Session::has('success'))
                                        <div class="alert alert-success" id="editSuccess">
                                            <strong>Success!</strong> {{ Session::get('success') }}
                                        </div>
                                        <script>
                                            setTimeout(function(){
                                                $('#editSuccess').css('display', 'none')
                                            }, 3000);
                                        </script>
                                    @endif
                                    @if(Session::has('failure'))
                                        <div class="alert alert-danger" id="editFailure">
                                            <strong>Failure!</strong> {{ Session::get('failure') }}
                                        </div>
                                        <script>
                                            setTimeout(function(){
                                                $('#editFailure').css('display', 'none')
                                            }, 3000);
                                        </script>
                                    @endif

                                    <div class="x_panel">
                                        {{--<div class="x_title">--}}
                                            {{--<h2>Update Employee</h2>--}}
                                            {{--<div class="clearfix"></div>--}}
                                        {{--</div>--}}
                                        <div class="x_content">
                                            <br />
                                            <form method="post" action="/updateEmployee" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                                <div class="form-group {{ $errors->has('employee_fname2') ? 'has-error' : ''}}">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="employee_fname2">First Name <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="employee_fname2" name="employee_fname2"  class="form-control col-md-7 col-xs-12">
                                                        {!! $errors->first('employee_fname2', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                                <div class="form-group {{ $errors->has('employee_lname2') ? 'has-error' : ''}}">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="employee_lname2">Last Name <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input type="text" id="employee_lname2" name="employee_lname2"  class="form-control col-md-7 col-xs-12">
                                                        {!! $errors->first('employee_lname2', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>
                                                <div class="form-group {{ $errors->has('employee_username2') ? 'has-error' : ''}}">
                                                    <label for="employee_username2" class="control-label col-md-3 col-sm-3 col-xs-12">Username  <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="employee_username2" class="form-control col-md-7 col-xs-12" type="text" name="employee_username2">
                                                        {!! $errors->first('employee_username2', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->has('employee_email2') ? 'has-error' : ''}}">
                                                    <label for="employee_email2" class="control-label col-md-3 col-sm-3 col-xs-12">Email  <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="employee_email2" class="form-control col-md-7 col-xs-12" type="email" name="employee_email2">
                                                        {!! $errors->first('employee_email2', '<p class="help-block">:message</p>') !!}
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->has('employee_password2') ? 'has-error' : ''}}">
                                                    <label for="employee_password2" class="control-label col-md-3 col-sm-3 col-xs-12">Password  <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input id="employee_password2" class="form-control col-md-7 col-xs-12" type="password" name="employee_password2" value="vbase1200">
                                                        <small>Default password is: vbase1200</small>
                                                        {!! $errors->first('employee_password2', '<p class="help-block">:message</p>') !!}
                                                        {{ csrf_field() }}
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->has('employee_designation2') ? 'has-error' : ''}}">
                                                    <label for="employee_designation2" class="control-label col-md-3 col-sm-3 col-xs-12">Designation <span class="required">*</span></label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12 designation">
                                                        <select id="employee_designation2" name="employee_designation2" required class="form-control col-md-7 col-xs-12">
                                                            <option value="Developer">Developer</option>
                                                            <option value="Software Engineer">Software Engineer</option>
                                                            <option value="Sr. Software Engineer">Sr. Software Engineer</option>
                                                            <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                                                            <option value="Accountant / HR">Accountant / HR</option>
                                                            <option value="SEO">SEO</option>
                                                            <option value="Network Admin">Network Admin</option>
                                                            <option value="Marketing Executive">Marketing Executive</option>
                                                            <option value="Brand Executive">Brand Executive</option>
                                                            <option value="Video Maker & Editor">Video Maker & Editor</option>
                                                            <option value="Content Writer">Content Writer</option>
                                                        </select>
                                                        {{--<input id="employee_designation2" class="form-control col-md-7 col-xs-12" type="text" name="employee_designation2">--}}
{{--                                                        {!! $errors->first('employee_designation', '<p class="help-block">:message</p>') !!}--}}
                                                        <input id="employee_id" class="form-control col-md-7 col-xs-12" type="hidden" name="employee_id">

                                                    </div>
                                                </div>

                                                {{--<div class="form-group {{ $errors->has('employee_role') ? 'has-error' : ''}}">--}}
                                                    {{--<label class="control-label col-md-3 col-sm-3 col-xs-12">Role</label>--}}
                                                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                                                        {{--<select id="employee_role2" name="employee_role" required class="form-control col-md-7 col-xs-12">--}}
                                                            {{--@foreach($data['roles'] as $role)--}}
                                                                {{--<option value="{{ $role->id }}">{{ $role->name }}</option>--}}
                                                            {{--@endforeach--}}
                                                        {{--</select>--}}
                                                        {{--{!! $errors->first('employee_role', '<p class="help-block">:message</p>') !!}--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}

                                                <div class="ln_solid"></div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success">Update</button>
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


            <!-- jQuery autocomplete -->
            <script>
                $(document).ready(function() {



                    $('.delUser').click(function(e) {
                        e.preventDefault();
                        thisRow = $(this);
                        window.id = $(this).attr('data-id');
                        var name = $(this).data('name');
                        $('#empName').text(name);
                    });

                    $('#confirmDel').click(function (e){
                        e.preventDefault();
//                        console.log(window.id);
                        $.ajax({
                            url: '/delEmployee',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                'del_id': window.id
                            },

                            success: function(response){
//                                console.log(response);
                                if(response == 1){
                                    thisRow.closest('tr').remove();
                                    window.id = null;
                                }
                            },
                            error: function(response){
                                console.log(response);
                            }
                        });
                    });

                    $('.updateUser').click(function (e){
                        e.preventDefault();
                        window.id = $(this).data('id');
                        $('#employee_id').val(window.id);

                        $.ajax({
                            url: '/getUserRecord',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                'user_id': window.id
                            },

                            success: function(res){
//                                console.log(res);
                                $('#employee_fname2').val(res.first_name);
                                $('#employee_lname2').val(res.last_name);
                                $('#employee_username2').val(res.username);
                                $('#employee_email2').val(res.email);
                                if(res.role == "Administrator"){
                                    $('.designation').html("");
                                    $('.designation').html("<input type='text' class='form-control col-md-7 col-xs-12' disabled name='employee_designation2' id='employee_designation2' >");
                                    $('#employee_designation2').val(res.role);
                                } else {
                                    var html = '<select id="employee_designation2" name="employee_designation2" required class="form-control col-md-7 col-xs-12">' +
                                        '<option value="Developer">Developer</option>' +
                                        '<option value="Software Engineer">Software Engineer</option>' +
                                        '<option value="Sr. Software Engineer">Sr. Software Engineer</option>' +
                                        '<option value="Quality Assurance Engineer">Quality Assurance Engineer</option>' +
                                        '<option value="Accountant / HR">Accountant / HR</option>' +
                                        '<option value="SEO">SEO</option>' +
                                        '<option value="Network Admin">Network Admin</option>' +
                                        '<option value="Marketing Executive">Marketing Executive</option>' +
                                        '<option value="Brand Executive">Brand Executive</option>' +
                                        '<option value="Video Maker & Editor">Video Maker & Editor</option>' +
                                        '<option value="Content Writer">Content Writer</option>' +
                                        '</select>';
                                    $('.designation').html("");
                                    $('.designation').html(html);
                                    $('#employee_designation2').val(res.designation);
                                }
                            },
                            error: function(response){
                                console.log(response);
                            }
                        });

                    });

                });
            </script>

            <script src="{{asset('js/jquery.dataTables.js')}}"></script>
            <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
            <script src="{{asset('js/dataTables.responsive.js')}}"></script>
            <script src="{{asset('js/responsive.bootstrap.js')}}"></script>


            <!-- Datatables -->
            <script>
                $(document).ready(function() {
                    var handleDataTableButtons = function() {
                        if ($("#datatable-buttons").length) {
                            $("#datatable-buttons").DataTable({
                                dom: "Bfrtip",
                                buttons: [
                                    {
                                        extend: "copy",
                                        className: "btn-sm"
                                    },
                                    {
                                        extend: "csv",
                                        className: "btn-sm"
                                    },
                                    {
                                        extend: "excel",
                                        className: "btn-sm"
                                    },
                                    {
                                        extend: "pdfHtml5",
                                        className: "btn-sm"
                                    },
                                    {
                                        extend: "print",
                                        className: "btn-sm"
                                    },
                                ],
                                responsive: true
                            });
                        }
                    };

                    TableManageButtons = function() {
                        "use strict";
                        return {
                            init: function() {
                                handleDataTableButtons();
                            }
                        };
                    }();

                    $('#datatable').dataTable();

                    $('#datatable-keytable').DataTable({
                        keys: true
                    });

                    $('#datatable-responsive').DataTable({
                        responsive: true,
                        'order': [[ 1, 'asc' ]],
                    });

                    $('#datatable-scroller').DataTable({
                        ajax: "js/datatables/json/scroller-demo.json",
                        deferRender: true,
                        scrollY: 380,
                        scrollCollapse: true,
                        scroller: true
                    });

                    $('#datatable-fixed-header').DataTable({
                        fixedHeader: true
                    });

                    var $datatable = $('#datatable-checkbox');

                    $datatable.dataTable({
                        'order': [[ 1, 'asc' ]],
                        'columnDefs': [
                            { orderable: false, targets: [0] }
                        ]
                    });
                    $datatable.on('draw.dt', function() {
                        $('input').iCheck({
                            checkboxClass: 'icheckbox_flat-green'
                        });
                    });

                    TableManageButtons.init();
                });
            </script>
            <!-- /Datatables -->

        </div>
    </div>

@endsection

@section('page_scripts')

@endsection
