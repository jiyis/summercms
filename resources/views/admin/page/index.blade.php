@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-page-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">页面列表</h3>
                        <a href="{{ route('admin.page.create') }}" class="btn btn-primary header-btn">新增页面</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th><input type="checkbox"/></th>
                                <th>页面名称</th>
                                <th>路由</th>
                                <th>概述</th>
                                <th>是否启用</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td>{{ $page->title }}</td>
                                    <td>{{ $page->url }}</td>
                                    <td>{{ $page->description }}</td>
                                    <td>{{ $page->published }}</td>
                                    <td>{{ $page->created_at }}</td>
                                    <td>
                                        <a class="btn btn-success btn-xs publish-btn" data-url="{{ $page->url }}"><i class="fa fa-paper-plane" aria-hidden="true"></i> 发布</a>
                                        <a href="{{ route('admin.page.edit',['id'=>$page->id]) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>

                                        <a class="btn btn-danger btn-xs user-delete" data-href="{{ route('admin.page.destroy',['id'=>$page->id]) }}"><i class="fa fa-trash-o"></i> 删除</a>
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
        $('.publish-btn').click(function(){
            Rbac.ajax.request({
                successTitle: "发布成功!",
                close: true,
                href: "{{ route('admin.publish') }}",
                data: {url:$(this).data('url')},
            });
        })
    </script>
@endsection
