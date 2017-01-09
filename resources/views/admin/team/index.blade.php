@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-team-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">战队列表</h3>
                        <a href="{{ route('admin.team.create') }}" class="btn btn-primary header-btn">新增战队</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th><input type="checkbox"/></th>
                                <th>战队名称</th>
                                <th>所属国籍</th>
                                <th>所属区域</th>
                                <th>战队队标</th>
                                <th>所属游戏</th>
                                <th>战队状态</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teams as $team)
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ $team->nationality }}</td>
                                    <td>{{ config('common.regions')[$team->region] }}</td>
                                    <td><img src="{!! asset($team->logo) !!}" width="50" height="50"/></td>
                                    <td>{{ config('common.games')[$team->gid] }}</td>
                                    <td>{!! $team->status !!}</td>
                                    <td>{{ $team->created_at->toDateTimeString() }}</td>
                                    <td>
                                        <a href="{{ route('admin.team.edit',['id'=>$team->id]) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete" data-href="{{ route('admin.team.destroy',['id'=>$team->id]) }}"><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>                                    
                                </tr>
                            @endforeach
                            </tbody>
                        </table>                          
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $('input[class!="my-switch"]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
        $(".user-delete").click(function () {
            Rbac.ajax.delete({
                confirmTitle: '确定删除页面?',
                href: $(this).data('href'),
                successTitle: '页面删除成功'
            });
        });
    </script>
@endsection
