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
	<div class="col-md-9">
		<div class="box box-primary">
		    <div class="box-header with-border">
		    	<i class="fa fa-edit"></i>
		      	<h3 class="box-title"> 页面编辑</h3>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
					<div class="form-group">
				        <div class="col-sm-12">
				            {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '页面标题，不超过64个字符']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				        <div class="col-sm-6">
				            {!! Form::text('url', old('url'), ['class' => 'form-control','placeholder' => '页面路由，如 /about']) !!}
				        </div>
				        <div class="col-sm-6">
				            {!! Form::text('file_name', old('file_name'), ['class' => 'form-control','placeholder' => '文件名，如 /index.html']) !!}
				        </div>
				    </div>
					<div class="form-group">
				        <div class="col-sm-12">
				            {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 页面描述，不超过200个字符','rows'=>'6']) !!}
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
						<a href="{{ route('admin.page.index') }}" class="btn btn-default">取消</a>
					</div>
				</div>
			</div><!-- panel-footer -->
		</div>
	</div>
	<div class="col-md-3">
		<div class="box box-success">
		    <div class="box-header with-border">
		      	<h3 class="box-title">发布设置</h3>
		      	
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
		      		<div class="col-sm-12 publish-label"><i class="fa fa-cloud-upload"></i> 发布状态：{!! Form::checkbox('published', old('published'),1, ['class' => 'my-switch']) !!}</div>
		      		<div class="col-sm-12 publish-label"><i class="fa fa-history" style="font-size:16px"></i> 现有版本：<span>5 <a href="#" style="text-decoration:underline">编 辑</a></span></div>
					<div class="col-sm-12 publish-label"><i class="fa fa-calendar"></i> 更新时间：<span>2016-08-01 14:56:29</span></div>
		      	</div>
		      	<!-- /.row -->
		    </div>
		    <!-- /.box-body -->
		    <div class="box-footer">
		    	<div class="row">
		    		<a href="{{ route('admin.page.index') }}" class="footer-delete-btn">删  除</a>
		    		<a href="{{ route('admin.page.index') }}" class="btn btn-default btn-xs footer-btn">返  回</a>
		    		<a href="{{ route('admin.page.index') }}" class="btn btn-success btn-xs footer-btn">更  新</a>
		    	</div>
		    	<!-- /.row -->
		    </div>
		    <!-- /.box-footer -->
		</div>
		@include('admin.widgets.layout')
		@include('admin.widgets.seo',['type'=>'page'])
	</div>
</div>

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('assets/plugins/ace/ace.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/ace/theme-cobalt.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/ace/mode-php.js') }}"></script>
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
		editor.findNext();
		editor.findPrevious();

		var textarea = $('textarea[name="content"]').hide();
		editor.getSession().setValue(textarea.val());

		// copy back to textarea on form submit...
		textarea.closest('form').submit(function () {
			textarea.val(editor.getSession().getValue());
		})
		/*editor.getSession().on('change', function(){
			textarea.val(editor.getSession().getValue());
		});*/
    </script>
@endsection