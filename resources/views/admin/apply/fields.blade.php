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
	                    	{!! Form::label('endtime', '截止时间',['class'=>'col-sm-2 control-label']) !!}
	                        <div class="col-sm-10">
	                            {!! Form::text('endtime', old('endtime'), ['class' => 'form-control datetimepicker']) !!}
	                        </div>
	                    </div>
	                    <div class="form-group">
	                    	{!! Form::label('people', '人数要求',['class'=>'col-sm-2 control-label']) !!}
	                        <div class="col-sm-10">
	                            {!! Form::select('people', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9'], '5', ['class' => 'form-control select2']) !!}
	                        </div>
	                    </div>
	  
						<div class="form-group">
							{!! Form::label('column', '收集信息',['class'=>'col-sm-2 control-label']) !!}
					        <div class="col-sm-10">
					        	<select class="form-control select2" multiple="multiple" id="coltags" name="column[]">
					        		<option value="姓名" selected>姓名</option>
					        	</select>
					        </div>
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

@section('javascript')
    @parent
    <script type="text/javascript"
            src="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('/assets/plugins/datetimepicker/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript">
    	$('document').ready(function () {
	        $('.datetimepicker').datetimepicker({
	            language: 'zh-CN',
	            autoclose: true,
	        });
	        $("#coltags").select2({
	            tags: ['ID'],
	            tokenSeparators: [',', ' '],
	        });    		

	        //preview
	        var listCol = 0; //列数
	        var listRow = 0; //行数
	        var listArr = new Array();

	        var canvas = document.getElementById('myCanvas');
	        var canW = $('.preview-canvas').width();
	        var canH = $('.preview-canvas').height();
	        canvas.width = canW;
	        canvas.height = canH;
	        var ctx = canvas.getContext('2d');
			draw();

	        $('#people').on('change',function () {
	        	draw();
	        })

	        $('#coltags').on('change',function () {
	        	draw();
	        })

	        function draw() {
	        	ctx.clearRect(0,0,canW,canH); //清空画布
	        	listRow = parseInt($('#people').val());
	        	listArr = $('#coltags').val();
	        	if (listArr != null){
	        		listCol = listArr.length;
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
					if (i != 0){
						ctx.fillText("队员", 0, 180 + i*30);
					}else{
						ctx.fillText("队长", 0, 180 + i*30);
					}
				}

				for (var i = 0; i < listCol; i++){
					ctx.fillText(listArr[i], 75*(i+1)+0.5, 155);
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