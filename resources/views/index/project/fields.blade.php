@section('css')
    <link href="/plugins/dropzone/dropzone.min.css" rel="stylesheet">
    @parent
    <link rel="stylesheet" type="text/css"
          href="/plugins/datetimepicker/bootstrap-datepicker.min.css">
    <style type="text/css">
        #remarks {
            overflow: hidden;
        }
    </style>
@endsection

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-edit"></i>
                <h3 class="box-title"> 项目编辑</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="form-group">
                        {!! Form::label('category', '品类',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('category', config("custom.category"), null, ['class' => 'form-control select2', 'placeholder' => '请选择品类']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('city', '城市',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4 ">
                            {!! Form::text('city', old('city'), ['class' => 'form-control','placeholder' => '请填写城市']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', '项目名称',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '项目名称/客户名称']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('business', '项目集成商',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('business', old('business'), ['class' => 'form-control','placeholder' => '项目操作集成商/总包名称']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('manager', '项目负责人',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('manager', old('manager'), ['class' => 'form-control','placeholder' => '项目负责人']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('model', '型号/数量',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::textarea('model', old('model'), ['class' => 'form-control','placeholder' => '请填写型号和数量，如A型号数量3','rows'=>'8']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('camera', '镜头/数量',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::textarea('camera', old('camera'), ['class' => 'form-control','placeholder' => '请填写型号和数量，如A型号数量3','rows'=>'8']) !!}
                        </div>
                    </div>
                    <!--<div class="form-group">
                        {!! Form::label('num', '镜头数量',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('num', old('num'), ['class' => 'form-control','placeholder' => '请填写镜头数量']) !!}
                        </div>
                    </div>-->
                    <div class="form-group">
                        {!! Form::label('power', '把握度',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('power', config("custom.power"), null, ['class' => 'form-control select2','placeholder' => '请选择项目把握度']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('delivery_time', '预计交货时间',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('delivery_time', old('delivery_time'), ['class' => 'form-control datetimepicker','placeholder' => '交货日期/预计交货时间']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('remarks', '项目备注',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::textarea('remarks', old('remarks'), ['class' => 'form-control','placeholder' => '备注（项目进展、需要支持）（跨区项目需特别标注）','rows' => 15]) !!}
                        </div>
                    </div>
                    <!-- 项目审核成功后方可上传，只能上传图片压缩包' -->
                    <div class="form-group hide">
                        {!! Form::label('files', '图片打包上传',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            <div id="project-files" class="dropzone dropzone-pic" ></div>
                            {!! Form::hidden('files', old('files'), ['id' => 'userpicval']) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-10">
                        <button class="btn bg-blue">保存</button>
                        &nbsp;
                        <a href="{{ route('admin.project.index') }}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div><!-- panel-footer -->
        </div>
    </div>
</div>

@section('javascript')
    @parent
    <script type="text/javascript" src="/plugins/dropzone/dropzone.min.js"></script>
    <script type="text/javascript" src="/plugins/datetimepicker/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/plugins/datetimepicker/bootstrap-datepicker.zh-CN.min.js"></script>
    <script type="text/javascript">
        $('.datetimepicker').datepicker({
            language: 'zh-CN',
            autoclose: true,
            format: 'yyyy-mm-dd'
        });


        Dropzone.autoDiscover = false;//防止报"Dropzone already attached."的错误
        $(".dropzone").dropzone({
            url: "{!! route('admin.upload.uploadfile') !!}",
            method: "post",
            addRemoveLinks: true,
            dictDefaultMessage: "<span style='line-height: 50px; margin-top: 30px;'>点击或者拖拽<br>图片压缩包上传</span>",
            dictRemoveLinks: "x",
            dictRemoveFile: '移除文件',
            maxFiles: 1,
            maxFilesize: 20,
            //autoDiscover:false,
            acceptedFiles: ".rar,.zip,.gz,.7z,.tar.gz",
            sending: function (file, xhr, formData) {
                formData.append("_token", $('[name=_token]').val());
                formData.append("details", JSON.stringify($('#'+this.element.id).data('details')));
            },
            init: function () {
                //如果已经上传，显示出来
                var myDropzone = this;
                if($('#userpicval').val() != ""){
                    var mockFile = { name: '项目图片' };
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, $('#userpicval').val());
                    $('.dz-progress').remove();
                    $('.dz-size').empty();
                }
                this.on("success", function (file, result) {
                    if(result.code == '0'){
                        swal({title:'上传失败，错误原因：'+result.msg,confirmButtonColor: "#DD6B55"});
                        myDropzone.removeFile(file);
                        return false;
                    }
                    $('#userpicval').val(result.path);
                });
                this.on("removedfile", function (file) {
                    console.log("上传头像失败");
                    //toastr.success('上传头像失败');
                });
            }
        });

    </script>
@endsection