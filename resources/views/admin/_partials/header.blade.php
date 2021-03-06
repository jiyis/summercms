<header class="main-header">
    <!-- Logo -->
    <a class="logo">
        <span class="logo-mini">BenQ</span>
        <span class="logo-lg"><b>{{ Voyager::setting('seo_title') }}</b></span>
    </a>

    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-refresh" aria-hidden="true"></i> 数据更新</a></li>
                <li><a href="#" target="_blank"><i class="fa fa-laptop" aria-hidden="true"></i> 网站首页</a></li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/assets/images/user.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::guard('admin')->user()->nickname }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/assets/images/user.jpg" class="img-circle" alt="User Image">

                            <p>
                                SummerCms -- {{ Auth::guard('admin')->user()->nickname }}
                                <small>上次登录 {{ Auth::guard('admin')->user()->updated_at->toFormattedDateString() }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--<li class="user-body">
                          <div class="row">
                            <div class="col-xs-4 text-center">
                              <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                              <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                              <a href="#">Friends</a>
                            </div>
                          </div>
                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">个人中心</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>