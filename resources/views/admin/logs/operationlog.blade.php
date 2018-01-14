@extends('admin.layouts.layout')
@section('css')
    @parent
@endsection

@section('content')
<section class="content-header">
    {!! Breadcrumbs::render('admin-logs-logs') !!}
</section>

<!-- Main content -->
<section class="index-content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="table-responsive col-md-12">
                        @if(empty($logs))
                            <div class="well text-center">暂无日志信息！</div>
                        @else
                            <table class="table table-bordered table-striped"  id="datatables">
                                <thead>
                                <th>用户名</th>
                                <th>控制器</th>
                                <th>方法</th>
                                <th>请求方法</th>
                                <th>参数</th>
                                <th>时间</th>
                                <th>IP</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        @endif
                    </div>

                </div><!-- panel-body -->
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript">
        $(function(){
            $('#datatables').dataTable({
                columnDefs:[{
                    orderable:false,//禁用排序
                    'aTargets':[0,3,4,5,6]   //指定的列
                }],
                //order: [[ 1, "asc" ]],
                autoWidth: true,
                //"bPaginate": false, 不分页
                language: {
                    url: '/language/datatables-zh.json'
                },
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    "url":"{{ route('admin.operationlog.ajax') }}",
                    "dataType":"json", //返回来的数据形式
                    /*"data": function ( d ) {
                     //添加额外的参数传给服务器
                     d.status = $('#status').val();
                     }*/
                },
                columns: [
                    { "data": "username" },
                    { "data": "controller" },
                    { "data": "action" },
                    { "data": "method" },
                    { "data": "querystring" },
                    { "data": "created_at" },
                    { "data": "ip" }
                ]
            });
        })
    </script>
@endsection