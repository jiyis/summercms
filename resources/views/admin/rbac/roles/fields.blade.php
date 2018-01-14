<div class="panel-body panel-body-nopadding">
    <div class="form-group">
        {!! Form::label('name', '角色标识',['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('name', old('name'), ['class' => 'form-control tooltips','data-toggle' => 'tooltip','data-trigger' => 'hover','data-original-title' => '不可重复']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('display_name', '显示名称',['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('display_name', old('display_name'), ['class' => 'form-control tooltips','data-toggle' => 'tooltip','data-trigger' => 'hover','data-original-title' => '不可重复']) !!}
        </div>
    </div>


    <div class="form-group">
        {!! Form::label('roles', '类别 *',['class'=>'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::select('guard_name', config('custom.guards'), null, ['class' => 'form-control select2']) !!}
        </div>
    </div>

</div><!-- panel-body -->

<div class="panel-footer">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <button class="btn bg-blue">保存</button>
            &nbsp;
            <a href="{{ route('admin.role.index') }}" class="btn btn-default">取消</a>
        </div>
    </div>
</div><!-- panel-footer -->

