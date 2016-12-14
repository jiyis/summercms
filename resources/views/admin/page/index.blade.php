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
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td>test</td>
                                    <td>page/test</td>
                                    <td>一个测试页面</td>
                                    <td><input type="checkbox" class="my-switch"/></td>
                                    <td>2016-08-01</td>
                                    <td>
                                        <a href="#" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete"data-href="#"><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>                                    
                                </tr>
                                <tr>
                                    <td><input type="checkbox"/></td>
                                    <td>test</td>
                                    <td>page/test</td>
                                    <td>一个测试页面</td>
                                    <td><input type="checkbox" class="my-switch"/></td>
                                    <td>2016-08-01</td>
                                    <td>
                                        <a href="#" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete"data-href="#"><i class="fa fa-trash-o"></i> 删除</a>
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
    </script>
@endsection
