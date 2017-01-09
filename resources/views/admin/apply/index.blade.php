@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-apply-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">报名列表</h3>
                        <a href="{{ route('admin.apply.create') }}" class="btn btn-primary header-btn">新增报名</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>标题</th>
                                <th>游戏分类</th>
                                <th>创建时间</th>
                                <th>截止时间</th>
                                <th>实时数量</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>LOL精英赛</td>
                                    <td>LOL</td>
                                    <td>2016.12.30</td>
                                    <td>2017.1.4</td>
                                    <td>16</td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> 查看</a>
                                        <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete"><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>
                                </tr>
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
                confirmTitle: '确定删除布局?',
                href: $(this).data('href'),
                successTitle: '布局删除成功'
            });
        });
    </script>
@endsection
