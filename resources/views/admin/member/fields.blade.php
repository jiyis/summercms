<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h3 class="box-title"> 客户编辑</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('name', '用户名',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '请填写用户名']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('nickname', '昵称',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4 ">
                            {!! Form::text('nickname', old('nickname'), ['class' => 'form-control','placeholder' => '请填写昵称']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('category', '产品类型',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('category', config('custom.category'), null, ['class' => 'form-control select2']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', '邮箱',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('email', old('email'), ['class' => 'form-control','placeholder' => '邮箱']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', '密码',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-10">
                        <button class="btn bg-blue">保存</button>
                        &nbsp;
                        <a href="{{ route('admin.member.index') }}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div><!-- panel-footer -->
        </div>
    </div>
</div>
