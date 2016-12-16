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
		      	<h3 class="box-title"> 模板编辑</h3>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
					<div class="form-group">
						{!! Form::label('title', '模板名称',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '请以纯英文的方式命名']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				    	{!! Form::label('name', '中文标识',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '不超过8个中文字符']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				    	{!! Form::label('theme', '所属主题',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::select('theme', ['1' => '默认主题', '2' => '现代主题','3' => '蓝色主题','4' => '红色主题'],old('theme'),['class' => 'form-control select2']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				    	{!! Form::label('layout', '布局设置',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::select('layout', ['1' => '默认布局'],old('layout'),['class' => 'form-control select2']) !!}
				        </div>
				    </div>
					<div class="form-group">
						{!! Form::label('name', '模板描述',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
				            {!! Form::textarea('info', old('info'), ['class' => 'form-control','placeholder' => '| 不超过200个字符','rows'=>'6']) !!}
				        </div>
				    </div>
					<div class="form-group">
						{!! Form::label('list_editor', '列表模板',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
							<div id="list_editor"></div>
				        </div>
				    </div>
					<div class="form-group">
						{!! Form::label('content_editor', '内容模板',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
							<div id="content_editor"></div>
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
	</div>
</div>

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('assets/plugins/ace/ace.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/ace/theme-cobalt.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/ace/mode-php.js') }}"></script>
    <script type="text/javascript">
    	var listEditor = ace.edit("list_editor");
    	listEditor.setTheme('ace/theme/cobalt');
    	listEditor.getSession().setMode("ace/mode/php");
    	document.getElementById('list_editor').style.fontSize='14px';
    	listEditor.find('needle',{
		    backwards: false,
		    wrap: false,
		    caseSensitive: false,
		    wholeWord: false,
		    regExp: false
		});
		listEditor.findNext();
		listEditor.findPrevious();
    </script>
    <script type="text/javascript">
    	var contentEditor = ace.edit("content_editor");
    	contentEditor.setTheme('ace/theme/cobalt');
    	contentEditor.getSession().setMode("ace/mode/php");
    	document.getElementById('content_editor').style.fontSize='14px';
    	contentEditor.find('needle',{
		    backwards: false,
		    wrap: false,
		    caseSensitive: false,
		    wholeWord: false,
		    regExp: false
		});
		contentEditor.findNext();
		contentEditor.findPrevious();
    </script>
@endsection