@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Organizations
@stop

<div class="container body">
    <div class="main_container">

{{--    {{ dd($data['organization'][0]->getOrganizationAdmin()->first_name) }}--}}


    @include('partials.adminAside')
    @include('partials.adminHeader')


    <!-- page content -->
        <div class="right_col" role="main">
            <div class="">

                <div class="row">
                    {{-- Show All Users Table --}}
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Organizations</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Admin</th>
                                        <th>Organizations</th>
                                        <th>Actions</th>
                                        {{--<th>Projects</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['organization'] as $org)
                                        <tr>
                                            <td> {{ $org->getOrganizationAdmin()? $org->getOrganizationAdmin()->first_name . ' ' . $org->getOrganizationAdmin()->last_name : 'N/A' }}</td>
                                            <td> {{ $org->name }} </td>
                                            <td>
                                                <a href="/assign-organization" class="btn btn-info btn-xs">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
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


        <!-- jQuery autocomplete -->
        <script>
            $(document).ready(function() {

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