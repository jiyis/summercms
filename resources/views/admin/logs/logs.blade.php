@extends('admin.layouts.admin')
@section('css')
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    @parent
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            {!! Breadcrumbs::render('admin-logs-logs') !!}
        </section>

        <!-- Main content -->
        <section class="content" style="width: 96%;">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="table-responsive col-md-12">
                                @if($logs->isEmpty())
                                    <div class="well text-center">暂无日志信息！</div>
                                @else
                                    <table class="table table-responsive"  id="datatables">
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
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>{!! $log->username !!}</td>
                                                <td>{!! $log->controller !!}</td>
                                                <td>{!! $log->action !!}</td>
                                                <td>{!! $log->method !!}</td>
                                                <td>{!! $log->querystring !!}</td>
                                                <td>{!! $log->created_at !!}</td>
                                                <td>{!! $log->ip !!}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            </div>

                        </div><!-- panel-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('javascript')
    @parent
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
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
                    url: '/assets/language/datatables-zh.json'
                },
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    "url":"{{ route('admin.logs.getlogs') }}",
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