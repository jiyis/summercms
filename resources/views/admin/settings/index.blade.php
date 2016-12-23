@extends('admin.layouts.voyager')

@section('css')
    @parent
    <link href="{{ asset('assets/package/voyager/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <style>
        .panel-actions .voyager-trash {
            cursor: pointer;
        }

        .panel-actions .voyager-trash:hover {
            color: #e94542;
        }

        .panel hr {
            margin-bottom: 10px;
        }

        .sort-icons {
            font-size: 21px;
            color: #ccc;
            position: relative;
            cursor: pointer;
        }

        .sort-icons:hover {
            color: #37474F;
        }

        .voyager-sort-desc {
            margin-right: 10px;
        }

        .voyager-sort-asc {
            top: 10px;
        }

        .page-title {
            margin-bottom: 0;
        }

        .panel-title code {
            border-radius: 30px;
            padding: 5px 10px;
            font-size: 11px;
            border: 0;
            position: relative;
            top: -2px;
        }

        .new-setting {
            text-align: center;
            width: 100%;
            margin-top: 20px;
        }

        .new-setting .panel-title {
            margin: 0 auto;
            display: inline-block;
            color: #999fac;
            font-weight: lighter;
            font-size: 14px;
            background: #fff;
            width: auto;
            height: auto;
            position: relative;
            padding-right: 15px;
            margin-top: -15px;
        }

        .new-setting hr {
            margin-bottom: 0;
            position: absolute;
            top: 8px;
            width: 96%;
            margin-left: 2%;
        }

        .new-setting .panel-title i {
            position: relative;
            top: 2px;
        }

        .new-settings-options {
            display: none;
            padding-bottom: 10px;
        }

        .new-settings-options label {
            margin-top: 13px;
        }

        .new-settings-options .alert {
            margin-bottom: 0;
        }

        #toggle_options {
            clear: both;
            float: right;
            font-size: 12px;
            position: relative;
            margin-top: 15px;
            margin-right: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            z-index: 9;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .new-setting-btn {
            margin-right: 15px;
        }

        .new-setting-btn i {
            position: relative;
            top: 2px;
        }

        .img_settings_container {
            width: 200px;
            height: auto;
            position: relative;
        }

        .img_settings_container > a {
            position: absolute;
            right: -10px;
            top: -10px;
            display: block;
            padding: 5px;
            background: #F94F3B;
            color: #fff;
            border-radius: 13px;
            width: 25px;
            height: 25px;
            font-size: 15px;
            line-height: 19px;
        }

        .img_settings_container > a:hover, .img_settings_container > a:focus, .img_settings_container > a:active {
            text-decoration: none;
        }
        
        textarea {
            min-height: 120px;
            margin-bottom: 10px;
        }
        .panel-actions{
            padding-top: 8px;
        }
    </style>
@endsection

