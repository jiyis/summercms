@extends('admin.layouts.login')

@section('content')
    <div class="login-logo">
        <a href="/"><b>BENQ</b>CMS</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">请用邮箱或用户名登录</p>

        <form action="{{ url('/admin/login') }}" method="POST">
            {{ csrf_field() }}
            @if($errors->first())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>{{ $errors->first() }}!</strong>
                </div>
            @endif
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="用户名" value="{{ old('username') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" value="{{ old('remember') }}"> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">

                    <button type="submit" class="btn btn-success btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="#">忘记密码?</a><br>

    </div>
    <!-- /.login-box-body -->
@endsection