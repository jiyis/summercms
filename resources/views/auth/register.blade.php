 <h2 class="login-title">BenQ账户注册</h2>
<form class="login-form col-md-8 col-md-offset-2" role="form" method="POST" action="{{ url('/register') }}">
    {{ csrf_field() }}

    <div class="input-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="用户名">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="常用邮箱">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
        <input id="password" type="password" class="form-control" name="password" placeholder="6-16位密码,区分大小写">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="再次输入密码">

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember">我已阅读并同意<a href="#">《BenQ用户注册协议》</a>
            </label>
        </div>
    </div>
    
    <div class="input-group submit-btn">
        <button type="submit" class="btn btn-success">快速注册</button>
    </div>
</form>
<div class="clearfix"></div>
<div class="login-footer">
   <a class="btn btn-link" href="#">意见反馈</a>
</div> 
