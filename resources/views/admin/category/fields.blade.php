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
				    	{!! Form::label('route', '栏目路由',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('route', old('route'), ['class' => 'form-control','placeholder' => '如 /about']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				    	{!! Form::label('template', '使用模板',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::select('template', ['1' => '文章管理', '2' => '战队管理','3' => '文章管理','4' => '文章管理'],old('template'),['class' => 'form-control select2']) !!}
				        </div>
				    </div>
					<div class="form-group">
						{!! Form::label('name', '栏目描述',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
				            {!! Form::textarea('info', old('info'), ['class' => 'form-control','placeholder' => '| 不超过200个字符','rows'=>'6']) !!}
				        </div>
				    </div>
		      	</div>
		      	<!-- /.row -->
		    </div>
		    <!-- /.box-body -->
		</div>
	</div>
	<div class="col-md-3">
		@include('admin.widgets.publish')
		@include('admin.widgets.seo',['type'=>'category'])
	</div>
</div>

