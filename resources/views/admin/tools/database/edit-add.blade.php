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
                <i class="voyager-data"></i> @if(isset($table)){{ '编辑 ' . $table . ' 数据表' }}@else{{ '新建数据表' }}@endif
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>控制台</a></li>
                <li><a href="{{ route('admin.database') }}"><i class="fa fa-dashboard"></i>数据库管理</a></li>
                <li class="active">@if(isset($table)){{ '编辑数据表' }}@else{{ '新建数据表' }}@endif</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- table row template -->
                    <table class="table table-bordered" style="width:100%; display:none;">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Field Name</th>
                            <th>DB Type</th>
                            <th>Allow Null?</th>
                            <th>Key</th>
                            <th>Default Value</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="tablerow" style="display:none;">
                            <td class="drag">
                                <i class="voyager-handle"></i>
                                <input type="hidden" name="row[]">
                            </td>
                            <td>
                                <input type="text" class="form-control fieldName" name="field[]">
                                @if(isset($table))
                                    <input type="hidden" class="form-control originalfieldName" name="original_field[]">
                                    <input type="hidden" class="form-control deleteField" name="delete_field[]"
                                           value="0">
                                @endif
                            </td>
                            <td>
                                <select name="type[]" class="form-control fieldType" tabindex="-1">
                                    <optgroup label="Type">
                                        <option value="tinyInteger">TINY INTEGER</option>
                                        <option value="smallInteger">SMALL INTEGER</option>
                                        <option value="mediumInteger">MEDIUM INTEGER</option>
                                        <option value="integer">INTEGER</option>
                                        <option value="bigInteger">BIG INTEGER</option>
                                        <option value="string" selected="selected">STRING</option>
                                        <option value="text">TEXT</option>
                                        <option value="mediumText">MEDIUM TEXT</option>
                                        <option value="longText">LONG TEXT</option>
                                        <option value="float">FLOAT</option>
                                        <option value="double">DOUBLE</option>
                                        <option value="decimal">DECIMAL</option>
                                        <option value="boolean">BOOLEAN</option>
                                        <option value="enum">ENUM</option>
                                        <option value="date">DATE</option>
                                        <option value="dateTime">DATETIME</option>
                                        <option value="time">TIME</option>
                                        <option value="timestamp">TIMESTAMP</option>
                                        <option value="binary">BINARY</option>
                                    </optgroup>
                                </select>
                                <div class="enum_val">
                                    <small>Enum Values (comma separated)</small>
                                    <input type="text" class="form-control enum" name="enum[]">
                                </div>
                            </td>
                            <td>
                                <input type="checkbox" class="toggleswitch fieldNull" name="nullable_switch[]">
                                <input class="toggleswitchHidden" type="hidden" value="0" name='nullable[]'>
                            </td>
                            <td>
                                <select name="key[]" class="form-control fieldKey" tabindex="-1">
                                    <optgroup label="Type">
                                        <option value=""></option>
                                        <option value="MUL">Index</option>
                                        <option value="PRI">Primary</option>
                                        <option value="UNI">Unique</option>
                                    </optgroup>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control fieldDefault" name="default[]">
                            </td>
                            <td>
                                <div class="btn btn-danger delete-row"><i class="fa fa-trash"></i></div>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                    <!-- END Table Row Template -->

                    <div class="page-content">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="@if(isset($table)){{ route('admin.database.edit_table', $table) }}@else{{ route('admin.database.create_table') }}@endif"
                                      method="POST">
                                    <div class="box box-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">@if(isset($table)){{ '编辑 ' . $table . ' 数据表' }}@else{{ '新建数据表' }}@endif</h3>
                                        </div>
                                        <div class="panel-body">

                                            <div class="row">
                                                @if(!isset($table))
                                                    <div class="col-md-6">
                                                        @else
                                                            <div class="col-md-12">
                                                                @endif
                                                                <label for="name">数据表名称</label><br>
                                                                <input required type="text" name="name"
                                                                       class="form-control"
                                                                       placeholder="数据表名称"
                                                                       value="@if(isset($table)){{ $table }}@endif">
                                                                @if(isset($table))
                                                                    <input required type="hidden" name="original_name"
                                                                           class="form-control"
                                                                           value="{{ $table }}">
                                                                @endif
                                                            </div>

                                                            @if(!isset($table))
                                                                <div class="col-md-6">
                                                                    <label for="create_model">是否创建模型?</label><br>
                                                                    <input type="checkbox" name="create_model"
                                                                           data-toggle="toggle"
                                                                           data-on="创建" data-off="不创建">

                                                                </div>
                                                            @endif
                                                    </div>
                                                    <p>数据表字段</p>

                                                    <table class="table table-bordered" style="width:100%;">
                                                        <thead>
                                                        <tr>
                                                            <th style="text-align:center">排序</th>
                                                            <th>字段名称</th>
                                                            <th>字段类型</th>
                                                            <th>能否为空？</th>
                                                            <th>主键</th>
                                                            <th>默认</th>
                                                            <th>删除</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tablebody">

                                                        </tbody>
                                                    </table>

                                                    <div style="text-align:center">
                                                        <div class="btn btn-info" id="newField">+ 增加字段</div>
                                                        <div class="btn btn-success" id="newFieldPrimary">+ 增加主键字段
                                                        </div>

                                                        <div class="btn btn-warning" id="newFieldTimestamps">+增加时间戳字段
                                                        </div>

                                                    </div>
                                            </div>
                                            <div class="panel-footer">
                                                <div class="col-sm-2 col-sm-offset-10">
                                                <a href="{{ route('admin.database') }}" class="btn btn-default">取消</a>

                                                <input type="submit" class="btn btn-primary pull-right"
                                                       value="@if(isset($table)){{ '更新数据表' }}@else{{ '新建数据表' }}@endif">
                                                </div>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div style="clear:both"></div>
                                            </div>
                                        </div><!-- .panel -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




