@extends('admin.layouts.admin')
@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <style type="text/css">
        .game-box{ border:1px solid #e1e1e1; box-shadow: 0 1px 5px rgba(0,0,0,0.1); margin-bottom: 15px;}
        .game-box:last-child{margin-bottom: 0}
        .game-header{ padding: 10px 15px; border-bottom: 1px solid #e1e1e1; background: #ecf0f5;}
        .game-header>h4{ font-size: 18px;padding: 0; margin:0; float: left; line-height: 24px;}
        .game-header:after{ content: ''; display: block; height: 0; clear: both; }
        .game-header>h4>.label-info{margin-left: 10px;}
        .table{ margin-bottom: 0; }
        .game-body{ padding:15px; }
        .table-striped>tbody>tr:nth-of-type(odd) {background-color: #f1f1f1;}
        .table>tbody>tr>td{ vertical-align: middle; }
        .datetimepicker{border-radius: 0; margin-top: 0; padding: 6px 12px;}
    </style>
@endsection
@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-game-edit') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>
                        <h3 class="box-title"> 赛事编辑</h3>
                        <a href="javascript:;" data-toggle="modal" data-target="#create_group_modal" class="btn btn-primary pull-right">新增组别</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="padding:15px;">
                        <div class="game-box">
                            <div class="game-header">
                                <h4>小组赛A组<span class="label label-info">默认组别</span></h4>
                                <a class="btn btn-danger btn-xs pull-right" data-href="#" style="margin-left: 10px;"><i class="fa fa-times"></i></a>
                                <a href="javascript:;" class="btn btn-white btn-xs pull-right" data-toggle="modal" data-target="#edit_group_modal" style="margin-left: 10px;"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:;" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#create_match_modal"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="game-body">
                                <table class="table table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>队伍1</th>
                                            <th>队伍2</th>
                                            <th>开始时间</th>
                                            <th>是否默认</th>
                                            <th>比分</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Five</td>
                                            <td>Six</td>
                                            <td>2016.08.10</td>
                                            <td><span class="label label-info">当前比赛</span></td>
                                            <td>5:0</td>
                                            <td>
                                                <a href="#" class="btn btn-white btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs" data-href="#">删除</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Five</td>
                                            <td>Six</td>
                                            <td>2016.08.10</td>
                                            <td></td>
                                            <td>5:0</td>
                                            <td>
                                                <a href="#" class="btn btn-white btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs" data-href="#">删除</a>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>Five</td>
                                            <td>Six</td>
                                            <td>2016.08.10</td>
                                            <td></td>
                                            <td>5:0</td>
                                            <td>
                                                <a href="#" class="btn btn-white btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs" data-href="#">删除</a>
                                            </td>
                                        </tr>                                 
                                    </tbody>

                                </table>
                            </div>                                    
                        </div>   
                        <div class="game-box">
                            <div class="game-header">
                                <h4>小组赛A组<span class="label label-info">默认组别</span></h4>
                                <a class="btn btn-danger btn-xs pull-right" data-href="#" style="margin-left: 10px;"><i class="fa fa-times"></i></a>
                                <a href="javascript:;" class="btn btn-white btn-xs pull-right" data-toggle="modal" data-target="#edit_group_modal" style="margin-left: 10px;"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:;" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#create_match_modal"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="game-body">
                                <table class="table table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>队伍1</th>
                                            <th>队伍2</th>
                                            <th>开始时间</th>
                                            <th>是否默认</th>
                                            <th>比分</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Five</td>
                                            <td>Six</td>
                                            <td>2016.08.10</td>
                                            <td><span class="label label-info">当前比赛</span></td>
                                            <td>5:0</td>
                                            <td>
                                                <a href="#" class="btn btn-white btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs" data-href="#">删除</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Five</td>
                                            <td>Six</td>
                                            <td>2016.08.10</td>
                                            <td></td>
                                            <td>5:0</td>
                                            <td>
                                                <a href="#" class="btn btn-white btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs" data-href="#">删除</a>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>Five</td>
                                            <td>Six</td>
                                            <td>2016.08.10</td>
                                            <td></td>
                                            <td>5:0</td>
                                            <td>
                                                <a href="#" class="btn btn-white btn-xs">编辑</a>
                                                <a class="btn btn-danger btn-xs" data-href="#">删除</a>
                                            </td>
                                        </tr>                                 
                                    </tbody>

                                </table>
                            </div>                                    
                        </div>                       
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{ route('admin.game.index') }}" class="btn btn-default pull-right" style="margin-left: 15px;">取 消</a>
                        &nbsp;&nbsp;
                        <button class="btn btn-success pull-right">保 存</button>
                    </div><!-- panel-footer -->
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
                <form action="{{ route('admin.game.create') }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '组别名称']) !!}
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
                                            {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}设为当前组别
                                        </label>
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
                <form action="{{ route('admin.game.create') }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '组别名称']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 组别简介，不超过200个字符','rows'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8" style="margin-left:-15px;">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}设为当前组别
                                        </label>
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
                <form action="{{ route('admin.game.create') }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::label('teamA', '队伍A',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::select('teamA', ['0'=>'IG','1'=>'VG'],old('teamA'),['class' => 'form-control select2','style' => 'width: 100%;']) !!}                                        
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::label('teamB', '队伍B',['class'=>'col-sm-3 control-label no-padding']) !!}
                                    <div class="col-sm-9 no-padding">
                                        {!! Form::select('teamB', ['0'=>'IG','1'=>'VG'],old('teamB'),['class' => 'form-control select2','style' => 'width: 100%;']) !!}                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    {!! Form::text('teamA', old('teamA'), ['class' => 'form-control','placeholder' => '队伍A当前得分']) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('teamB', old('teamB'), ['class' => 'form-control','placeholder' => '队伍B当前得分']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        {!! Form::text('matchtime', old('matchtime'), ['class' => 'form-control reservationtime pull-right','placeholder' => '比赛时间','id' => 'reservationtime']) !!}
                                    </div>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('link', old('link'), ['class' => 'form-control','placeholder' => '直播或视频地址']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', '比赛状态',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-8" style="line-height:34px;margin-left:-30px;">
                                    {!! Form::radio('status', 'do',['class' => 'form-control']) !!}未开始
                                    {!! Form::radio('status', 'doing',['class' => 'form-control']) !!}正在进行
                                    {!! Form::radio('status', 'done',['class' => 'form-control']) !!}已结束
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}设为当前比赛
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="添  加">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('javascript')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript">
    $('#reservationtime').daterangepicker({
        timePicker: true, 
        timePickerIncrement: 30, 
        locale:{
            format: 'YYYY/MM/DD',
            separator: ' - ',
            applyLabel: '应用',
            cancelLabel: '取消',
            weekLabel: 'W',
            customRangeLabel: 'Custom Range',
        }
    });

    </script>
@endsection