@section('content')
 <div class="content-wrapper">  
    <section class="content-header">
        <h1 class="page-title">网站设置</h1>
    </section>
    <section class="index-content">
        <div class="callout callout-info">
            <h4><i class="fa fa-info"></i> 如何使用:</h4>
            <p>你可以通过以下方式在任何地方获取设置项的值： <code>Voyager::setting('key')</code></p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="panel">
                        @foreach($settings as $setting)
                            <div class="panel-heading">
                                <h3 class="panel-title col-sm-6">
                                    {{ $setting->display_name }}<code>Voyager::setting('{{ $setting->key }}')</code>
                                </h3>
                                <div class="panel-actions col-sm-1 col-sm-offset-5">
                                    <a href="{{ route('admin.settings.move_up', $setting->id) }}">
                                        <i class="sort-icons voyager-sort-asc"></i>
                                    </a>
                                    <a href="{{ route('admin.settings.move_down', $setting->id) }}">
                                        <i class="sort-icons voyager-sort-desc"></i>
                                    </a>
                                    <i class="voyager-trash"
                                       data-id="{{ $setting->id }}"
                                       data-display-key="{{ $setting->key }}"
                                       data-display-name="{{ $setting->display_name }}"></i>
                                </div>
                            </div>
                            <div class="panel-body">
                                @if ($setting->type == "text")
                                    <input type="text" class="form-control" name="{{ $setting->key }}" value="{{ $setting->value }}">
                                @elseif($setting->type == "text_area")
                                    <textarea class="form-control" name="{{ $setting->key }}">
                                        @if(isset($setting->value)){{ $setting->value }}@endif
                                    </textarea>
                                @elseif($setting->type == "rich_text_box")
                                    <textarea class="form-control richTextBox" name="{{ $setting->key }}">
                                        @if(isset($setting->value)){{ $setting->value }}@endif
                                    </textarea>
                                @elseif($setting->type == "image" || $setting->type == "file")
                                    @if(isset( $setting->value ) && !empty( $setting->value ) && Storage::exists(config('voyager.storage.subfolder') . $setting->value))
                                        <div class="img_settings_container">
                                            <a href="{{ route('voyager.settings.delete_value', $setting->id) }}" class="voyager-x"></a>
                                            <img src="{{ Storage::url(config('voyager.storage.subfolder') . $setting->value) }}" style="width:200px; height:auto; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                        </div>
                                    @elseif($setting->type == "file" && isset( $setting->value ))
                                        <div class="fileType">{{ $setting->value }}</div>
                                    @endif
                                    <input type="file" name="{{ $setting->key }}">
                                @elseif($setting->type == "select_dropdown")
                                    <?php $options = json_decode($setting->details); ?>
                                    <?php $selected_value = (isset($setting->value) && !empty($setting->value)) ? $setting->value : NULL; ?>
                                    <select class="form-control" name="{{ $setting->key }}">
                                        <?php $default = (isset($options->default)) ? $options->default : NULL; ?>
                                        @if(isset($options->options))
                                            @foreach($options->options as $index => $option)
                                                <option value="{{ $index }}" @if($default == $index && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $index){{ 'selected="selected"' }}@endif>{{ $option }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                @elseif($setting->type == "radio_btn")
                                    <?php $options = json_decode($setting->details); ?>
                                    <?php $selected_value = (isset($setting->value) && !empty($setting->value)) ? $setting->value : NULL; ?>
                                    <?php $default = (isset($options->default)) ? $options->default : NULL; ?>
                                    <ul class="radio">
                                        @if(isset($options->options))
                                            @foreach($options->options as $index => $option)
                                                <li>
                                                    <input type="radio" id="option-{{ $index }}" name="{{ $setting->key }}"
                                                           value="{{ $index }}" @if($default == $index && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $index){{ 'checked' }}@endif>
                                                    <label for="option-{{ $index }}">{{ $option }}</label>
                                                    <div class="check"></div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                @elseif($setting->type == "checkbox")
                                    <?php $options = json_decode($setting->details); ?>
                                    <?php $checked = (isset($setting->value) && $setting->value == 1) ? true : false; ?>
                                    @if (isset($options->on) && isset($options->off))
                                        <input type="checkbox" name="{{ $setting->key }}" class="toggleswitch" @if($checked) checked @endif data-on="{{ $options->on }}" data-off="{{ $options->off }}">
                                    @else
                                        <input type="checkbox" name="{{ $setting->key }}" @if($checked) checked @endif class="toggleswitch">
                                    @endif
                                @endif

                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">保存设置</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="panel-heading new-setting">
                        <hr>
                        <h3 class="panel-title"><i class="voyager-plus"></i> 新增设置项</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('admin.settings.create') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="col-md-4">
                                <label for="display_name">显示名称</label>
                                <input type="text" class="form-control" name="display_name">
                            </div>
                            <div class="col-md-4">
                                <label for="key">设置项</label>
                                <input type="text" class="form-control" name="key">
                            </div>
                            <div class="col-md-4">
                                <label for="asdf">类型</label>
                                <select name="type" class="form-control">
                                    <option value="text">文本框</option>
                                    <option value="text_area">多行文本框</option>
                                    <option value="rich_text_box">富文本编辑器</option>
                                    <option value="checkbox">复选框</option>
                                    <option value="radio_btn">单选框</option>
                                    <option value="select_dropdown">下拉框</option>
                                    <option value="file">文件</option>
                                    <option value="image">图片</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <a id="toggle_options"><i class="voyager-double-down"></i> 自定义选项</a>
                                <div class="new-settings-options">
                                    <label for="options">自定义选项
                                        <small>(可选，只应用于类似于下拉框，复选框的类型)
                                        </small>
                                    </label>
                                    <textarea name="details" id="options_textarea" class="form-control"></textarea>
                                    <div id="valid_options" class="callout callout-success" style="display:none">Valid Json</div>
                                    <div id="invalid_options" class="callout callout-danger" style="display:none">Invalid Json</div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right new-setting-btn">
                                <i class="voyager-plus"></i> 新增设置项
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> 

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> 是否确定删除“ <span id="delete_setting_title"></span>” 配置项?
                    </h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.settings') }}" id="delete_form" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="确 定">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    @parent
    <iframe id="form_target" name="form_target" style="display:none"></iframe>
    <form id="my_form" action="{{ route('admin.upload') }}" target="form_target" method="POST" enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
        {{ csrf_field() }}
        <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
        <input type="hidden" name="type_slug" id="type_slug" value="settings">
    </form>

    <script src="{{ asset('assets/package/voyager/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/package/voyager/voyager_tinymce.js') }}"></script>
    <script src="{{ asset('assets/package/voyager/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/package/voyager/jsonarea.min.js') }}"></script>
    <script>
        $('document').ready(function () {
            $('.voyager-trash').click(function () {
                var action = '{{ route('admin.settings') }}/' + $(this).data('id'),
                    display = $(this).data('display-name') + '/' + $(this).data('display-key');

                $('#delete_setting_title').text(display);
                $('#delete_form')[0].action = action;
                $('#delete_modal').modal('show');
            });

            $('.toggleswitch').bootstrapToggle();

            // do the deal
            var myJSONArea = JSONArea(document.getElementById('options_textarea'), {
                sourceObjects: [] // optional array of objects for JSONArea to inherit from
            });

            valid_json = false;

            // then here's how you use JSONArea's update event
            myJSONArea.getElement().addEventListener('update', function (e) {
                if (e.target.value != "") {
                    valid_json = e.detail.isJSON;
                }
            });

            myJSONArea.getElement().addEventListener('focusout', function (e) {
                if (valid_json) {
                    $('#valid_options').show();
                    $('#invalid_options').hide();
                    var ugly = e.target.value;
                    var obj = JSON.parse(ugly);
                    var pretty = JSON.stringify(obj, undefined, 4);
                    document.getElementById('options_textarea').value = pretty;
                } else {
                    $('#valid_options').hide();
                    $('#invalid_options').show();
                }
            });

            $('#toggle_options').click(function () {
                $('.new-settings-options').toggle();
                if ($('#toggle_options .voyager-double-down').length) {
                    $('#toggle_options .voyager-double-down').removeClass('voyager-double-down').addClass('voyager-double-up');
                } else {
                    $('#toggle_options .voyager-double-up').removeClass('voyager-double-up').addClass('voyager-double-down');
                }
            });
        });


    </script>
@endsection