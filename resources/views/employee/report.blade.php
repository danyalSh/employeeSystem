@extends('layouts.adminBody')
@section('content')

    {{-- Page title --}}
@section('title')
    Submit Report

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

                <div class="row prjRow" >
                    {{-- Wysiwyg Editor for Posting Comments --}}

                    @if(Auth::user()->hasRole('Administrator') || Auth::user()->hasRole('Super Admin'))
                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 id="taskTitle">{{ $data['task']->task_title }}</h2><br>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <p id="taskDesc" class="text-muted font-13 m-b-30">{{ $data['task']->task_desc }}</p>
                                    <p><b>Project:</b> <span id="taskProject">{{ $data['task']->projects[0]->project_title }}</span></p>
                                    <p><b>Assigned To:</b>
                                        @if($data['task']->employees->count() > 0)
                                            <span id="taskEmp">
                                            {{ $data['task']->employees[0]->username }}
                                        </span>
                                        @else
                                            <span id="taskEmp">
                                            Not assigned to any employee. <a href="/assign-task">Assign Now!</a>
                                        </span>
                                        @endif
                                    </p>
                                    <p><b>Status:</b> <span id="taskStatus">{{ $data['task']->status[0]->name }}</span></p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 id="taskTitle">{{ $data['task']->task_title }}</h2><br>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <p id="taskDesc" class="text-muted font-13 m-b-30">{{ $data['task']->task_desc }}</p>
                                    <p><b>Project:</b> <span id="taskProject">{{ $data['task']->projects[0]->project_title }}</span></p>
                                    <p><b>Assigned To:</b>
                                        @if($data['task']->employees->count() > 0)
                                            <span id="taskEmp">
                                            {{ $data['task']->employees[0]->username }}
                                        </span>
                                        @else
                                            <span id="taskEmp">
                                                Not assigned to any employee!
                                            </span>
                                            <script>
                                                setTimeout(function (){
                                                    $('#submit').attr('disabled', 'disabled');
                                                    $('#editor').attr('contenteditable', false);
                                                }, 300);
                                            </script>
                                        @endif
                                    </p>
                                    <form action="/submitReport" enctype="multipart/form-data" method="POST" id="reportForm">
                                        <p><b>Status:</b>
                                            <select class="form-control taskStatusSelect" name="status_id">
                                                @foreach($data['status'] as $status)
                                                    @if($status->name == $data['task']->status[0]->name)
                                                        <option selected value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @else
                                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="alerts"></div>

                                                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                                                    <div class="btn-group">
                                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                        </ul>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a data-edit="fontSize 5">
                                                                    <p style="font-size:17px">Huge</p>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-edit="fontSize 3">
                                                                    <p style="font-size:14px">Normal</p>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a data-edit="fontSize 1">
                                                                    <p style="font-size:11px">Small</p>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                                        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                                        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                                        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                                        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                                        <div class="dropdown-menu input-append">
                                                            <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                                            <button class="btn" type="button">Add</button>
                                                        </div>
                                                        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                                        <input type="file" name="reportFile" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                                    </div>

                                                    <div class="btn-group">
                                                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                                    </div>
                                                </div>

                                                <div id="editor" class="editor-wrapper"></div>

                                                <textarea id="descr" style="display:none;"></textarea>
                                                {{ csrf_field() }}
                                                <input type="hidden" id="comment" name="comment">
                                                <input type="hidden" id="task_id" name="task_id" value="{{ $data['task']->id }}">
                                                <input type="hidden" id="project_id" name="project_id" value="{{ $data['task']->projects[0]->id }}">

                                                <br />
                                                <input type="submit" class="btn btn-info" name="submit" id="submit" value="Submit" >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- Display Comments --}}

                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Comments</h2><br>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <ul class="messages">
                                    @if($data['task']->comments->count() > 0)

                                        @foreach($data['task']->comments as $comment)
                                            <li>
                                                <div class="message_date">
                                                    <h3 class="date text-info">
                                                        {{ Carbon\Carbon::parse($comment->created_at)->format('l j') }}
                                                    </h3>
                                                    <p class="month">
                                                        {{ Carbon\Carbon::parse($comment->created_at)->format('F') }}
                                                    </p>
                                                </div>
                                                <div class="message_wrapper">
                                                    <h4 class="heading">{{ $comment->user->username }}</h4>
                                                    <blockquote class="message">
                                                        {!! $comment->comment !!}
                                                    </blockquote>
                                                    <br>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <div class="message_wrapper">
                                                <h4 class="heading">No Comment Found!</h4>
                                                <br>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>


            </div>
        </div>
        <!-- /page content -->

        <!-- bootstrap-wysiwyg -->
        <script>
            $(document).ready(function() {
                function initToolbarBootstrapBindings() {
                    var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                            'Times New Roman', 'Verdana'
                        ],
                        fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                    $.each(fonts, function(idx, fontName) {
                        fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
                    });
                    $('a[title]').tooltip({
                        container: 'body'
                    });
                    $('.dropdown-menu input').click(function() {
                        return false;
                    })
                        .change(function() {
                            $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
                        })
                        .keydown('esc', function() {
                            this.value = '';
                            $(this).change();
                        });

                    $('[data-role=magic-overlay]').each(function() {
                        var overlay = $(this),
                            target = $(overlay.data('target'));
                        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                    });

                    if ("onwebkitspeechchange" in document.createElement("input")) {
                        var editorOffset = $('#editor').offset();

                        $('.voiceBtn').css('position', 'absolute').offset({
                            top: editorOffset.top,
                            left: editorOffset.left + $('#editor').innerWidth() - 35
                        });
                    } else {
                        $('.voiceBtn').hide();
                    }
                }

                function showErrorAlert(reason, detail) {
                    var msg = '';
                    if (reason === 'unsupported-file-type') {
                        msg = "Unsupported format " + detail;
                    } else {
                        console.log("error uploading file", reason, detail);
                    }
                    $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
                }

                initToolbarBootstrapBindings();

                $('#editor').wysiwyg({
                    fileUploadError: showErrorAlert
                });

                window.prettyPrint;
                prettyPrint();

                $('#reportForm').submit(function (e){
                    $('#comment').val($('#editor').html());
                });
            });
        </script>
        <!-- /bootstrap-wysiwyg -->


    </div>
</div>
@endsection