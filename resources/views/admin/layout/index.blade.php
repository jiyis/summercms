@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-layout-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-info">
                    <h4><i class="fa fa-info"></i> 如何使用:</h4>
                    <p>你可以通过布局名称调用相应的布局。如：<code>Layout::display('header')</code></p>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">布局列表</h3>
                        <a href="{{ route('admin.layout.create') }}" class="btn btn-primary header-btn">新增布局</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th><input type="checkbox"/></th>
                                <th>布局名称</th>
                                <th>中文标识</th>
                                <th>概述</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($layouts as $layout)
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td>{{ $layout->title }}</td>
                                    <td>{{ $layout->name }}</td>
                                    <td>{{ $layout->description }}</td>
                                    <td>{{ $layout->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.layout.edit',['id'=>$layout->id]) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete" data-href="{{ route('admin.layout.destroy',['id'=>$layout->id]) }}"><i class="fa fa-trash-o"></i> 删除</a>
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
