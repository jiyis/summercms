@extends('admin.layouts.voyager')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="page-title">
                <i class="fa fa-database"></i> 数据库
                <a href="{{ route('admin.database.create_table') }}" class="btn btn-success"><i
                            class="voyager-plus"></i>
                    新建数据表</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="http://cms.jiyi.com/admin/home"><i class="fa fa-dashboard"></i>控制台</a></li>
                <li><a href="http://cms.jiyi.com/admin/database"><i class="fa fa-dashboard"></i>数据库管理</a></li>
                <li class="active">数据表列表</li>
            </ol>
        </section>
        <section class="index-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-body">

                            <?php $dataTypes = App\Models\DataType::all(); ?>
                            <?php $dataTypeNames = []; ?>
                            @foreach($dataTypes as $type)
                                <?php array_push($dataTypeNames, $type->name); ?>
                            @endforeach

                            <table class="table table-striped database-tables">
                                <thead>
                                <tr>
                                    <th>数据表名称</th>
                                    <th>模型管理</th>
                                    <th style="text-align:right">数据表管理</th>
                                </tr>
                                </thead>

                                <?php $arr = App\Services\DBSchema::tables(); ?>
                                @foreach($arr as $a)
                                    <?php $table = str_replace(env('DB_PREFIX'),'',current($a)); ?>
                                    <?php  $active = in_array($table, $dataTypeNames);
                                    if ($active) {
                                        $activeDataType = App\Models\DataType::where('name', '=', $table)->first();
                                    }
                                    ?>

                                    <tr>
                                        <td>
                                            <p class="name">
                                                @if($active)
                                                    <a href="{{ route('admin.database.browse_table', $table) }}"
                                                       data-name="{{ $table }}" class="desctable">{{ $table }}</a> <i
                                                            class="voyager-bread"
                                                            style="font-size:25px; position:absolute; margin-left:10px; margin-top:-3px;"></i>
                                                @else
                                                    <a href="{{ route('admin.database.browse_table', $table) }}"
                                                       data-name="{{ $table }}" class="desctable">{{ $table }}</a>
                                                @endif
                                            </p>
                                        </td>

                                        <td>

                                            <div class="bread_actions">
                                                @if($active)
                                                    <a class="btn btn-sm btn-default edit"
                                                       href="{{ route('admin.database.edit_bread', $activeDataType->id) }}">
                                                       编辑模型</a>
                                                    <div class="btn-sm btn-danger delete" style="display:inline"
                                                         data-id="{{ $activeDataType->id }}" data-name="{{ $table }}"> 删除模型
                                                    </div>
                                                @else
                                                    <form action="{{ route('admin.database.create_bread') }}" method="POST">
                                                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                                        <input type="hidden" value="{{ $table }}" name="table">
                                                        <button type="submit" class="btn btn-sm btn-primary"><i
                                                                    class="voyager-plus"></i> 新建模型
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                        </td>
                                        <td class="actions">
                                            <a class="btn-danger btn-sm pull-right delete_table @if($active) remove-bread-warning @endif"
                                               data-table="{{ $table }}" style="display:inline; cursor:pointer;"><i
                                                        class="voyager-trash"></i> 删除</a>
                                            <a class="btn-sm btn-primary pull-right" style="display:inline; margin-right:10px;"
                                               href="{{ route('admin.database.edit_table', $table) }}"><i
                                                        class="voyager-edit"></i> 编辑</a>
                                            <a class="btn-sm btn-warning pull-right desctable"
                                               style="display:inline; margin-right:10px;"
                                               href="{{ route('admin.database.browse_table', $table) }}"
                                               data-name="{{ $table }}"><i
                                                        class="voyager-eye"></i> 查看</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal  fade" tabindex="-1" id="delete_builder_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> 确定要删除表 <span id="delete_builder_name"></span> 的模型吗?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.database') }}/delete_bread" id="delete_builder_form" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger" value="删除">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal  fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> 确认要删除 <span
                                id="delete_table_name"></span> 数据表吗?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.database') }}/table/delete" id="delete_table_form" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger pull-right" value="删除">
                        <button type="button" class="btn btn-default pull-right" style="margin-right:10px;"
                                data-dismiss="modal">取消
                        </button>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal  fade" tabindex="-1" id="table_info" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-data"></i> @{{ table.name }}</h4>
                </div>
                <div class="modal-body" style="overflow:scroll">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>字段</th>
                            <th>类型</th>
                            <th>是否为空</th>
                            <th>主键</th>
                            <th>默认</th>
                            <th>其他</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in table.rows">
                            <td><strong>@{{ row.Field }}</strong></td>
                            <td>@{{ row.Type }}</td>
                            <td>@{{ row.Null }}</td>
                            <td>@{{ row.Key }}</td>
                            <td>@{{ row.Default }}</td>
                            <td>@{{ row.Extra }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop

@section('javascript')
    @parent
    <script>


        var table = {
            name: '',
            rows: []
        };

        new Vue({
            el: '#table_info',
            data: {
                table: table,
            },
        });


        $(function () {

            $('.bread_actions').on('click', '.delete', function (e) {
                id = $(e.target).data('id');
                name = $(e.target).data('name');

                $('#delete_builder_name').text(name);
                $('#delete_builder_form')[0].action += '/' + id;
                $('#delete_builder_modal').modal('show');
            });


            $('.database-tables').on('click', '.desctable', function (e) {
                e.preventDefault();
                href = $(this).attr('href');
                table.name = $(this).data('name');
                table.rows = [];
                $.get(href, function (data) {
                    $.each(data, function (key, val) {
                        table.rows.push({
                            Field: val.field,
                            Type: val.type,
                            Null: val.null,
                            Key: val.key,
                            Default: val.default,
                            Extra: val.extra
                        });
                        $('#table_info').modal('show');
                    });
                });
            });

            $('td.actions').on('click', '.delete_table', function (e) {
                table = $(e.target).data('table');
                if ($(e.target).hasClass('remove-bread-warning')) {
                    toastr.warning("Please make sure to remove the BREAD on this table before deleting the table.");
                } else {
                    $('#delete_table_name').text(table);
                    $('#delete_table_form')[0].action += '/' + table;
                    $('#delete_modal').modal('show');
                }
            });


        });
    </script>

@stop