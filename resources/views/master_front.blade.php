<!DOCTYPE html>
<html>
<head>
    <title>CRM Seeder</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="/themes/inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/themes/inspinia/css/animate.css" rel="stylesheet">
    <link href="/themes/inspinia/css/plugins/bootstrapSocial/bootstrap-social.css" rel="stylesheet">
    <link href="/themes/inspinia/css/style.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body class="top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="white-bg">
        <div class="content-wrapper">
            @yield('content')
        </div>
         @include('components/loader')
    </div>
</div>
</body>
<script src="/js/bootstrap.js"></script>
<script src="/themes/inspinia/js/jquery-2.1.1.js"></script>
<script src="/themes/inspinia/js/bootstrap.min.js"></script>
<script src="/themes/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/themes/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/themes/inspinia/js/plugins/pace/pace.min.js"></script>
<script src="/themes/inspinia/js/inspinia.js"></script>
<script>
    var route = '{!! Route::current()->getName() !!}';
</script>
<script src="/js/app.js"></script>

</html>
