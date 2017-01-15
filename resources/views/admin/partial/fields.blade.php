@section('css')
    @parent
	<style type="text/css">
	#editor {
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
		      	<h3 class="box-title"> 部件编辑</h3>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
					<div class="form-group">
						{!! Form::label('title', '部件名称',['class'=>'col-sm-1 control-label']) !!}
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
						{!! Form::label('group', '所属分类',['class'=>'col-sm-1 control-label']) !!}
						<div class="col-sm-10">
							{!! Form::text('group', old('group'), ['class' => 'form-control','placeholder' => '| 不超过200个字符','rows'=>'6']) !!}
						</div>
					</div>

					<div class="form-group">
				        <div class="col-sm-12">
							<div id="editor"></div>
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
						<a href="{{ route('admin.partial.index') }}" class="btn btn-default">取消</a>
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
    	var editor = ace.edit("editor");
    	editor.setTheme('ace/theme/cobalt');
    	editor.getSession().setMode("ace/mode/php");
    	document.getElementById('editor').style.fontSize='14px';
    	editor.find('needle',{
		    backwards: false,
		    wrap: false,
		    caseSensitive: false,
		    wholeWord: false,
		    regExp: false
		});
        editor.$blockScrolling = Infinity;
		editor.findNext();
		editor.findPrevious();
		var textarea = $('textarea[name="content"]').hide();
		editor.getSession().setValue(textarea.val());

		// copy back to textarea on form submit...
		textarea.closest('form').submit(function () {
			textarea.val(editor.getSession().getValue());
		})
    </script>
@endsection