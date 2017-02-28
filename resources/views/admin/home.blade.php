@extends('admin.layouts.admin')

@section('javascript')
    @parent
    <style type="text/css">
        ul{
           list-style: none; 
           padding:0;
        }
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
        .publish-list>li{
            margin-bottom: 10px;
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
                        <h3>{{ $data['news_count'] }}</h3>

                        <p>资讯数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a href="" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $data['category_count'] }}</h3>

                        <p>栏目数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.category.index') }}" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $data['team_count'] }}</h3>

                        <p>战队数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="{{ route('admin.team.index') }}" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $data['match_count'] }}</h3>

                        <p>赛事数量</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-speedometer"></i>
                    </div>
                    <a href="{{ route('admin.match.index') }}" class="small-box-footer">了解更多 <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        <h3 class="box-title"> 页面刷新管理</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="row publish-list">
                            <li class="col-md-12"><a href="javascript:void(0);" class="btn btn-block btn-success btn-flat" id="publish-page">更新首页</a></li>
                            <li class="col-md-6"><a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat" id="publish-category">更新所有列表页</a></li>
                            <li class="col-md-6"><a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat" id="publish-content">更新所有内容页</a></li>
                        </ul>
                    </div>
                </div>
                  <!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-plane" aria-hidden="true"></i>
                        <h3 class="box-title"> 更新缓存数据</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="row publish-list">
                            <li class="col-md-12"><a href="javascript:void(0);" class="btn btn-block btn-danger btn-flat" id="publish-blade">更新数据库缓存</a></li>
                            <li class="col-md-6"><a href="javascript:void(0);" class="btn btn-block btn-warning btn-flat" id="model-cache">更新模型文件</a></li>
                            <li class="col-md-6"><a href="javascript:void(0);" class="btn btn-block btn-primary btn-flat" id="category-blade">恢复栏目目录</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.box -->
            </div>
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
                            <li><strong>登录用户:</strong> {{ Auth::guard('admin')->user()->nickname }}</li>
                            <li><strong>所属用户组:</strong> {{ Auth::guard('admin')->user()->roles()->pluck('display_name')->implode(',') }}</li>
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
                            <li><strong>名称:</strong> BenQCms</li>
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

@section('javascript')
    @parent
    <script type="text/javascript">
        //点击发布全部自定义页面时候，采用ES6的Promise异步来显示友好界面
        $('#publish-page').click(function() {
            Summer.queue.request({
                type: 'info',
                href: "{{ route('admin.publish.page') }}",
                title: '正在发布所有的自定义页面...',
                successTitle: "所有page页发布成功!",
            });
        })
        //发布所有的栏目页面
        $('#publish-category').click(function() {
            Summer.queue.request({
                type: 'info',
                href: "{{ route('admin.publish.category') }}",
                title: '正在发布所有的栏目页面...',
                successTitle: "所有栏目页发布成功!",
            });
        })
        //发布所有的内容页面
        $('#publish-content').click(function () {
            Summer.queue.request({
                type: 'info',
                href: "{{ route('admin.publish.content') }}",
                title: '正在发布所有的内容页面...',
                successTitle: "所有内容页发布成功!",
            });
        })
        //刷新所有的模型缓存文件
        $('#model-cache').click(function () {
            Summer.queue.request({
                type: 'info',
                href: "{{ route('admin.publish.model') }}",
                title: '正在刷新所有的模型文件...',
                successTitle: "所有模型文件更新成功!",
            });
        })
        //生成所有的Blade模版文件
        $('#publish-blade').click(function () {
            Summer.queue.request({
                type: 'info',
                href: "{{ route('admin.publish.blade') }}",
                title: '正在刷新所有的模版文件...',
                successTitle: "所有模版文件发布成功!",
            });
        })

    </script>
@stop