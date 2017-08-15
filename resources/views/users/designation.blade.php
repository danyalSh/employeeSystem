@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
    @section('title')
        Designation
    @stop

{{-- {{ dd($data['users'][1]->designation) }}--}}

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
                            @if($data['users']->count() == 0)
                                <div class="alert alert-warning" id="warning">
                                    <strong>Warning!</strong> No record found.
                                </div>
                                <script>
                                    setTimeout(function(){
                                        $('#employee_id').prop('disabled', true);
                                        $('#employee_designation').prop('disabled', true);
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

                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Add Designation</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" action="/addDesignation" id="addDesignationForm" class="form-horizontal form-label-left">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee Name</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select id="employee_id" name="employee_id" required class="form-control col-md-7 col-xs-12">
                                                        @foreach($data['users'] as $user)
                                                            @if($user->designation == NULL && $user->roles()->first()->name == 'Employee')
                                                                <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('employee_designation') ? 'has-error' : ''}}">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Designation</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input type="text" id="employee_designation" name="employee_designation"  class="form-control col-md-7 col-xs-12">
                                                    {!! $errors->first('employee_designation', '<p class="help-block">:message</p>') !!}
                                                    {{ csrf_field() }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="ln_solid"></div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                    <button type="reset" class="btn btn-primary">Cancel</button>
                                                    <button type="submit" id="addBtn" class="btn btn-success">Add</button>
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
                $(document).ready(function() {

                });
            </script>

        </div>
    </div>

@endsection

@section('page_scripts')

@endsection
