<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/user.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('web')->user()->nickname }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>
        <!-- search form -->
        <!--         <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                          </span>
                    </div>
                </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主要导航</li>
            <li class="{{ \Route::currentRouteName() == 'home' ? "active" : "" }}"><a href="/">管理中心</a> </li>
            <li class="{{ \Route::currentRouteName() == 'home.center' ? "active" : "" }}"><a href="/center">个人中心</a> </li>
            <li class="treeview {{ \Route::currentRouteName() == 'project.index' ? "active" : "" }}">
                <a href="#">
                    <span>项目管理</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ \Route::currentRouteName() == 'project.index' ? "active" : "" }}"><a href="{{ route("project.index") }}"><i class="fa fa-circle-o"></i>  项目列表</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
