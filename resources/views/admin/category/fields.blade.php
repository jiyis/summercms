@section('css')
    @parent
	<style type="text/css">
	#list_editor,#content_editor {
		width: 100%;
		min-height: 460px;
    }
	</style>
@endsection

<div class="row">
	<div class="col-md-9">
		<div class="box box-primary">
		    <div class="box-header with-border">
		    	<i class="fa fa-edit"></i>
		      	<h3 class="box-title"> 栏目编辑</h3>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
					<div class="form-group">
						{!! Form::label('title', '栏目名称',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '不超过8个字符']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				    	{!! Form::label('url', '栏目路由',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('url', old('url'), ['class' => 'form-control','placeholder' => '如 /about']) !!}
				        </div>
				    </div>
                    <div class="form-group">
                        {!! Form::label('parent_id', '父级栏目',['class'=>'col-sm-1 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('parent_id', ['0' => '顶级栏目',],old('parent_id'),['class' => 'form-control select2']) !!}
                        </div>
                    </div>
				    <div class="form-group">
				    	{!! Form::label('model', '所属模型',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::select('model', $models,old('model'),['class' => 'form-control select2']) !!}
				        </div>
				    </div>
                    <div class="form-group">
                        {!! Form::label('template', '使用模板',['class'=>'col-sm-1 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('template', $templetes,old('template'),['class' => 'form-control select2']) !!}
                        </div>
                    </div>
					<div class="form-group">
						{!! Form::label('description', '栏目描述',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
				            {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 不超过200个字符','rows'=>'6']) !!}
				        </div>
				    </div>
		      	</div>
		      	<!-- /.row -->
		    </div>
		    <!-- /.box-body -->
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-10">
                        <button class="btn bg-blue">保存</button>
                        &nbsp;
                        <a href="{{ route('admin.template.index') }}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div><!-- panel-footer -->
		</div>
	</div>
	<div class="col-md-3">
		@include('admin.widgets.publish')
		@include('admin.widgets.seo',['type'=>'category'])
	</div>
</div>
@section('javascript')
    @parent
    <script type="text/javascript">
        var url = $("input[name='url']").val();
        $('#publish-btn').click(function(){
            Rbac.ajax.request({
                successTitle: "发布成功!",
                href: "{{ route('admin.publish') }}",
                data: {url:url},
                successFnc: function () {
                    window.location.href="{{ route('admin.category.index') }}";
                }
            });
        })

    </script>
@endsection
