@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Dashboard

@stop

{{--{{ dd($data) }}--}}
<?php
    $projects = $data[0]->projects;
//    dd($projects);
?>

<div class="container body">
    <div class="main_container">

    @include('partials.adminAside', array(
        'projects' => $projects
	))
    @include('partials.adminHeader')

    <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="row">

                </div>
                <div class="row prjRow" style="display: none;">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2 id="prjTitle"></h2><br>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p id="prjDesc" class="text-muted font-13 m-b-30"></p>
                                <p><b>Organization:</b> <span id="prjOrg"></span></p>

                                <!-- start Tasks list -->
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%">ID</th>
                                        <th style="width: 20%">Task Title</th>
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th style="width: 20%">Report</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tasksList"></tbody>
                                </table>
                                <!-- end Tasks list -->

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <!-- /page content -->

        {{-- Delete Task Modal --}}

        <div id="reportModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Submit Report</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>--}}
                        {{--<button type="button" class="btn btn-danger" id="confirmDel" data-dismiss="modal">Delete</button>--}}
                    {{--</div>--}}
                </div>

            </div>
        </div>


        <?php //$prj = json_encode($projects); ?>

        <script>
            $(document).ready(function(){
                async.waterfall([
                    function(callback) {
                        try{
//                            console.log('abc');
                            $('.empProject').click(function (e){
                                $('.prjRow').show();
                                var currentProjectID = $(this).data('id');
                                $.ajax({
                                    url: '/getProjectTasks',
                                    type: 'POST',
                                    data: {
                                        'project_id': currentProjectID,
                                        '_token': '{{ csrf_token() }}'
                                    },

                                    success: function (response){
//                                      console.log('success fn: ', response);
                                        var data = JSON.parse(response);
                                        data = data[0];
                                        $('#prjTitle').text(data.project_title + '');
                                        $('#prjDesc').text(data.project_desc);
                                        $('#prjOrg').text(data.organization[0].name);
                                        var html = '';
                                        var noRec = 'Unassigned!';
                                        var noRec1 = 'No Record found...!';

                                        if(data.tasks.length > 0){
                                            for(var i=0; i < data.tasks.length; i++){
                                                html += '<tr>' +
                                                    '<td>'+ i +'</td>' +
                                                    '<td><a>'+ data.tasks[i].task_title +'</a><br/><small>'+ data.tasks[i].task_desc.substring(0, 30) +'...</small></td>' +
                                                    '<td>'+ data.tasks[i].status[0].name +'</td>';
                                                if(data.tasks[i].employees.length > 0){
                                                    html += '<td>'+ data.tasks[i].employees[0].username +'</td>';
                                                } else {
                                                    html += '<td>'+ noRec +'</td>';
                                                }
                                                html += '<td><input type="button" class="btn btn-info btn-xs submitReport" data-id="'+data.tasks[i].id+'" value="View"></td></tr>';
                                            }
                                        } else {
                                            html += "<tr><td colspan='5'>No Record Found...!</td></tr>";
                                        }
                                        $('#tasksList').html(html);
                                        callback(null, true);

                                    },
                                    error: function (response){
                                        console.log('error fn: ', response);
                                        callback(response);
                                    }
                                });
                            });
                        }catch (e){
                            callback(e);
                        }
                    },
                    function(arg1, callback) {
                        try{
//                            console.log('abc 2');
                            $('.submitReport').on('click', function (){
                                var id = $(this).data('id');
                                //console.log(id);
                                window.location = '/report/'+id;
                                callback(null, id);
                            });
                        }catch (e){
                            callback(e);
                        }
                    }
                ], function (err, result) {
                    if (err) {
                        console.log('error: ' + err);
                    } else {
                        console.log(result);
                    }
                });
            });

        </script>


    </div>
</div>
@endsection