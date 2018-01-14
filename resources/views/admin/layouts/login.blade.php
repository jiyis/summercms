<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>cloud class</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ mix('css/admin-login.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .login-page{
            background: url('/images/login-bg.jpg') no-repeat;
            background-position:right center;
        }
        .login-box{
            margin:0;
            position: absolute;
            right: 0;
            top: 25%;
            width: 480px;
        }
        .copyright-box{
            margin:0;
            position: absolute;
            right: 0;
            bottom: 10px;
            width: 480px;
            text-align: center;
        }
        @media screen and (max-width: 480px) {
            .login-box{
                width: 100%;
                top: 20%;
            }
            .copyright-box{
                width: 100%;
                font-size: 12px;
            }
        }

        .login-logo{
            font-size: 40px;
        }
        .login-logo a{
            color: #7aac6e;
        }
        .login-logo>a>b{
            color: #333;
        }
        .form-control{
            padding: 15px 45px;
            background-color: #eee;
            border:0;
        }
        .form-control-feedback {
            left: 15px;
            height: 48px;
            line-height: 48px;
        }
        .btn{
            padding: 12px 30px;
            font-size: 16px;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    @yield('content')
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="{{ mix('js/admin-login.js') }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>

