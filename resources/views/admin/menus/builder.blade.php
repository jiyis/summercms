@extends('admin.layouts.voyager')

@section('css')
    @parent
    <link href="{{ asset('assets/package/voyager/nestable.css') }}" rel="stylesheet">
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="page-title">
                <i class="fa fa-list"></i>菜单构建器 ({{ $menu->name }})
                <div class="btn btn-success add_item"><i class="voyager-plus"></i> 新建菜单</div>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i>控制台</a></li>
                <li><a href="{{ url('admin/menus') }}"><i class="fa fa-dashboard"></i>菜单管理</a></li>
                <li class="active">构建菜单</li>
            </ol>
        </section>
        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-bordered">

                        <div class="panel-heading">
                            <p class="panel-title" style="color:#777">拖放菜单项目以重新排列。</p>
                        </div>

                        <div class="panel-body" style="padding:30px;">

                            <div class="dd">
                                <?= Menu::display($menu->name, 'admin'); ?>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> 确定要删除该菜单吗?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.home') }}/menu/delete_menu_item/" id="delete_form"
                              method="POST">
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
        <div class="modal fade" tabindex="-1" id="add_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-plus"></i> 新建菜单</h4>
                    </div>
                    <form action="{{ route('admin.menu.add_item') }}" id="delete_form" method="POST">
                        <div class="modal-body">
                            <label for="name">菜单名称</label>
                            <input type="text" class="form-control" name="title" placeholder="菜单名称"><br>
                            <label for="url">菜单地址</label>
                            <input type="text" class="form-control" name="url" placeholder="URL"><br>
                            <label for="icon_class">菜单图标 (Use a <a
                                        href="{{ config('voyager.assets_path') . '/fonts/voyager/icons-reference.html' }}"
                                        target="_blank">Voyager Font Class</a>)</label>
                            <input type="text" class="form-control" name="icon_class"
                                   placeholder="菜单图标"><br>
                            <label for="color">菜单颜色</label>
                            <input type="color" class="form-control" name="color"
                                   placeholder="Color (ex. #ffffff or rgb(255, 255, 255)"><br>
                            <label for="target">是否新标签打开</label>
                            <select id="edit_target" class="form-control" name="target">
                                <option value="_self">当前页面打开</option>
                                <option value="_blank">新开标签打开</option>
                            </select>
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success pull-right delete-confirm" value="添加">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" id="edit_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-edit"></i> 编辑菜单</h4>
                    </div>
                    <form action="{{ route('admin.menu.update_menu_item') }}" id="edit_form" method="POST">
                        <div class="modal-body">
                            <label for="name">菜单名称</label>
                            <input type="text" class="form-control" id="edit_title" name="title" placeholder="菜单名称"><br>
                            <label for="url">菜单地址</label>
                            <input type="text" class="form-control" id="edit_url" name="url" placeholder="URL"><br>
                            <label for="icon_class">菜单图标</label>
                            <input type="text" class="form-control" id="edit_icon_class" name="icon_class"
                                   placeholder="菜单图标"><br>
                            <label for="color">菜单颜色</label>
                            <input type="color" class="form-control" id="edit_color" name="color"
                                   placeholder="Color (ex. #ffffff or rgb(255, 255, 255)"><br>
                            <label for="target">是否新标签打开</label>
                            <select id="edit_target" class="form-control" name="target">
                                <option value="_self" selected="selected">当前标签打开</option>
                                <option value="_blank">新开标签打开</option>
                            </select>
                            <input type="hidden" name="id" id="edit_id" value="">
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success pull-right delete-confirm" value="更新">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </div>

@endsection

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ asset('assets/package/voyager/jquery.nestable.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.dd').nestable({/* config options */});
            $('.item_actions').on('click', '.delete', function (e) {
                id = $(e.target).data('id');
                $('#delete_form')[0].action += '/' + id;
                $('#delete_modal').modal('show');
            });

            $('.item_actions').on('click', '.edit', function (e) {
                id = $(e.target).data('id');
                $('#edit_title').val($(e.target).data('title'));
                $('#edit_url').val($(e.target).data('url'));
                $('#edit_icon_class').val($(e.target).data('icon_class'));
                $('#edit_color').val($(e.target).data('color'));
                $('#edit_id').val(id);

                if ($(e.target).data('target') == '_self') {
                    $("#edit_target").val('_self').change();
                } else if ($(e.target).data('target') == '_blank') {
                    $("#edit_target option[value='_self']").removeAttr('selected');
                    $("#edit_target option[value='_blank']").attr('selected', 'selected');
                    $("#edit_target").val('_blank');
                }
                $('#edit_modal').modal('show');
            });

            $('.add_item').click(function () {
                $('#add_modal').modal('show');
            });

            $('.dd').on('change', function (e) {
                console.log(JSON.stringify($('.dd').nestable('serialize')));
                $.post('{{ route('admin.menu.order_item') }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    toastr.success("调整菜单顺序成功.");
                });

            });

        });
    </script>
@stop