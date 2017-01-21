@extends('admin.layouts.voyager')


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="page-title col-md-6">
                <i class="fa fa-{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
                <a href="{{ route('admin.'.$dataType->slug.'.create') }}" class="btn btn-success">
                    <i class="voyager-plus"></i> 新建{{ $dataType->display_name_singular }}
                </a>
                <a href="javascript:void(0)" class="btn btn-warning publish-all" style="margin-left:25px;" data-url="{{$dataType->slug}}" data-model="{{ $dataType->model_name }}">
                    <i class="voyager-eye"></i> 发布所有{{ $dataType->display_name_singular }}
                </a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>控制台</a></li>
                <li><a href="{{ url('admin/'.$dataType->slug) }}"><i class="fa fa-dashboard"></i>{{ $dataType->display_name_plural }}</a></li>
                <li class="active">{{ $dataType->display_name_singular }}列表</li>
            </ol>
        </section>
        <section class="index-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
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
                                            <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}" id="delete-{{ $data->id }}">
                                                <i class="voyager-trash"></i> 删除
                                            </div>
                                            <a href="{{ route('admin.'.$dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                                <i class="voyager-edit"></i> 编辑
                                            </a>

                                            <a href="javascript:void(0)" class="btn-sm btn-warning pull-right publish-btn" data-url="{{$dataType->slug . '/'. $data->id}}" data-model="{{ $dataType->model_name }}" data-id="{{  $data->id }}"><i class="voyager-eye"></i> 发布
                                            </a>
                                            <!--<a href="{{ route('admin.'.$dataType->slug.'.show', $data->id) }}" class="btn-sm btn-warning pull-right">
                                                <i class="voyager-eye"></i> 查看
                                            </a>-->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> 确定要删除该条 {{ $dataType->display_name_singular }}吗?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                   value="删除">
                        </form>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
            var form = $('#delete_form')[0];

            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                ? action.replace(/([0-9]+$)/, id)
                : action + '/' + id;
        }

        $('.publish-btn').click(function () {
            Rbac.ajax.request({
                successTitle: "发布成功!",
                href: "{{ route('admin.publish') }}",
                data: {url: $(this).data('url'),model:$(this).data('model'),id:$(this).data('id')},
                successFnc: function () {
                    return false;
                }
            });
        })
        //发布所有的内容页
        $('.publish-all').click(function () {
            Summer.queue.request({
                type: 'info',
                href: "{{ route('admin.publish.model') }}",
                data: {url: $(this).data('url'), model:$(this).data('model')},
                title: '正在刷新所有的{{ $dataType->display_name_singular }}页面...',
                successTitle: "所有{{ $dataType->display_name_singular }}页面发布成功!",
            });
        })

    </script>
@stop
