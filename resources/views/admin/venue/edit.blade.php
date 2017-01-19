@extends('admin.layouts.admin')

@section('css')
    @parent
    <link href="{{ asset('assets/package/voyager/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet">
    @include('vendor.ueditor.assets')
@endsection

@section('content')
    <section class="content-header">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ '编辑' }}@else{{ '新增' }}@endif {{ $dataType->display_name_singular }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>控制台</a></li>
            <li><a href="{{ url('admin/'.$dataType->slug) }}"><i class="fa fa-dashboard"></i>{{ $dataType->display_name_plural }}</a></li>
            <li class="active">@if(isset($dataTypeContent->id)){{ '编辑' }}@else{{ '新增' }}@endif{{ $dataType->display_name_singular }}</li>
        </ol>
    </section>
        <section class="index-content">
            <div class="row">
                <form role="form"
                      action="@if(isset($dataTypeContent->id)){{ route('admin.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('admin.'.$dataType->slug.'.store') }}@endif"
                      method="POST" enctype="multipart/form-data">
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">@if(isset($dataTypeContent->id)){{ '编辑' }}@else{{ '新增' }}@endif {{ $dataType->display_name_singular }}</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->

                            <div class="box-body">

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @foreach($dataType->addRows as $row)
                                    @if($row->field == 'category_id') @continue @endif
                                    <div class="form-group">
                                        <label for="name"
                                               class="col-sm-1 control-label">{{ $row->display_name }}</label>
                                        <div class="col-sm-10">
                                            @if($row->type == "text")
                                                <input type="text" class="form-control" name="{{ $row->field }}"
                                                       placeholder="{{ $row->display_name }}"
                                                       value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif">
                                            @elseif($row->type == "password")
                                                @if(isset($dataTypeContent->{$row->field}))
                                                    <br>
                                                    <small>Leave empty to keep the same</small>
                                                @endif
                                                <input type="password" class="form-control" name="{{ $row->field }}"
                                                       value="">
                                            @elseif($row->type == "text_area")
                                                <textarea class="form-control"
                                                          name="{{ $row->field }}">@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif</textarea>
                                            @elseif($row->type == "rich_text_box")
                                                <script type="text/plain" id="ueditor_{{$row->field}}" name="{{$row->field}}" class="richTextBox">@if(isset($dataTypeContent->{$row->field})){!!  old($row->field, $dataTypeContent->{$row->field}) !!}@else{{old($row->field)}}@endif</script>

                                                <script type="text/javascript">
                                                    var ue = UE.getEditor('ueditor_{{$row->field}}', {
                                                        /*toolbars: [
                                                         ['fullscreen', 'source', 'undo', 'redo', 'bold']
                                                         ],*/
                                                        initialFrameHeight: 420,
                                                        autoHeightEnabled: true,
                                                        autoFloatEnabled: true,
                                                        autoFloatEnabled: false,
                                                    });
                                                </script>


                                            @elseif($row->type == "image" || $row->type == "file")
                                                @if($row->type == "image" && isset($dataTypeContent->{$row->field}))
                                                    <!--<div class="dropzone"></div>-->
                                                    <img src="{{ Voyager::image( $dataTypeContent->{$row->field} ) }}"
                                                         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                                @elseif($row->type == "file" && isset($dataTypeContent->{$row->field}))
                                                    <div class="fileType">{{ $dataTypeContent->{$row->field} }} }}</div>
                                                @endif
                                                <input type="file" name="{{ $row->field }}" class="dropzoneval">
                                            @elseif($row->type == "select_dropdown")
                                                <?php $options = json_decode($row->details); ?>
                                                <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old($row->field,
                                                                $dataTypeContent->{$row->field}))) ? old($row->field,
                                                        $dataTypeContent->{$row->field}) : old($row->field); ?>
                                                <select class="form-control select2" name="{{ $row->field }}">
                                                    <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : NULL; ?>
                                                    @if(isset($options->options))
                                                        @foreach($options->options as $key => $option)
                                                            <option value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $key){{ 'selected="selected"' }}@endif>{{ $option }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            @elseif($row->type == "radio_btn")
                                                <?php $options = json_decode($row->details); ?>
                                                <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old($row->field,
                                                                $dataTypeContent->{$row->field}))) ? old($row->field,
                                                        $dataTypeContent->{$row->field}) : old($row->field); ?>
                                                <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : NULL; ?>
                                                    @if(isset($options->options))
                                                        @foreach($options->options as $key => $option)
                                                            <label style="line-height: 30px;" class="radio-inline" for="option-{{ $key }}">
                                                                {!! Form::radio($row->field, $key, $selected_value == $key ||($default == $key && $selected_value === NULL) ? 1 : 0,['class' => 'square']) !!} {{ $option }}
                                                            </label>
                                                            <!--<li>
                                                                <input type="radio" id="option-{{ $key }}"
                                                                       name="{{ $row->field }}"
                                                                       value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $key){{ 'checked' }}@endif>
                                                                <label for="option-{{ $key }}">{{ $option }}</label>
                                                                <div class="check"></div>
                                                            </li>-->
                                                        @endforeach
                                                    @endif
                                            @elseif($row->type == "checkbox")
                                                <?php $options = json_decode($row->details); ?>
                                                <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old($row->field,
                                                                $dataTypeContent->{$row->field}))) ? old($row->field,
                                                        $dataTypeContent->{$row->field}) : old($row->field);
                                                    $selected_value = explode(',',$selected_value);
                                                ?>
                                                <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : NULL;  ?>
                                                @if(isset($options->options))
                                                    @foreach($options->options as $key => $option)
                                                        <label style="line-height: 30px;" class="radio-inline" for="option-{{ $key }}">
                                                            {!! Form::checkbox($row->field.'[]', $key, in_array($key,$selected_value) ||($default == $key && $selected_value === NULL) ? 1 : 0,['class' => 'square']) !!} {{ $option }}
                                                        </label>
                                                    @endforeach
                                                @endif
                                            @elseif($row->type == "more_images")
                                                <div id="{{ $row->field }}" class="dropzone" data-details="{{ $row->details }}"></div>
                                            <?php if(isset($dataTypeContent->{$row->field})) $value = old($row->field, $dataTypeContent->{$row->field});else $value = old($row->field); ?>
                                                {!! Form::hidden($row->field , $value, ['class' => 'morepicval','id' => $row->field.'val']) !!}

                                            @elseif($row->type == "checkbox1")

                                                <br>
                                                <?php $options = json_decode($row->details); ?>
                                                <?php $checked = (isset($dataTypeContent->{$row->field}) && old($row->field,
                                                                $dataTypeContent->{$row->field}) == 1) ? true : old($row->field); ?>
                                                @if(isset($options->on) && isset($options->off))
                                                    <input type="checkbox" name="{{ $row->field }}" class="toggleswitch"
                                                           data-on="{{ $options->on }}" @if($checked) checked
                                                           @endif data-off="{{ $options->off }}">
                                                @else
                                                    <input type="checkbox" name="{{ $row->field }}" class="toggleswitch"
                                                           @if($checked) checked @endif>
                                                @endif

                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            </div><!-- panel-body -->


                            <!-- PUT Method if we are editing -->
                            @if(isset($dataTypeContent->id))
                                <input type="hidden" name="_method" value="PUT">
                        @endif

                        <!-- CSRF TOKEN -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="box-footer">
                                <div class="col-sm-2 col-sm-offset-10">
                                    <a href="{{ route('admin.'.$dataType->slug.'.index') }}"
                                       class="btn btn-default">取消</a>

                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?php $etags = isset($etags) ? $etags : null; ?>
                        @if(isset($dataTypeContent))@include('admin.widgets.news_publish', [$category, $tags, $etags,$dataType,$dataTypeContent]) @else @include('admin.widgets.news_publish', [$category, $tags, $etags])  @endif
                        @include('admin.widgets.seo',['type'=>$dataType->slug])
                        @include('admin.widgets.cover')

                    </div>
                </form>
            </div>

        </section>
