@extends('admin.layouts.layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {!! Breadcrumbs::render('admin-role-create') !!}
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        @include('admin._partials.rbac-left-menu')

        <div class="col-sm-9 col-lg-10">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <!--<div class="panel-btns">
                        <a href="" class="panel-close">×</a>
                        <a href="" class="minimize">−</a>
                    </div>-->
                    <h4 class="panel-title">添加角色</h4>
                </div>

                {!! Form::open(['route' => 'admin.role.store','class' => 'form-horizontal form-bordered']) !!}

                    @include('admin.rbac.roles.fields')

                {!! Form::close() !!}
            </div>

        </div><!-- col-sm-9 -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection
