@section('css')
    @parent
    <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet">

@endsection
<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-edit"></i>
        <h3 class="box-title"> 战队编辑</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <!-- 战队名称 Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('name', '战队名称:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control tooltips']) !!}
                </div>
            </div>

            <!-- 国籍 Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('nationality', '国籍:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('nationality', $countrys, old('nationality'), ['class' => 'form-control tooltips nationality']) !!}
                </div>
            </div>

            <!-- 简介 Field -->
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('summary', '简介:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::textarea('summary', null, ['class' => 'tooltips','id' => 'summary']) !!}
                </div>
            </div>

            <!-- 荣誉 Field -->
            <div class="form-group col-sm-12 col-lg-12">
                {!! Form::label('honour', '荣誉:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::textarea('honour', null, ['class' => 'tooltips','id' => 'honour']) !!}
                </div>
            </div>

            <!-- 区域 Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('region', '区域:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('region', config('common.regions'), null, ['class' => 'form-control tooltips']) !!}
                </div>
            </div>

            <!-- 队标 Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('logo', '队标:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-6">
                    <div id="userpic" class="dropzone dropzone-pic" ></div>
                    {!! Form::hidden('logo', old('logo'), ['id' => 'userpicval']) !!}
                </div>
            </div>
            <div class="clearfix"></div>

            <!-- 所属游戏 Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('gid', '关联游戏:',['class'=>'col-sm-1 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('gid', config('common.games'), null, ['class' => 'form-control tooltips select2']) !!}
                </div>
            </div>

            <!-- 状态 Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('defriend', '状态:',['class'=>'col-sm-1 control-label']) !!}
                <label class="radio-inline">
                    {!! Form::radio('defriend', 1, 1) !!} 正常
                </label>
                <label class="radio-inline">
                    {!! Form::radio('defriend', 0, null) !!} 拉黑
                </label>
                <label class="radio-inline">
                    {!! Form::radio('defriend', -1, null) !!} 下架
                </label>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.box-body -->

    <!-- Submit Field -->
    <div class="panel-footer">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-10">
                {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                &nbsp;
                <a href="{!! route('admin.team.index') !!}" class="btn btn-default">取消</a>
            </div>
        </div>
    </div>
</div>

@include('vendor.ueditor.assets')
@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        $(function () {
            function setCurrency(currency) {
                if (!currency.id) {
                    return currency.text;
                }
                var str = "" + currency.element.value.toLowerCase();
                var pad = "000";
                var value = pad.substring(0, pad.length - str.length) + str
                var $currency = $('<span><img src="/countrys/flags/a' + value + '.png" class="img-flag" /> ' + currency.text + '</span>');
                return $currency;
            };
            $(".nationality").select2({
                placeholder: "选择国家", //placeholder
                templateResult: setCurrency,
                templateSelection: setCurrency
            });
        })
        var ue_summary = UE.getEditor('summary', {
            /*toolbars: [
             ['fullscreen', 'source', 'undo', 'redo', 'bold']
             ],*/
            initialFrameHeight: 420,
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            autoFloatEnabled: false,
        });
        ue_summary.ready(function () {
            ue_summary.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });

        var ue_honour = UE.getEditor('honour', {
            /*toolbars: [
             ['fullscreen', 'source', 'undo', 'redo', 'bold']
             ],*/
            initialFrameHeight: 420,
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            autoFloatEnabled: false,
        });
        ue_honour.ready(function () {
            ue_honour.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });

        Dropzone.autoDiscover = false;//防止报"Dropzone already attached."的错误
        $("#userpic").dropzone({
            url: "{!! route('admin.upload.uploadimage') !!}",
            method: "post",
            addRemoveLinks: true,
            dictDefaultMessage: "<span style='line-height: 50px;'>点击或者拖拽<br>图片到这里上传</span>",
            dictRemoveLinks: "x",
            //dictCancelUpload: "x",
            maxFiles: 1,
            maxFilesize: 5,
            //autoDiscover:false,
            acceptedFiles: "image/*",
            sending: function (file, xhr, formData) {
                formData.append("_token", $('[name=_token]').val());
            },
            init: function () {
                //如果已经上传，显示出来
                var myDropzone = this;
                if($('#userpicval').val() != ""){
                    var mockFile = { name: '战队队标' };
                    myDropzone.options.addedfile.call(myDropzone, mockFile);
                    myDropzone.options.thumbnail.call(myDropzone, mockFile, $('#userpicval').val());
                    $('.dz-progress').remove();
                    $('.dz-size').empty();
                }
                this.on("success", function (file, result) {
                    $('#userpicval').val(result.path);
                });
                this.on("removedfile", function (file) {
                    console.log("上传头像失败");
                    //toastr.success('上传头像失败');
                });
            }
        })

    </script>
@endsection
