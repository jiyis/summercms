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
	<div class="col-md-12">
		<div class="box box-primary">
		    <div class="box-header with-border">
		    	<i class="fa fa-edit"></i>
		      	<h3 class="box-title"> 搜索模板编辑</h3>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
					<div class="form-group">
						{!! Form::label('title', '搜索模板名称',['class'=>'col-sm-1 control-label']) !!}
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
				    	{!! Form::label('model', '所属模型',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::select('model', $models,old('model'),['class' => 'form-control select2']) !!}
				        </div>
				    </div>
                    <div class="form-group">
                        {!! Form::label('layout', '所属布局',['class'=>'col-sm-1 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('layout', $layouts,old('layout'),['class' => 'form-control select2']) !!}
                        </div>
                    </div>
					<div class="form-group">
						{!! Form::label('description', '搜索模板描述',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
				            {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 不超过200个字符','rows'=>'6']) !!}
				        </div>
				    </div>
					<div class="form-group">
						{!! Form::label('content', '搜索模板',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
							<div id="content_editor"></div>
                            {!! Form::textarea('content', old('content'), ['class' => 'form-control hidden']) !!}
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
                        <a href="{{ route('admin.search.index') }}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div><!-- panel-footer -->
		</div>
	</div>

</div>

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('assets/package/ace/ace.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/package/ace/theme-cobalt.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/package/ace/mode-php.js') }}"></script>
    <script type="text/javascript">

        //内容模版
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
        contentEditor.$blockScrolling = Infinity


        var con_textarea = $('textarea[name="content"]').hide();
        contentEditor.getSession().setValue(con_textarea.val());

        // copy back to textarea on form submit...
        con_textarea.closest('form').submit(function () {
            con_textarea.val(contentEditor.getSession().getValue());
        })
    </script>
@endsection