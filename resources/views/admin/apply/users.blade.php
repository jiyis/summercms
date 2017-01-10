@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-apply-users') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">{{ $apply->title }}报名人员列表</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>所选赛区</th>
                                <th>战队名称</th>
                                <th>详情信息</th>
                                <th>IP地址</th>
                                <th>创建时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->area }}</td>
                                    <td>{{ $user->team }}</td>
                                    <td><button class="btn btn-success btn-xs show-details">点击查看</button></td>
                                    <td>{{ $user->ip }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>                          
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 模态框（Modal） -->
    <div class="modal fade text-center" id="details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="display: inline-block; width: 800px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">报名详情</h4>
                </div>
                <div class="modal-body  text-left">
                    <table class="table  table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            @foreach(explode('||', $apply->column) as $column)
                            <th>{{ $column }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(explode('||', $apply->row) as $row)
                        <tr>
                            <td>{{ $row }}</td>
                            <td>Tanmay</td>
                            <td>Bangalore</td>
                            <td>560001</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">关闭</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
@section('javascript')
    @parent
    <script type="text/javascript">
        $('.show-details').click(function() {
            $('#details').modal();
        })
    </script>
@endsection

