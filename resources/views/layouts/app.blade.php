<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BenQ</title>
    <link  rel="stylesheet" href="assets/css/app.css"> 
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    BenQ
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="javascript:;" target="_self" id="login_btn" data-toggle="modal" data-target="#loginModal">登 录</a></li>
                        <li><a href="javascript:;" target="_self" id="register_btn" data-toggle="modal" data-target="#loginModal">注 册</a></li>
                        <li><a href="{{ url('/user') }}">用户设置</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
       @yield('content')   
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
               <a href="javascript:;" class="modal-close" data-dismiss="modal"><span aria-hidden="true">&times;</span></a>
              <div class="header-login tab-login-current">账户登录</div>
              <div class="header-register">快速注册</div>
          </div>
          <div class="modal-body">
            <div class="login-body" style="display:none">
                @include("auth.login")
            </div> 
            <div class="register-body" style="display:none">
                @include("auth.register")
            </div> 
          </div>
        </div>
      </div>
    </div>
    <!-- JavaScripts -->
    <script src="assets/js/app.js"></script>
</body>
</html>
