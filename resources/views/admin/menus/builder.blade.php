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
                <div class="btn btn-success add_item" data-toggle="modal" data-target="#add_modal"><i class="voyager-plus"></i> 新建菜单项</div>
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
                            <p class="panel-title" style="color:#777">可拖放菜单项进行重新排列。</p>
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
                        <h4 class="modal-title"><i class="voyager-trash"></i> 确定要删除该菜单项吗?</h4>
                    </div>
                    <div class="modal-footer">
                        <form action="#" id="delete_form" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="删除">
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
                        <h4 class="modal-title"><i class="voyager-plus"></i> 新建菜单项</h4>
                    </div>
                    <form action="{{ route('admin.menu.add_item') }}" id="delete_form" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">菜单名称</label>
                                <input type="text" class="form-control" name="title" placeholder="菜单名称">  
                            </div>
                            <div class="form-group">
                                <label for="url">
                                    菜单地址 &nbsp;&nbsp;
                                    <input type="radio" name="urltype" value="local" checked="checked">&nbsp;现有地址&nbsp;&nbsp;
                                    <input type="radio" name="urltype" value="diy">&nbsp;自定义地址&nbsp;&nbsp;
                                </label>
                                <div class="localurl">
                                    {!! Form::select('localurl', $routes, old('localurl'), ['class' => 'form-control tooltips nationality select2']) !!}

                                </div>
                                <div class="diyurl" style="display: none;">
                                    <input type="text" name="diyurl" placeholder="自定义链接" class="form-control diyurl" >  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="target">是否新标签打开</label>
                                <select id="edit_target" class="form-control" name="target">
                                    <option value="_self">当前页面打开</option>
                                    <option value="_blank">新开标签打开</option>
                                </select>                               
                            </div>
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
                        <h4 class="modal-title"><i class="voyager-edit"></i> 编辑菜单项</h4>
                    </div>
                    <form action="#" id="edit_form" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">菜单名称</label>
                                <input type="text" class="form-control" id="edit_title" name="title" placeholder="菜单名称">
                            </div>
                            <div class="form-group">
                                <label for="url">
                                    菜单地址 &nbsp;&nbsp;
                                    <input type="radio" name="urltype" value="local" id="local">&nbsp;现有地址&nbsp;&nbsp;
                                    <input type="radio" name="urltype" value="diy" id="diy">&nbsp;自定义地址&nbsp;&nbsp;
                                </label>
                                <div class="localurl" style="display: none;">
                                    {!! Form::select('localurl', $routes, old('localurl'), ['class' => 'form-control tooltips nationality select2', 'id' => 'edit_localurl']) !!}

                                </div>
                                <div class="diyurl">
                                    <input type="text" name="diyurl" placeholder="自定义链接" class="form-control diyurl" id="edit_diyurl">  
                                </div>
                            </div>                
                            <div class="form-group">
                                <label for="target">是否新标签打开</label>
                                <select id="edit_target" class="form-control" name="target">
                                    <option value="_self" selected="selected">当前标签打开</option>
                                    <option value="_blank">新开标签打开</option>
                                </select>                                
                            </div>
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
                var id = $(e.target).data('id');
                $('#delete_form')[0].action = '/admin/menu/delete_menu_item/' + id;
                $('#delete_modal').modal('show'); 
            });

            $('.item_actions').on('click', '.edit', function (e) {
                var id = $(e.target).data('id');
                $('#edit_title').val($(e.target).data('title'));
                if ($(e.target).data('urltype') == 'local'){
                    $('#local').iCheck('check');
                    $('#edit_localurl').val($(e.target).data('url')).trigger("change");;
                    $('.localurl').css('display','block');
                }else{
                    $('#diy').iCheck('check');
                    $('#edit_diyurl').val($(e.target).data('url')).trigger("change");;
                    $('.diyurl').css('display','block');
                }

                $('#edit_id').val(id);

                if ($(e.target).data('target') == '_self') {
                    $("#edit_target").val('_self').change();
                } else if ($(e.target).data('target') == '_blank') {
                    $("#edit_target option[value='_self']").removeAttr('selected');
                    $("#edit_target option[value='_blank']").attr('selected', 'selected');
                    $("#edit_target").val('_blank');
                }
                $('#edit_form')[0].action = '/admin/menu/update_menu_item/' + id;
                $('#edit_modal').modal('show');
            });

            $('input[name=urltype]').on('ifChecked',function () {
                if ($(this).val() == 'local'){
                    $('.diyurl').css('display','none');
                    $('.localurl').css('display','block');
                }else{
                    $('.localurl').css('display','none');
                    $('.diyurl').css('display','block');                    
                }
            })
            $('.dd').on('change', function (e) {
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