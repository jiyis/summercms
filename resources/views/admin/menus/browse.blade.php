@extends('admin.layouts.voyager')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="page-title">
                <i class="fa fa-list"></i> {{ $dataType->display_name_plural }}
                <a href="javascript:;" class="btn btn-success" data-toggle="modal" data-target="#create_menu_modal">
                    <i class="voyager-plus"></i> 添加菜单
                </a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>控制台</a></li>
                <li><a href="{{ url('admin/menus') }}"><i class="fa fa-dashboard"></i>菜单管理</a></li>
                <li class="active">菜单列表</li>
            </ol>
        </section>
        <div class="container-fluid">
            <div class="alert alert-info">
                <strong>如何使用:</strong>
                <p>你可以在你想要显示menu的地方调用<code>Menu::display('name')</code></p>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                <tr>
                                    @foreach($dataType->browseRows as $rows)
                                    <th>{{ $rows->display_name }}</th>
                                    @endforeach
                                    <th class="actions">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataTypeContent as $data)
                                    <tr>
                                        @foreach($dataType->browseRows as $row)
                                        <td>
                                            @if($row->type == 'image')
                                                <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                            @else
                                                {{ $data->{$row->field} }}
                                            @endif
                                        </td>
                                        @endforeach
                                        <td class="no-sort no-click">
                                            <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}">
                                                <i class="voyager-trash"></i> 删除
                                            </div>
                                            <a href="javascript:;" data-toggle="modal" data-target="#edit_menu_modal" class="btn-sm btn-primary pull-right edit" data-id="{{ $data->id }}" data-name="{{ $data->name }}" data-title="{{ $data->title }}">
                                                <i class="voyager-edit"></i> 编辑
                                            </a>
                                            <a href="{{ route('admin.menu.builder', $data->id) }}" class="btn-sm btn-success pull-right">
                                                <i class="voyager-list"></i> 构建
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--创建菜单-->
        <div class="modal fade" tabindex="-1" id="create_menu_modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-gamepad"></i> 新增菜单</h4>
                    </div>
                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '菜单名称', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '中文标示']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <div class="checkbox icheck">
                                            <label>
                                                {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}
                                                设为默认菜单
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="添 加">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--修改菜单-->
        <div class="modal fade" tabindex="-1" id="edit_menu_modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-gamepad"></i> 修改菜单</h4>
                    </div>
                    <form action="#" method="POST" id="edit_menu_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '菜单名称','id'=>'edit-name']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::text('title', old('title'), ['class' => 'form-control','placeholder' => '中文标示','id'=>'edit-title']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-8">
                                        <div class="checkbox icheck">
                                            <label>
                                                {!! Form::checkbox('default', 1,old('default'),['class' => 'form-control']) !!}
                                                设为默认菜单
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="保  存">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取 消</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                            <i class="voyager-trash"></i> 确定要删除该{{ $dataType->display_name_singular }}吗?
                        </h4>
                    </div>
                    <div class="modal-footer">
                        <form action="#" id="delete_form" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="删除">
                        </form>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    @parent
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $("#dataTable").DataTable({
                columnDefs:[{
                    orderable:false,//禁用排序
                    'aTargets':[0,-1]   //指定的列
                }],
                autoWidth: true,
                //"bPaginate": false,
                language: {
                    url: '/assets/language/datatables-zh.json'
                },
            });
        });

        $('.delete').on('click', function (e) {
            var id = $(this).data('id');

            $('#delete_form')[0].action = "/admin/menus/"+id;

            $('#delete_modal').modal('show');
        });

        //菜单赋值
        $('.edit').click(function (e) {
            var id = $(this).data('id');
            $('#edit-name').val($(this).data('name'));
            $('#edit-title').val($(this).data('title'));
            //if($(this).data('default')) $('#group_default').iCheck("check");//();

            $("#edit_menu_form").attr("action", "/admin/menus/update/"+id);
            //$('#edit_menu_modal').modal();
        });
    </script>
@stop
