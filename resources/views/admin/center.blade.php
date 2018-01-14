@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        {!! Breadcrumbs::render('admin-home-center') !!}
    </section>
    <!-- Main content -->
    <section class="index-content">
        <div class="row">
            <div class="col-sm-9 col-lg-10">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <!--<div class="panel-btns">
                            <a href="" class="panel-close">×</a>
                            <a href="" class="minimize">−</a>
                        </div>-->
                        <h4 class="panel-title">编辑用户</h4>
                    </div>

                    {!! Form::model($user, ['route' => ['admin.center.update', $user],'class' => 'form-horizontal form-bordered', 'method' => 'patch', 'files' => true ]) !!}

                    <div class="panel-body panel-body-nopadding">

                        <div class="form-group">
                            {!! Form::label('name', '用户名 *',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('name', old('name'), ['class' => 'form-control tooltips','data-toggle' => 'tooltip','data-trigger' => 'hover','readonly' => 'readonly','data-original-title' => '不可重复']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('nickname', '昵称 *',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('nickname', old('nickname'), ['class' => 'form-control tooltips','data-toggle' => 'tooltip','data-trigger' => 'hover']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', '邮箱 *',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('email', old('email'), ['class' => 'form-control tooltips','data-toggle' => 'tooltip','data-trigger' => 'hover']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', '密码 *',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('password', ['class' => 'form-control tooltips','data-toggle' => 'tooltip','data-trigger' => 'hover']) !!}
                            </div>
                        </div>

                        {{ csrf_field() }}
                    </div><!-- panel-body -->

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button class="btn bg-blue">保存</button>
                                &nbsp;
                                <a href="{{ route('admin.center') }}" class="btn btn-default">取消</a>
                            </div>
                        </div>
                    </div><!-- panel-footer -->


                    {!! Form::close() !!}

                </div>

            </div><!-- col-sm-9 -->
        </div>
    </section>
@endsection
