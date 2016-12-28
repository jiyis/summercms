@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-search-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">搜索模板列表</h3>
                        <a href="{{ route('admin.search.create') }}" class="btn btn-primary header-btn">新增搜索模板</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th><input type="checkbox"/></th>
                                <th>搜索模板名称</th>
                                <th>中文标识</th>
                                <th>所属模型</th>
                                <th>概述</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($searchs as $search)
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td>{{ $search->title }}</td>
                                    <td>{{ $search->name }}</td>
                                    <td>{{ $search->getModel->display_name_plural }}</td>
                                    <td>{{ $search->description }}</td>
                                    <td>{{ $search->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.search.edit',['id'=>$search->id]) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete" data-href="{{ route('admin.search.destroy',['id'=>$search->id]) }}"><i class="fa fa-trash-o"></i> 删除</a>
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
                confirmTitle: '确定删除布局?',
                href: $(this).data('href'),
                successTitle: '布局删除成功'
            });
        });
    </script>
@endsection
