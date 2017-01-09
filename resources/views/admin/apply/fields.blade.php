@section('css')
    @parent
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
    <style type="text/css">
        .datetimepicker {
            border-radius: 0;
            margin-top: 0;
            padding: 6px 12px;
        }
        .preview-title{
        	margin-top: 0;
        	margin-bottom: 15px;
        	color: #3c8dbc;
        }
        .preview-canvas{
        	width: 100%;
        	padding: 15px;
        	height: 500px;
        	border: 1px dashed #ccc;
        }
        #myCanvas{
        	width: 100%;
        	height: 100%;
        }
    </style>
@endsection

<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
		    <div class="box-header with-border">
		    	<i class="fa fa-edit"></i>
		      	<h3 class="box-title"> 报名编辑</h3>
		    </div>
		    <!-- /.box-header -->
		    <div class="box-body">
		      	<div class="row">
		      		<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('title', '标题',['class'=>'col-sm-2 control-label']) !!}
					        <div class="col-sm-10">
					            {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '中文字符不多于16个']) !!}
					        </div>
					    </div>

			            <div class="form-group">
			                {!! Form::label('gid', '关联游戏',['class'=>'col-sm-2 control-label']) !!}
			                <div class="col-sm-10">
			                    {!! Form::select('gid', config('common.games'), null, ['class' => 'form-control select2']) !!}
			                </div>
			            </div>
	                    <div class="form-group">
	                    	{!! Form::label('deadline', '截止时间',['class'=>'col-sm-2 control-label']) !!}
	                        <div class="col-sm-10">
	                            {!! Form::text('deadline', old('deadline'), ['class' => 'form-control datetimepicker']) !!}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	{!! Form::label('row', '报名人员',['class'=>'col-sm-2 control-label']) !!}
	                        <div class="col-sm-10">
                                {!! Form::select('row[]', ['队长'=>'队长'], old('row','队长'), ['class' => 'form-control select2', 'id'=>'people', 'multiple' => 'multiple']) !!}
	                        </div>
	                    </div>
	  
						<div class="form-group">
							{!! Form::label('column', '收集信息',['class'=>'col-sm-2 control-label']) !!}
					        <div class="col-sm-10">
                                {!! Form::select('column[]', ['姓名'=>'姓名'], old('column','姓名'), ['class' => 'form-control select2', 'id'=>'coltags', 'multiple' => 'multiple']) !!}
					        </div>
					    </div>

                        <div class="form-group">
                            {!! Form::label('area', '赛区设置',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('area', old('area',config('common.area')), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('description', '赛事简介',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('description', null, ['class' => 'tooltips','id' => 'description']) !!}
                            </div>
                        </div>


					    <div class="form-group">
					    	<h4>注意事项</h4>
					    	<ol>
					    		<li>【报名人员】不支持相同名称输入，请用“队员1，队员2”的方式对不同行进行区别。</li>
					    		<li>【报名人员】不支持相同名称输入，请用“队员1，队员2”的方式对不同行进行区别。</li>
					    	</ol>
					    </div>	      			
		      		</div>
		      		<div class="col-md-6 preview-box">
		      			<h3 class="preview-title"><i class="fa fa-eye"></i> 预览图</h3>
		      			<div class="preview-canvas">
		      				<canvas id="myCanvas">
		      					您的浏览器目前不支持Canvas，请升级您的浏览器。
		      				</canvas>
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
                        <a href="{{ route('admin.apply.index') }}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div><!-- panel-footer -->
		</div>
	</div>

</div>
@include('vendor.ueditor.assets')
@section('javascript')
    @parent
    <script type="text/javascript"
            src="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript">
        var ue = UE.getEditor('description', {
            /*toolbars: [
             ['fullscreen', 'source', 'undo', 'redo', 'bold']
             ],*/
            initialFrameHeight: 420,
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            autoFloatEnabled: false,
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    	$('document').ready(function () {
	        $('.datetimepicker').datetimepicker({
	            language: 'zh-CN',
	            autoclose: true,
	        });
	        $("#people").select2({
	            tags: true,
	            tokenSeparators: [',', ' '],
	        });
	        $("#coltags").select2({
	            tags: ['ID'],
	            tokenSeparators: [',', ' '],
	        });

            //preview
	        var listCol = 0; //列数
	        var listRow = 0; //行数
	        var listColArr = new Array(); //列名
	        var listRowArr= new Array(); //行名

	        var canvas = document.getElementById('myCanvas');
	        var canW = $('.preview-canvas').width();
	        var canH = $('.preview-canvas').height();
	        canvas.width = canW;
	        canvas.height = canH;
	        var ctx = canvas.getContext('2d');
			draw();

	        $('#people').on('change',function () {
	        	draw();
	        });

	        $('#coltags').on('change',function () {
	        	draw();
	        });

	        function draw() {
	        	ctx.clearRect(0,0,canW,canH); //清空画布
	        	listRowArr = $('#people').val();
	        	listColArr = $('#coltags').val();
	        	if (listRowArr != null){
	        		listRow = listRowArr.length;
	        	}else{
	        		return false;
	        	}
	        	if (listColArr != null){
	        		listCol = listColArr.length;
	        	}else{
	        		return false;
	        	}

	        	ctx.font = "18px 'Source Sans Pro','Microsoft YaHei',arial,sans-serif ";
				ctx.fillStyle = "#3c8dbc";
				ctx.fillText("队员信息", 0, 120);

	        	ctx.font = "14px 'Source Sans Pro','Microsoft YaHei',arial,sans-serif ";
			    ctx.fillStyle = "#666";
			    ctx.strokeStyle = "#ccc";
			    ctx.lineWidth = 1;

			    ctx.fillText("赛区", 0, 22);
			    ctx.beginPath();
				ctx.rect(75.5, 0.5, 200, 30);
				ctx.stroke();
				ctx.closePath();

			    ctx.fillText("战队名称", 0, 62);
			    ctx.beginPath();
				ctx.rect(75.5, 40.5, 200, 30);
				ctx.stroke();
				ctx.closePath();

				for (var i = 0; i < listRow; i++){
					ctx.fillText(listRowArr[i], 0, 180 + i*30);
				}

				for (var i = 0; i < listCol; i++){
					ctx.fillText(listColArr[i], 75*(i+1)+0.5, 155);
					for (var j = 0; j<listRow; j++){
					    ctx.beginPath();
						ctx.rect(75*(i+1)+0.5, 165 + j*30 + 0.5, 75, 20);
						ctx.stroke();
						ctx.closePath();
					}
				}
	        }
 		});
    </script>
@endsection