@endsection

@section('javascript')
    @parent
    <script src="{{ asset('assets/package/voyager/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/package/voyager/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/package/voyager/jquery.nestable.js') }}"></script>
    <script>
        $(function () {

            @if(!isset($table))
              newRow('primary');
              newRow('hidden_category_id');
            newRow();
            @else

              @foreach($rows as $row)
                newRow('', '{{ $row->field }}', '{{ $row->type }}', '{{ $row->null }}', '{{ $row->key }}', '{{ $row->default }}');
            @endforeach

          @endif

          $('#newField').click(function () {
                newRow();
            });

            $('#newFieldTimestamps').click(function () {
                newRow('timestamps');
            });

            $('#newFieldPrimary').click(function () {
                newRow('primary');
            });
            $("#tablebody").sortable({
                handle: '.voyager-handle'
            });


            $('#tablebody').on('click', '.delete-row', function () {
                var clickedRow = $(this).parents('.newTableRow');
                if (clickedRow.hasClass('existing_row')) {
                    $(this).parents('.newTableRow').hide();
                    $(this).parents('.newTableRow').find('.deleteField').val(1);
                } else {
                    $(this).parents('.newTableRow').remove();
                }
            });

            $('#tablebody').on('change', '.fieldType', function (e) {
                if ($(this).val() == 'text' || $(this).val() == 'mediumText' || $(this).val() == 'longText') {
                    $(this).parents('.newTableRow').find('.fieldDefault').val('');
                    $(this).parents('.newTableRow').find('.fieldDefault').attr('readonly', 'readonly');
                } else {
                    $(this).parents('.newTableRow').find('.fieldDefault').removeAttr('readonly');
                }

                if ($(this).val() == 'enum') {
                    $(this).parents('.newTableRow').find('.enum_val').show();
                } else {
                    $(this).parents('.newTableRow').find('.enum_val').hide();
                }
            });

            $('.toggleswitch').change(function () {
                if ($(this).prop('checked')) {
                    $(this).parents('.newTableRow').find('.toggleswitchHidden').val(1);
                } else {
                    $(this).parents('.newTableRow').find('.toggleswitchHidden').val(0);
                }
            });

        });

        function newRow(kind, name, type, nullable, key, defaultValue) {

            unique_id = ("0000" + (Math.random() * Math.pow(36, 4) << 0).toString(36)).slice(-4);
            if (kind == 'primary') {
                $('#tablebody').prepend('<tr id="' + unique_id + '" class="newTableRow">' + $('.tablerow').html() + '</tr>');
            } else {
                $('#tablebody').append('<tr id="' + unique_id + '" class="newTableRow">' + $('.tablerow').html() + '</tr>');
            }

            $('.toggleswitch').not('.tablerow .toggleswitch').bootstrapToggle({
                on: 'Yes',
                off: 'No'
            });

            if (kind == 'primary') {
                $('#' + unique_id).find('.fieldName').val('id');
                $('#' + unique_id).find('.fieldType').val('integer');
                $('#' + unique_id).find('.fieldKey').val('PRI');
            } else if (kind == 'timestamps') {
                $('#' + unique_id).find('.fieldName').val('created_at & updated_at');
                $('#' + unique_id).find('.fieldName').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldDefault').val('CURRENT_TIMESTAMP').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldType').val('timestamp').attr('readonly', 'readonly');
                $('#' + unique_id).find('.fieldNull').parent().hide();
                $('#' + unique_id).find('.fieldKey').hide();
            } else if (kind == 'hidden_category_id') {
                $('#' + unique_id).find('.fieldName').val('category_id');
                $('#' + unique_id).find('.fieldType').val('integer');
                $('#' + unique_id).find('.fieldKey').val('MUL');
            } else {
                if (typeof(name) != 'undefined') {
                    $('#' + unique_id).addClass('existing_row');
                    $('#' + unique_id).find('.fieldName').val(name);
                    $('#' + unique_id).find('.originalfieldName').val(name);
                    type = getCorrectType(type);
                    $('#' + unique_id).find('.fieldType').val(type);
                    $('#' + unique_id).find('.fieldKey').val(key);
                    if (nullable == "YES") {
                        $('#' + unique_id).find('.toggleswitch').prop('checked', true).change();
                        $('#' + unique_id).find('.toggleswitchHidden').val(1);
                    }
                    $('#' + unique_id).find('.fieldDefault').val(defaultValue);
                }
            }


        }

        function getCorrectType(type) {
            if (type.substring(0, 3) == 'int') {
                return 'integer';
            }
            if (type.substring(0, 7) == 'varchar') {
                return 'string';
            }
            if (type == 'tinyint(1)') {
                return 'boolean';
            }
            if (type.substring(0, 7) == 'tinyint') {
                return 'tinyInteger';
            }
            if (type.substring(0, 8) == 'smallint') {
                return 'smallInteger';
            }
            if (type.substring(0, 9) == 'mediumint') {
                return 'mediumInteger';
            }
            if (type.substring(0, 6) == 'bigint') {
                return 'bigInteger';
            }
            if (type == 'mediumtext') {
                return 'mediumText';
            }
            if (type == 'longtext') {
                return 'longText';
            }
            if (type == 'double(8,2)') {
                return 'float'
            }
            if (type.substring(0, 7) == 'decimal') {
                return 'decimal';
            }
            if (type == 'datetime') {
                return 'dateTime'
            }
            if (type == 'blob') {
                return 'binary'
            }

            return type;
        }

    </script>

@stop
