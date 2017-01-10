@extends('admin.layouts.admin')

@section('javascript')
    @parent
    <style type="text/css">
        .info-list{
            line-height: 2;
            font-size: 16px;
            list-style: none;
            padding: 0;
            padding-left: 30px;
        }
        .info-list strong{
            margin-right: 5px;
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        {!! Breadcrumbs::render('admin-home-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>150</h3>

                        <p>资讯数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>11</h3>

                        <p>栏目数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>140</h3>

                        <p>战队数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="#" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>11</h3>

                        <p>赛事数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-speedometer"></i>
                    </div>
                    <a href="#" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
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
                            <li><strong>登录用户:</strong> luck</li>
                            <li><strong>所属用户组:</strong> 超级管理员</li>
                            <li><strong>上次登录时间:</strong> 2017-01-03 16:47:54</li>
                            <li><strong>登录IP:</strong> 218.4.236.4:64875</li>
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
                            <li><strong>名称:</strong> BenQCms</li>
                            <li><strong>版本号:</strong> 1.0</li>
                            <li><strong>更新时间:</strong> 2017-01-04 16:47:54</li>
                            <li><strong>文档下载:</strong> <a href="#"><i class="fa fa-download"></i>用户手册</a></li>
                        </ul>
                    </div>
                </div>
                  <!-- /.box -->
            </div>
  
        </div>

    </section>
@endsection