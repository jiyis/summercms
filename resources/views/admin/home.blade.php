@extends('admin.layouts.layout')


@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            控制台
            <small>主页</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 控制台</a></li>
            <li class="active">主页</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>60</h3>

                        <p>项目总数</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>10</h3>
                        <p>待审核项目</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>70</h3>
                        <p>客户总数</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>20</h3>

                        <p>审核通过项目</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

    </section>
    <!-- /.content -->
    <!-- Main content -->
    <section class="index-content">
        <!-- /.row -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <i class="fa fa-user-circle"></i>
                        <h3 class="box-title"> 登录信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="info-list">
                            <li><strong>登录用户:</strong> {{ Auth::guard('admin')->user()->name }}</li>
                            <li><strong>所属用户组:</strong> {{ Auth::guard('admin')->user()->nickname }}</li>
                            <li><strong>上次登录时间:</strong> {{ Auth::guard('admin')->user()->last_login_at }}</li>
                            <li><strong>登录IP:</strong>{{ Auth::guard('admin')->user()->ip }}</li>
                            <li><strong>网站服务器:</strong>{{ $data['server'] }}</li>
                            <li><strong>域名:</strong>{{ $data['http_host'] }}</li>
                            <li><strong>User Agent:</strong>{{ $data['user_agent'] }}</li>

                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box box-widget">
                    <div class="box-header with-border">
                        <i class="fa fa-cogs"></i>
                        <h3 class="box-title"> 系统信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="info-list">
                            <li><strong>名称:</strong> CloudCms</li>
                            <li><strong>版本号:</strong> 1.0</li>
                            <li><strong>更新时间:</strong> 2017-01-04 16:47:54</li>
                            <li><strong>文档下载:</strong> <a href="#"><i class="fa fa-download"></i>用户手册</a></li>
                            <li><strong>PHP版本:</strong>{{ $data['php'] }}</li>
                            <li><strong>PHPHandler:</strong>{{ $data['sapi_name'] }}</li>
                            <li><strong>数据库:</strong>{{ $data['db_connection'] }}--{{ $data['db_version'] }}</li>
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>

        </div>

    </section>
@endsection
