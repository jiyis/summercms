@extends('admin.layouts.login')

@section('content')
    <div class="login-logo">
        <a href="/"><b>CLOUD</b>classroom</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <form action="{{ url('/admin/login') }}" method="POST">
            {{ csrf_field() }}
            @if($errors->first())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>{{ $errors->first() }}!</strong>
                </div>
            @endif
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <input type="text" name="username" class="form-control" placeholder="请输入用户名或邮箱" value="{{ old('username') }}">

            </div>
            <div class="form-group has-feedback">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <input type="password" name="password" class="form-control" placeholder="请输入密码">
            </div>
            <div class="form-group has-feedback">
                <button type="submit" class="btn btn-success btn-block btn-flat">登  录</button>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" value="{{ old('remember') }}"> 保持我的登录状态
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <a href="#" style="float:right;line-height:32px;">忘记密码?</a><br>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
@endsection