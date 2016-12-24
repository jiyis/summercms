@extends('admin.layouts.voyager')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="page-title">
                <i class="fa fa-list"></i> {{ $dataType->display_name_plural }}
                <a href="{{ route('admin.'.$dataType->slug.'.create') }}" class="btn btn-success">
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
                                            <a href="{{ route('admin.menus.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
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
                        <form action="{{ route('admin.menus.index') }}" id="delete_form" method="POST">
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

        $('td').on('click', '.delete', function (e) {
            id = $(e.target).data('id');

            $('#delete_form')[0].action += '/' + id;

            $('#delete_modal').modal('show');
        });
    </script>
@stop
