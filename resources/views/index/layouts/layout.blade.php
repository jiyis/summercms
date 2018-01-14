<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>明基投影机项目报备系统</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @section('css')
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="/bower_components/morris.js/morris.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="/bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
        <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
            <link rel="stylesheet" href="/plugins/iCheck/all.css">
        <link rel="stylesheet" href="/plugins/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="/css/common.css">

    @show

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition sidebar-mini skin-purple">
<div class="wrapper">

    <!-- 引入公共的头部部分 -->
    @include('index._partials.header')

    <!-- 引入公共的左侧菜单部分 -->
    @include('index._partials.left')

    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- 引入公共的尾部部分 -->
    @include('index._partials.footer')


    <div class="control-sidebar-bg"></div>
</div>

@section('javascript')
    <!-- jQuery 3 -->
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Sparkline -->
    <script src="/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

    <!-- jQuery Knob Chart -->
    <script src="/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/bower_components/moment/min/moment.min.js"></script>
    <script src="/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

    <script src="/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="/plugins/iCheck/icheck.min.js"></script>
    <script src="/plugins/sweetalert/core.js"></script>
    <script src="/plugins/sweetalert/sweetalert.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>

    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/js/common.js"></script>

    {!! Toastr::message() !!}
@show

</body>
</html>
