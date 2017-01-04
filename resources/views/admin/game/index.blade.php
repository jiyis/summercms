@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-game-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">赛事列表</h3>
                        <a href="javascript:;" class="btn btn-primary header-btn" data-toggle="modal" data-target="#create_game_modal">新增赛事</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>赛事名称</th>
                                <th>概述</th>
                                <th>赛事类别</th>
                                <th>当前状态</th>
                                <th>是否默认</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>LOL S7总决赛</td>
                                    <td>LOL S7总决赛</td>
                                    <td>LOL</td>
                                    <td>已结束</td>
                                    <td><span class="label label-info">当前赛事</span></td>
                                    <td>2016-10-31</td>
                                    <td>
                                        <a href="{{ route('admin.game.edit',['id'=>0]) }}" class="btn btn-success btn-xs"><i class="fa fa-list"></i> 构建</a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#edit_game_modal" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> 编辑</a>
                                        <a class="btn btn-danger btn-xs user-delete" href="javascript:;" data-toggle="modal" data-target="#delete_game_modal"><i class="fa fa-trash-o"></i> 删除</a>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>                          
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" tabindex="-1" id="create_game_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-gamepad"></i> 新增赛事</h4>
                </div>
                <form action="{{ route('admin.game.create') }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '赛事名称']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 赛事简介，不超过200个字符','rows'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('gameclass', '赛事类别',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('gameclass', ['0'=>'LOL','1'=>'Dota'],old('gameclass'),['class' => 'form-control select2','style' => 'width: 100%;']) !!}                                        
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', '赛事状态',['class'=>'col-sm-2']) !!}
                                <div class="col-sm-8">
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
                        <input type="submit" class="btn btn-primary" value="添 加">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" id="edit_game_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-gamepad"></i> 编辑赛事</h4>
                </div>
                <form action="{{ route('admin.game.create') }}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '赛事名称']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 赛事简介，不超过200个字符','rows'=>'5']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('gameclass', '赛事类别',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('gameclass', ['0'=>'LOL','1'=>'Dota'],old('gameclass'),['class' => 'form-control select2','style' => 'width: 100%;']) !!}                                        
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', '赛事状态',['class'=>'col-sm-2']) !!}
                                <div class="col-sm-8">
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
                        <input type="submit" class="btn btn-success" value="保  存">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" id="delete_game_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-trash"></i> 确定要删除该赛事吗?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="删 除">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">

    </script>
@endsection
