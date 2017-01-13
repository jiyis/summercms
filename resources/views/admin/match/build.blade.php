@extends('admin.layouts.admin')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
    <style type="text/css">
        .game-box {
            border: 1px solid #e1e1e1;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .game-box:last-child {
            margin-bottom: 0
        }

        .game-header {
            padding: 10px 15px;
            border-bottom: 1px solid #e1e1e1;
            background: #ecf0f5;
        }

        .game-header > h4 {
            font-size: 18px;
            padding: 0;
            margin: 0;
            float: left;
            line-height: 24px;
        }

        .game-header:after {
            content: '';
            display: block;
            height: 0;
            clear: both;
        }

        .game-header > h4 > .label-info {
            margin-left: 10px;
        }

        .table {
            margin-bottom: 0;
        }

        .game-body {
            padding: 15px;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f1f1f1;
        }

        .table > tbody > tr > td {
            vertical-align: middle;
        }

        .datetimepicker {
            border-radius: 0;
            margin-top: 0;
            padding: 6px 12px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-match-build') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title"> 赛事构建</h3>
                        <button data-toggle="modal" data-target="#create_group_modal"
                           class="btn btn-primary pull-right">新增组别</button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="padding:15px;">
                        @foreach($groups as $group)
                        <div class="game-box">
                            <div class="game-header">
                                <h4>{{ $group->name }} {!! $group->default ? '<span class="label label-info">默认组别</span>' : '' !!}</h4>
                                <a class="btn btn-danger btn-xs pull-right user-delete" data-href="{{ route('admin.match.group.delete', ['id' => $group->id]) }}" style="margin-left: 10px;"><i class="fa fa-times"></i></a>
                                <button class="btn btn-white btn-xs pull-right edit-group"  data-id="{{ $group->id }}" data-name="{{ $group->name }}" data-default="{{ $group->default }}" data-description="{{ $group->description }}" style="margin-left: 10px;"><i
                                            class="fa fa-pencil"></i></button>
                                <button class="btn btn-success btn-xs pull-right add-match-details" data-id="{{ $group->id }}"><i class="fa fa-plus"></i></button>
                            </div>
                            <div class="game-body">
                                <table class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>队伍1</th>
                                        <th>队伍2</th>
                                        <th>队伍1队标</th>
                                        <th>队伍2队标</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>比分</th>
                                        <th>是否默认</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($group->details as $detail)
                                    <tr>
                                        <td>{{ $detail->teamA->name }}</td>
                                        <td>{{ $detail->teamB->name }}</td>
                                        <td><img src="{{ $detail->teamA->logo }}" width="50" height="50" /> </td>
                                        <td><img src="{{ $detail->teamB->logo }}" width="50" height="50" /> </td>
                                        <td>{{ $detail->starttime }}</td>
                                        <td>{{ $detail->endtime }}</td>
                                        <td>{{ $detail->score_a . ":" . $detail->score_b }}</td>
                                        <td>{!!  $detail->default ? '<span class="label label-info">当前比赛</span>' : '' !!}</td>
                                        <td>
                                            <button class="btn btn-white btn-xs edit-match-details" data-id="{{ $detail->id }}" data-group_id="{{ $detail->group_id }}" data-team_id_a="{{ $detail->team_id_a }}" data-team_id_b="{{ $detail->team_id_b }}" data-score_a="{{ $detail->score_a }}" data-score_b="{{ $detail->score_b }}" data-starttime="{{ $detail->starttime }}" data-endtime="{{ $detail->endtime }}" data-link="{{ $detail->link }}" data-status="{{ $detail->status }}">编辑</button>
                                            <a class="btn btn-danger btn-xs detail-delete" data-href="{{ route('admin.match.group-details.delete', ['id' => $detail->id]) }}">删除</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- /.box-body -->
                   
                </div>
            </div>
        </div>
    </section>
    <!--创建组别-->
    <div class="modal fade" tabindex="-1" id="create_group_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-gamepad"></i> 新增组别</h4>
                </div>
                <form action="{{ route('admin.match.group.create', $id) }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '组别名称']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 组别简介，不超过200个字符','rows'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}
                                            设为当前组别
                                        </label>
                                        {!! Form::hidden('match_id', $id,null,['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="添 加">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--编辑组别-->
    <div class="modal fade" tabindex="-1" id="edit_group_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-gamepad"></i> 编辑组别</h4>
                </div>
                <form action="" method="POST" id="edit_group_form">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => '组别名称', 'id' => 'group_title']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('description',null, ['class' => 'form-control','placeholder' => '| 组别简介，不超过200个字符','rows'=>'5', 'id' => 'group_description']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('default', 1,null,['class' => 'form-control', 'id' =>'group_default']) !!}
                                            设为当前组别
                                        </label>
                                        {!! Form::hidden('match_id', $id,null,['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" value="保  存">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--新增比赛-->
    <div class="modal fade" tabindex="-1" id="create_match_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-gamepad"></i> 新增比赛</h4>
                </div>
                <form action="{{ route('admin.match.group-details.create',$id) }}" id="create_match_form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::label('team_id_a', '队伍A',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::select('team_id_a', $teams ,old('team_id_a'),['class' => 'form-control select2','style' => 'width: 100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('team_id_b', '队伍B',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::select('team_id_b', $teams ,old('team_id_b'),['class' => 'form-control select2','style' => 'width: 100%;']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::text('score_a', old('score_a'), ['class' => 'form-control','placeholder' => '队伍A当前得分']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('score_b', old('score_b'), ['class' => 'form-control','placeholder' => '队伍B当前得分']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        {!! Form::text('starttime', old('starttime'), ['class' => 'form-control datetimepicker pull-right','placeholder' => '比赛开始时间']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        {!! Form::text('endtime', old('endtime'), ['class' => 'form-control datetimepicker pull-right','placeholder' => '比赛结束时间']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('link', old('link'), ['class' => 'form-control','placeholder' => '直播或视频地址']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', '比赛状态',['class'=>'col-sm-2']) !!}
                                <div class="col-sm-8">
                                    {!! Form::radio('status', 1,1,['class' => 'form-control']) !!}未开始
                                    {!! Form::radio('status', 2,null,['class' => 'form-control']) !!}正在进行
                                    {!! Form::radio('status', 3,null,['class' => 'form-control']) !!}已结束
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}
                                            设为当前比赛
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::hidden('group_id', null,['class' => 'form-control','id' => 'add_group_id']) !!}
                        <input type="submit" class="btn btn-primary" value="添  加">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--编辑比赛-->
    <div class="modal fade" tabindex="-1" id="edit_match_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-gamepad"></i> 编辑比赛</h4>
                </div>
                <form action="" method="post" id="edit_match_details_form">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::label('team_id_a', '队伍A',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::select('team_id_a', $teams ,null,['class' => 'form-control select2','style' => 'width: 100%;','id' => 'edit_team_id_a']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('team_id_b', '队伍B',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::select('team_id_b', $teams,null,['class' => 'form-control select2','style' => 'width: 100%;','id' => 'edit_team_id_b']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::label('score_a', '队A得分',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::text('score_a', null, ['class' => 'form-control','placeholder' => '队伍A当前得分','id' => 'score_a']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('score_b', '队B得分',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::text('score_b', null, ['class' => 'form-control','placeholder' => '队伍B当前得分','id' => 'score_b']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::label('starttime', '开始时间',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            {!! Form::text('starttime', null, ['class' => 'form-control datetimepicker pull-right','placeholder' => '比赛开始时间','id' => 'starttime']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('endtime', '结束时间',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            {!! Form::text('endtime', null, ['class' => 'form-control datetimepicker pull-right','placeholder' => '比赛结束时间','id' => 'endtime']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::label('link', '直播地址',['class'=>'control-label no-padding']) !!}

                                    {!! Form::text('link', null, ['class' => 'form-control','placeholder' => '直播或视频地址','id' => 'link']) !!}

                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', '比赛状态',['class'=>'col-sm-3']) !!}
                                <div class="col-sm-8">
                                    {!! Form::radio('status', 1,1,['class' => 'form-control edit-match-status1']) !!}未开始
                                    {!! Form::radio('status', 2,null, ['class' => 'form-control edit-match-status2'])!!}正在进行
                                    {!! Form::radio('status', 3,null,['class' => 'form-control edit-match-status3']) !!}已结束
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}
                                            设为当前比赛
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::hidden('group_id', null,['class' => 'form-control','id' => 'edit_group_id']) !!}
                        {!! Form::hidden('match_id', $id,['class' => 'form-control','id' => 'edit_group_id']) !!}
                        <input type="submit" class="btn btn-success" value="保  存">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('javascript')
    @parent
    <script type="text/javascript"
            src="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript">
        $(".user-delete").click(function () {
            Rbac.ajax.delete({
                confirmTitle: '确定删除该小组?',
                href: $(this).data('href'),
                successTitle: '小组删除成功'
            });
        });
        $(".detail-delete").click(function () {
            Rbac.ajax.delete({
                confirmTitle: '确定删除该队伍比赛?',
                href: $(this).data('href'),
                successTitle: '队伍比赛删除成功'
            });
        });

        $('.add-match-details').click(function(e) {
            //var id = $(this).data('id');
            var id = $(this).data('id');
            $('#add_group_id').val(id);
            $('#create_match_modal').modal();
        })
        //编辑分组赋值数据
        $('.edit-group').click(function (e) {
            var id = $(this).data('id');
            $('#group_title').val($(this).data('name'));
            $('#group_description').val($(this).data('description'));
            if($(this).data('default')) $('#group_default').iCheck("check");//();

            $("#edit_group_form").attr("action", "/admin/match/group/"+id);
            $('#edit_group_modal').modal();
        });

        //编辑比赛详情信息赋值数据
        $('.edit-match-details').click(function (e) {
            var id = $(this).data('id');
            var group_id = $(this).data('group_id');
            $('#edit_team_id_a').val($(this).data('team_id_a')).trigger("change");
            $('#edit_team_id_b').val($(this).data('team_id_b')).trigger("change");
            $('#score_a').val($(this).data('score_a'));
            $('#score_b').val($(this).data('score_b'));
            $('#starttime').val($(this).data('starttime'));
            $('#endtime').val($(this).data('endtime'));
            $('#link').val($(this).data('link'));
            $(".edit-match-status"+$(this).data('status')).iCheck("check");
            $('#edit_group_id').val(group_id);
            $("#edit_match_details_form").attr("action", "/admin/match/group-detail/"+id);
            $('#edit_match_modal').modal();
        });
        $('.datetimepicker').datetimepicker({
            language: 'zh-CN',
            autoclose: true
        });
    </script>
@endsection