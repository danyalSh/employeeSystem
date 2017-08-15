@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
    @section('title')
        Assign Organization
    @stop
{{--{{ dd($data) }}--}}

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
                                        $('#org_id').prop('disabled', true);
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
                                    <h2>Assign Organization</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    <form method="post" action="/assignOrganizationToSubAdmin" id="assignOrganizationForm" class="form-horizontal form-label-left">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Admin</label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <select id="employee_id" name="employee_id" required class="form-control col-md-7 col-xs-12">
                                                        <option disabled selected>Select admin to view Organizations</option>
                                                        @foreach($data['users'] as $user)
                                                            @if($user->designation == 'Administrator' && $user->hasRole('Administrator', $user->id))
                                                                <option value="{{ $user->id }}">{{ $user->first_name . ' ' . $user->last_name }}</option>
                                                            @else
                                                                <option selected value="0">No admin added yet!</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('org_id') ? 'has-error' : ''}}">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Organization</label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <p style="padding: 5px;" id="org_checkboxes">
                                                        @foreach($data['org'] as $org)
                                                            <input type="checkbox" name="org_id[]" id="org_{{ $org->id }}" value="{{ $org->id }}" class="flat" /> {{ $org->name }}
                                                            <br />
                                                        @endforeach
                                                    </p>
                                                    {!! $errors->first('org_id', '<p class="help-block">:message</p>') !!}
                                                    {{ csrf_field() }}
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
                $(document).ready(function() {
//                    console.log($('#employee_id').val());
                    var val = $('#employee_id').val();
                    if(val == '0'){
//                        console.log('No record Found');
                        $('input[type="checkbox"]').prop('disabled', true);
                        $('#addBtn').prop('disabled', true);
                    } else {
//                        console.log('record Found');
                    }

                    $('#employee_id').change(function (){
//                        console.log($(this).val());
                        $('input[type="checkbox"]').iCheck('uncheck')
                        var updateField = '<input type="hidden" name="update" value="1" >';
                        $('#org_checkboxes').append(updateField);
                        var id = $(this).val();
                        $.ajax({
                            url: '/getSubAdminOrg',
                            data: {'employee_id': id, '_token': '{{ csrf_token() }}' },
                            type: 'POST',

                            success: function (response) {
                                //console.log(response);
                                if(response && response != null){
                                    var data = response;
                                    for(i=0; i<data.length; i++){
//                                        console.log('#org_'+data[i].name);
                                        $('#org_'+data[i].id).iCheck('check');
                                    }
                                }
                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });

                    });

                });
            </script>

        </div>
    </div>

@endsection

@section('page_scripts')

@endsection
