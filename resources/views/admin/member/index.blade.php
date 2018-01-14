@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        {!! Breadcrumbs::render('admin-member-index') !!}
    </section>

    <!-- Main content -->
    <section class="index-content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-bar-chart-o"></i>
                        <h3 class="box-title">客户列表</h3>
                        <a href="{{ route('admin.member.create') }}" class="btn btn-primary header-btn">新增客户</a>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped datatable">
                            <thead>
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="square" id="selectall">
                                    </label>
                                </th>
                                <th>用户名</th>
                                <th>昵称</th>
                                <th>产品类别</th>
                                <th>邮箱</th>
                                <th>所属审核人</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" class="square selectall-item" name="id" id="id-{{ $member->id }}" value="{{ $member->id }}" />
                                        </label>
                                    </td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->nickname }}</td>
                                    <td>{{ config('custom.category')[$member->category] }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $users[$member->belong_to] }}</td>
                                    <td>{{ $member->created_at }}</td>
                                    <td>
                                        <a href="{{ route('admin.member.edit',['id'=>$member->id]) }}" class="btn btn-white btn-xs"><i class="fa fa-pencil"></i> 编辑</a>

                                        <a class="btn btn-danger btn-xs user-delete" data-href="{{ route('admin.member.destroy',['id'=>$member->id]) }}"><i class="fa fa-trash-o"></i> 删除</a>
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
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $('input[class!="my-switch"]').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
        $(".user-delete").click(function () {
            Rbac.ajax.delete({
                confirmTitle: '确定删除客户?',
                href: $(this).data('href'),
                successTitle: '客户删除成功'
            });
        });
    </script>
@endsection
