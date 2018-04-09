<!DOCTYPE html>
<html>
<head>
    <title>CRM Seeder</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/themes/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/inspinia/css/animate.css" rel="stylesheet">
    <link href="/themes/inspinia/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="/themes/inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/themes/inspinia/css/style.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="pace-done">
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ \Illuminate\Support\Facades\Auth::user()->email }}</strong>
                             </span> <span class="text-muted text-xs block">Admin </span>
                            </span>
                        </a>
                    </div>
                </li>
                <li class="@if(Route::current()->getName() == 'dashboard') active @endif">
                    <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                <li class="@if(Route::current()->getName() == 'contact.index') active @endif">
                    <a href="{{ route('contact.index') }}"><i class="fa fa-address-book"></i> <span class="nav-label">Contacts</span></a>
                </li>
                <li class="@if(Route::current()->getName() == 'user.index') active @endif">
                    <a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span class="nav-label">Users</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1" style="min-height: 100vh;">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a id="btn-logout" href="{{ route('logout') }}">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        @yield('content')
    </div>
    @include('components/loader')
</div>

<script src="/js/bootstrap.js"></script>
<script src="/themes/inspinia/js/jquery-2.1.1.js"></script>
<script src="/themes/inspinia/js/bootstrap.min.js"></script>
<script src="/themes/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/themes/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/themes/inspinia/js/plugins/select2/select2.full.min.js"></script>
<script src="/themes/inspinia/js/plugins/pace/pace.min.js"></script>
<script src="/themes/inspinia/js/inspinia.js"></script>
<script>
    var route = '{!! Route::current()->getName() !!}';
</script>
<script src="/js/app.js"></script>

{{--<script src="/user/js/user.js"></script>--}}

</body>
</html>