@endsection

@section('javascript')
    @parent
    <script src="{{ asset('assets/package/voyager/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/package/map/map.js') }}"></script>
    <script>
        $('document').ready(function () {
            $("#stags").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            $('.toggleswitch').bootstrapToggle();
        });
        var url = "{{$dataType->slug}}/@if(isset($dataTypeContent->id)){{ $dataTypeContent->id }}@endif";
        $('#publish-btn').click(function () {
            Rbac.ajax.request({
                successTitle: "发布成功!",
                href: "{{ route('admin.publish') }}",
                data: {url: url,model:$(this).data('model'),id:$(this).data('id')},
                successFnc: function () {
                    window.location.href = "{{ route('admin.'.$dataType->slug.'.index') }}";
                }
            });
        })
        Dropzone.autoDiscover = false;//防止报"Dropzone already attached."的错误
        $(".dropzone").dropzone({
            url: "{!! route('admin.upload.uploadimage') !!}",
            method: "post",
            addRemoveLinks: true,
            dictDefaultMessage: "<span style='line-height: 50px;'>点击或者拖拽<br>图片到这里上传</span>",
            dictRemoveLinks: "x",
            //dictCancelUpload: "x",
            maxFiles: 20,
            maxFilesize: 1,
            //autoDiscover:false,
            acceptedFiles: "image/*",
            sending: function (file, xhr, formData) {
                formData.append("_token", $('[name=_token]').val());
                formData.append("details", JSON.stringify($('#'+this.element.id).data('details')));
            },
            init: function () {
                //如果已经上传，显示出来
                var myDropzone = this;
                if($('#'+myDropzone.element.id).next().val()){
                    var morepics = $('#'+myDropzone.element.id).next().val().split('||||');
                    for(var i=0; i<morepics.length; i++){
                        var mockFile = { name: '图集' };
                        myDropzone.options.addedfile.call(myDropzone, mockFile);
                        myDropzone.options.thumbnail.call(myDropzone, mockFile, '/storage'+morepics[i]);
                    }
                    $('.dz-progress').remove();
                    $('.dz-size').empty();
                }
                this.on("success", function (file, result) {
                    var morepicval = $('#'+myDropzone.element.id).next().val();
                    if(morepicval) morepicval = morepicval+'||||';
                    $('#'+myDropzone.element.id).next().val(morepicval+result.path);

                });
                this.on("removedfile", function (file) {
                    console.log("上传头像失败");
                    //toastr.success('上传头像失败');
                });
            }
        });

        var selected='';
        for (var i=0; i < cityArray.length; i++){
            if(cityArray[i][0] == "{{ $dataTypeContent->province }}") selected = "selected";
            $('select[name=province]').append('<option value="'+cityArray[i][0]+'" '+selected+'>'+cityArray[i][0]+'</option>');
            selected='';
        } 
        selectCity();


        $('#edit_team_id_a').val($(this).data('team_id_a')).trigger("change");
        
        $('select[name=province]').on('change',function () {
            selectCity();
        })

        function selectCity() {
            $('select[name=city]').empty();
            var province = $('select[name=province]').val();
            if (province != ''){
                for (var i=0; i < cityArray.length; i++){
                    if (province == cityArray[i][0]){
                        var cityArr = cityArray[i][1].split('|');
                        var selected='';
                        for (var j=0; j < cityArr.length; j++){
                            if(cityArr[j] == "{{ $dataTypeContent->city }}") selected = "selected";
                            $('select[name=city]').append('<option value="'+cityArr[j]+'">'+cityArr[j]+'</option>');

                            $('select[name=province]').append('<option value="'+cityArray[i][0]+'" '+selected+'>'+cityArray[i][0]+'</option>');
                            selected='';
                        }
                        break;
                    }    
                }
            }else{
                $('select[name=city]').append('<option value="none">请选择省份</option>');
            }

        }
        
            
    </script>
@endsection