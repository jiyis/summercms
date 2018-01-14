<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Login Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles authenticating users for the application and
     | redirecting them to your home screen. The controller uses a trait
     | to conveniently provide its functionality to your applications.
     |
     */

    //use AuthenticatesUsers;
    use AuthenticatesUsers {
        login as primaryLogin;
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username   = 'email';
    protected $logger;


    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * 重写登录页面的视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('index.auth.login');
    }

    /**
     * 重写登录方法，兼容email和username登录方式
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $request->merge([$field => $request->input('username')]);

        $this->username = $field;

        $result = $this->primaryLogin($request);
        return $result;

    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('login');
    }

    /**
     * 判断登录字段问题
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
