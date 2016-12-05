
@extends('admin.layouts.login')

@section('content')
    <h2 class="login-title">BenQ账户登录</h2>
    <form class="form-horizontal login-form col-md-6 col-md-offset-3" role="form" method="POST" action="{{ url('/login') }}"> 
        {{ csrf_field() }}
        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="请输入用户名或邮箱">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
            <input id="password" type="password" class="form-control" name="password" placeholder="密码">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="input-group verification-group">
            <input id="verification" type="text" class="form-control" name="verification" placeholder="请输入验证码">
            <span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="点击刷新验证码">231231</span>
        </div>
        <div class="input-group submit-btn">
            <button type="submit" class="btn btn-primary">登  录</button>
        </div>
        <div class="form-group checkbox-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember">保持我的登录状态
                </label>
            </div>
        </div>
        <div class="login-sns">
            <span>其他方式登录</span>
            <div class="sns-list">
                <a href="#" class="sns-qq"><i class="fa fa-qq fa-fw" aria-hidden="true"></i></a>
                <a href="#" class="sns-wechat"><i class="fa fa-wechat fa-fw" aria-hidden="true"></i></a>
                <a href="#" class="sns-weibo"><i class="fa fa-weibo fa-fw" aria-hidden="true"></i></a>
            </div>
        </div>
    </form>
    <div class="clearfix"></div>

   <div class="login-footer">
       <a class="btn btn-link" href="{{ url('/password/reset') }}">忘记密码</a>|<a class="btn btn-link" href="#">意见反馈</a>
   </div>

@endsection