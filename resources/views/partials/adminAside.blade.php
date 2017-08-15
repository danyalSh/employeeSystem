<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/" class="site_title">
                {{--<i class="fa fa-paw"></i>--}}
                <span>
                    @section('title')
                    @show
                </span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <span class="userName">
                    <?php
                        $fname = \Auth::user()->first_name;
                        $lname = \Auth::user()->last_name;
                        $fs = substr($fname, 0, 1);
                        $ls = substr($lname, 0, 1);
                        echo strtoupper($fs.''.$ls);
                    ?>
                </span>
                {{--<img src="{{ asset('images/noImage.jpg') }}" alt="..." class="img-circle profile_img">--}}
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ \Auth::user()->username }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />
        <br />
        <br />
        <br />
        <br />
        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                @if(\Auth::user()->hasRole('User'))
                    @if(isset($projects))
                        <h3>Projects</h3>
                    @else
                        <h3>General</h3>
                    @endif
                @else
                    <h3>General</h3>
                @endif
                <ul class="nav side-menu">
                    @if(\Auth::user()->hasRole('Super Admin') || \Auth::user()->hasRole('Administrator'))
                        <li><a class="sidebar-links"><i class="fa fa-users"></i> Employees <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/employees">Manage Employees</a></li>
                                {{--<li><a href="/assign-designation">Add Designation to employee</a></li>--}}
                            </ul>
                        </li>

                        @if(\Auth::user()->hasRole('Super Admin'))

                        <li><a class="sidebar-links"><i class="fa fa-sitemap"></i> Organizations <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/organizations">Manage Organizations</a></li>
                                <li><a href="/assign-organization">Assign Organization to Employee</a></li>
                            </ul>
                        </li>

                        @endif

                        <li><a class="sidebar-links"><i class="fa fa-tasks"></i> Projects <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/projects">Manage Projects</a></li>
                                <li><a href="/assign-project">Assign Project to Employees</a></li>
                            </ul>
                        </li>

                        <li><a class="sidebar-links"><i class="fa fa-tasks"></i> Roles <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/roles">Manage Roles</a></li>
                                {{--<li><a href="/assign-project">Assign Project to Employees</a></li>--}}
                            </ul>
                        </li>

                        <li><a class="sidebar-links"><i class="fa fa-tasks"></i> Permissions <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/permissions">Manage Permissions</a></li>
                                {{--<li><a href="/assign-project">Assign Project to Employees</a></li>--}}
                            </ul>
                        </li>

                        <li><a class="sidebar-links"><i class="fa fa-file-text"></i> Tasks <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/tasks">Manage Tasks</a></li>
                                <li><a href="/assign-task">Assign Task to Employees</a></li>
                            </ul>
                        </li>
                    @else
                        @if(isset($projects) && $projects != 0)
                            @foreach($projects as $project)
                                <li><a class="sidebar-links empProject" data-id="{{ $project->id }}"><i class="fa fa-file-text"></i> {{ $project->project_title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/" class="sidebar-links"><i class="fa fa-file-text"></i> Home</a></li>
                        @endif

                    @endif
                </ul>
            </div>
        </div>

    </div>
</div>

