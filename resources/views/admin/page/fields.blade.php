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
						{!! Form::label('title', '页面名称',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '不超过64个字符']) !!}
				        </div>
				    </div>
				    <div class="form-group">
				    	{!! Form::label('url', '页面路由',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-4">
				            {!! Form::text('url', old('url'), ['class' => 'form-control','placeholder' => '如 /about/index.html']) !!}
				        </div>
				    </div>
					<div class="form-group">
						{!! Form::label('description', '页面描述',['class'=>'col-sm-1 control-label']) !!}
				        <div class="col-sm-10">
				            {!! Form::textarea('description', old('description'), ['class' => 'form-control','placeholder' => '| 不超过200个字符','rows'=>'6']) !!}
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
        @include('admin.widgets.publish')
		@include('admin.widgets.layout')
		@include('admin.widgets.seo',['type'=>'page'])
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
        var url = $("input[name='url']").val();

        @if(isset($page->id))
         $('#publish-btn').click(function(){
            Rbac.ajax.request({
                successTitle: "发布成功!",
                href: "{{ route('admin.publish') }}",
                data: {url:url},
                successFnc: function () {
                    window.location.href="{{ route('admin.page.index') }}";
                }
            });
        })
        @else
           $('#publish-btn').attr('disabled','disabled');
        @endif


    </script>
@endsection