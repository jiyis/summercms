@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-category-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">栏目列表</h3>
                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary header-btn">新增栏目</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="square" id="selectall">
                                    </label>
                                </th>
                                <th>栏目名称</th>
                                <th>栏目路由</th>
                                <th>所属模型</th>
                                <th>选择模板</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" class="square selectall-item" name="id" id="id-{{ $category->id }}" value="{{ $category->id }}" />
                                        </label>
                                    </td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->url }}</td>
                                    <td>{{ $category->getModel->display_name_plural }}</td>
                                    <td>{{ $category->getTemplete->name }}</td>
                                    <td>{{ $category->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-warning btn-xs publish-btn" data-url="{{ $category->url }}"><i class="fa fa-trash-o"></i> 发布</a>
                                        <a href="{{ route('admin.category.edit',['id'=>$category->id]) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        
                                        <a class="btn btn-danger btn-xs user-delete" data-href="{{ route('admin.category.edit',['id'=>$category->id]) }}"><i class="fa fa-trash-o"></i> 删除</a>
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
                successFnc: function () {
                    return false;
                    window.location.href="{{ route('admin.category.index') }}";
                }
            });
        })
    </script>
@endsection
