<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    @yield('css')

    <!-- Custom CSS -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Sidebar Toggle for SB Admin 2 -->
    <link href="{{ asset('css/sbadmin2-sidebar-toggle.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-messages">--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<strong>John Smith</strong>--}}
                                {{--<span class="pull-right text-muted">--}}
                                                {{--<em>Yesterday</em>--}}
                                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<strong>John Smith</strong>--}}
                                {{--<span class="pull-right text-muted">--}}
                                                {{--<em>Yesterday</em>--}}
                                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<strong>John Smith</strong>--}}
                                {{--<span class="pull-right text-muted">--}}
                                                {{--<em>Yesterday</em>--}}
                                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a class="text-center" href="#">--}}
                            {{--<strong>Read All Messages</strong>--}}
                            {{--<i class="fa fa-angle-right"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- /.dropdown-messages -->--}}
            {{--</li>--}}
            <!-- /.dropdown -->
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-tasks">--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p>--}}
                                    {{--<strong>Task 1</strong>--}}
                                    {{--<span class="pull-right text-muted">40% Complete</span>--}}
                                {{--</p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">--}}
                                        {{--<span class="sr-only">40% Complete (success)</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p>--}}
                                    {{--<strong>Task 2</strong>--}}
                                    {{--<span class="pull-right text-muted">20% Complete</span>--}}
                                {{--</p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">--}}
                                        {{--<span class="sr-only">20% Complete</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p>--}}
                                    {{--<strong>Task 3</strong>--}}
                                    {{--<span class="pull-right text-muted">60% Complete</span>--}}
                                {{--</p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">--}}
                                        {{--<span class="sr-only">60% Complete (warning)</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<p>--}}
                                    {{--<strong>Task 4</strong>--}}
                                    {{--<span class="pull-right text-muted">80% Complete</span>--}}
                                {{--</p>--}}
                                {{--<div class="progress progress-striped active">--}}
                                    {{--<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">--}}
                                        {{--<span class="sr-only">80% Complete (danger)</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a class="text-center" href="#">--}}
                            {{--<strong>See All Tasks</strong>--}}
                            {{--<i class="fa fa-angle-right"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- /.dropdown-tasks -->--}}
            {{--</li>--}}
            <!-- /.dropdown -->
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">--}}
                    {{--<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-alerts">--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-comment fa-fw"></i> New Comment--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-twitter fa-fw"></i> 3 New Followers--}}
                                {{--<span class="pull-right text-muted small">12 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-envelope fa-fw"></i> Message Sent--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-tasks fa-fw"></i> New Task--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-upload fa-fw"></i> Server Rebooted--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a class="text-center" href="#">--}}
                            {{--<strong>See All Alerts</strong>--}}
                            {{--<i class="fa fa-angle-right"></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<!-- /.dropdown-alerts -->--}}
            {{--</li>--}}
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    {{--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>--}}
                    {{--</li>--}}
                    <li><a href="{{ url('/settings') }}"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div id="sidebar-wrapper">
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input id="job-id" type="text" class="form-control" placeholder="To Job">
                            <span class="input-group-btn">
                                <button id="to-job" class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    {{--<li>--}}
                        {{--<a href="{{ url('/') }}"><i class="fa fa-folder-open fa-fw"></i> Dashboard</a>--}}
                    {{--</li>--}}
                    @can('root')
                    <li>
                        <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Config<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Account<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="{{ url('admin/permission') }}"> Permission</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/role') }}"> Role</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/account') }}"> User</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/region') }}"> Region</a>
                                    </li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Appliance<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="{{ url('admin/appliance') }}" target="_blank"> Models</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('admin/appliance/create') }}" target="_blank"> New One</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Manage<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('appliance/deposit/pending') }}" target="_blank"> Payment</a>
                            </li>
                            <li>
                                <a href="{{ url('statistics/payment') }}" target="_blank"> Unpaid</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/invoice/indexall') }}" target="_blank"> List</a>
                            </li>
                        </ul>
                    </li>
                    @endcan

                    @can('appliance_job')
                    <li>
                        <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Sales<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('appliance/quote') }}" target="_blank">Quote</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/invoice/job') }}" target="_blank">Job</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/appliance/model') }}" target="_blank">Search</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Record<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="{{ url('statistics/sales') }}" target="_blank">Sales</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('appliance/record/2') }}" target="_blank"></i> Arrival</a>
                                    </li>

                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    @endcan
                    @can('menu_stock')
                    <li>
                        <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Stock<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('appliance/order') }}" target="_blank">Order</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/stock/index/0') }}" target="_blank">Pending</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/stock/index/1') }}" target="_blank">Ordered</a>
                            {{--</li>--}}
                            {{--<li>--}}
                                <a href="{{ url('appliance/stock/listing') }}" target="_blank">Shelf</a>
                            {{--</li>--}}
                            <li>
                                <a href="{{ url('appliance/stock/exportCheckingList') }}" target="_blank">Checking</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/stock/index/4') }}" target="_blank">Assigned</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/stock/index/2') }}" target="_blank">Available</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/stock/index/3') }}" target="_blank">Delivered</a>
                            </li>
                            <li>
                                <a href="{{ url('appliance/stock/index/5') }}" target="_blank">Display</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    @endcan

                    @can('root')
                        <li>
                            <a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Kitchen<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url('kitchen/product/brand') }}" target="_blank"> Product Brand</a>
                                </li>
                                <li>
                                    <a href="{{ url('kitchen/product/category') }}" target="_blank"> Product Category</a>
                                </li>
                                <li>
                                    <a href="{{ url('kitchen/product/template/create') }}" target="_blank"> New Product</a>
                                </li>
                                <li>
                                    <a href="{{ url('kitchen/product/template') }}" target="_blank"> Product List</a>
                                </li>
                                {{--<li>--}}
                                    {{--<a href="#"><i class="fa fa-th- fa-folder-open fa-fw"></i> Config<span class="fa arrow"></span></a>--}}
                                    {{--<ul class="nav nav-third-level">--}}
                                        {{--<li>--}}
                                            {{--<a href="{{ url('admin/appliance') }}" target="_blank"> Product List</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="{{ url('admin/appliance/create') }}" target="_blank"> New Product</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                            </ul>
                        </li>

                    @endcan
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <button id="menu-toggle" type="button" data-toggle="button" class="btn btn-default btn-xs">
            <span class="fa fa-exchange fa-fw"></span>
        </button>
        @yield('content')
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('vendor/metisMenu/metisMenu.min.js')}}"></script>

@yield('js')

<!-- Custom Theme JavaScript -->
<script src="{{ asset('js/sb-admin-2.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
            $("#wrapper.toggled").find("#sidebar-wrapper").find(".collapse").collapse("hide");
        });
        $("#job-id").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#to-job").click();
            }
        });
        $("#to-job").click(function(e) {
            e.preventDefault();
            var cid = $("#job-id").val();
            if (cid == "" || cid.length == 0 || cid == null)
            {
                return false
            }
            window.location.href="/appliance/cid/"+cid;
        });
    });
</script>
</body>
</html>
