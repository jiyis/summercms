@extends('index.layouts.layout')

@section('css')
    <link href="/plugins/dropzone/dropzone.min.css" rel="stylesheet">
    @parent
    <style type="text/css">
        #remarks {
            overflow: hidden;
        }
    </style>
@endsection


@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('index-project-upload') !!}
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">

                {!! Form::model($project, ['route' => ['project.upload', $project->id],'class' => '', 'method' => 'post' ]) !!}

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <i class="fa fa-edit"></i>
                                <h3 class="box-title"> 项目上传图片</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="form-group">
                                        {!! Form::label('category', '品类',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                           {{ config('custom.category')[$project->category] }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('city', '城市',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4 ">
                                            {{ $project->city }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('name', '项目名称',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->name }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('business', '项目集成商',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->business }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('manager', '项目负责人',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->manager }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('model', '型号/数量',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->model }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('camera', '镜头',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->camera }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('num', '镜头数量',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->num }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('power', '把握度',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ config('custom.power')[$project->power] }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('delivery_time', '预计交货时间',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {{ $project->delivery_time }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('remarks', '项目备注',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-6">
                                            {{ $project->remarks }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('report_time', '报备时间',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-6">
                                            {{ date('Y-m-d', $project->report_time) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('review_status', '审核结果',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-2">
                                            {!! $project->review_status ? '<span class="label label-success">通过</span>' : '<span class="label label-danger">未通过</span>' !!}

                                        </div>
                                    </div>
                                    <!-- 项目审核成功后方可上传，只能上传图片压缩包' -->
                                    <div class="form-group">
                                        {!! Form::label('files', '图片打包上传（只能上传zip或rar）',['class'=>'col-sm-2 control-label']) !!}
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
                                        <a href="{{ route('project.index') }}" class="btn btn-default">取消</a>
                                    </div>
                                </div>
                            </div><!-- panel-footer -->
                        </div>
                    </div>
                </div>

                @section('javascript')
                    @parent
                    <script type="text/javascript" src="/plugins/dropzone/dropzone.min.js"></script>
                    <script type="text/javascript">

                        Dropzone.autoDiscover = false;//防止报"Dropzone already attached."的错误
                        $(".dropzone").dropzone({
                            url: "{!! route('upload.uploadfile') !!}",
                            method: "post",
                            addRemoveLinks: true,
                            dictDefaultMessage: "<span style='line-height: 50px; margin-top: 30px;'>点击或者拖拽<br>图片压缩包上传</span>",
                            dictRemoveLinks: "x",
                            dictRemoveFile: '移除文件',
                            maxFiles: 1,
                            maxFilesize: 20,
                            dictMaxFilesExceeded: "您最多只能上传1个文件！",
                            dictResponseError: '文件上传失败!',
                            dictInvalidFileType: "你不能上传该类型文件,文件类型只能是.rar,.zip,.gz,.7z,.tar.gz.",
                            dictFallbackMessage:"浏览器不受支持",
                            dictFileTooBig:"文件过大上传文件最大支持.",
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
                                    //toastr.success('上传头像失败');
                                });
                                this.on("error", function (file, error) {
                                    toastr.error(error);
                                });
                            }
                        });

                    </script>
                @endsection
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection