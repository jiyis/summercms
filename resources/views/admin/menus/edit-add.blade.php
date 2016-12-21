@extends('admin.layouts.voyager')

@section('css')

    @parent
    <link href="{{ asset('assets/package/voyager/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/package/voyager/jquery-ui.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="page-title">
                <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ '编辑' }}@else{{ '新增' }}@endif {{ $dataType->display_name_singular }}
            </h1>
        </section>
        <section class="index-content">
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@if(isset($dataTypeContent->id)){{ '编辑' }}@else{{ '新增' }}@endif {{ $dataType->display_name_singular }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form"
                              action="@if(isset($dataTypeContent->id)){{ route('admin.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('admin.'.$dataType->slug.'.store') }}@endif"
                              method="POST" enctype="multipart/form-data">
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
                                    <div class="form-group">
                                        <label for="name" class="col-sm-1 control-label">{{ $row->display_name }}</label>
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
                                            <input type="password" class="form-control" name="{{ $row->field }}" value="">
                                        @elseif($row->type == "text_area")
                                            <textarea class="form-control"
                                                      name="{{ $row->field }}">@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif</textarea>
                                        @elseif($row->type == "rich_text_box")
                                            <textarea class="form-control richTextBox"
                                                      name="{{ $row->field }}">@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif</textarea>
                                        @elseif($row->type == "image" || $row->type == "file")
                                            @if($row->type == "image" && isset($dataTypeContent->{$row->field}))
                                                <img src="{{ Voyager::image( $dataTypeContent->{$row->field} ) }}"
                                                     style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                            @elseif($row->type == "file" && isset($dataTypeContent->{$row->field}))
                                                <div class="fileType">{{ $dataTypeContent->{$row->field} }} }}</div>
                                            @endif
                                            <input type="file" name="{{ $row->field }}">
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
                                            <ul class="radio">
                                                @if(isset($options->options))
                                                    @foreach($options->options as $key => $option)
                                                        <li>
                                                            <input type="radio" id="option-{{ $key }}"
                                                                   name="{{ $row->field }}"
                                                                   value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $key){{ 'checked' }}@endif>
                                                            <label for="option-{{ $key }}">{{ $option }}</label>
                                                            <div class="check"></div>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>

                                        @elseif($row->type == "checkbox")

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
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </form>

                        <iframe id="form_target" name="form_target" style="display:none"></iframe>
                        <form id="my_form" action="{{ route('admin.upload') }}" target="form_target" method="post"
                              enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                            <input name="image" id="upload_file" type="file"
                                   onchange="$('#my_form').submit();this.value='';">
                            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>

                    </div>
                </div>
            </div>

        </section>
    </div>
@stop

@section('javascript')
    @parent
    <script src="{{ asset('assets/package/voyager/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/package/voyager/jquery-ui.min.js') }}"></script>
    <script>
        $('document').ready(function () {
            $(".select2").select2();
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
    <script src="{{ asset('assets/package/voyager/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/package/voyager/voyager_tinymce.js') }}"></script>
@stop
