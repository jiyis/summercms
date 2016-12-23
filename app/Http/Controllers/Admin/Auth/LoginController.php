<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\BaseController;
use App\Repository\LogRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends BaseController
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
    protected $redirectTo = '/admin/home';
    protected $username = 'email';
    protected $logger;

    /**
     * Create a new controller instance.
     * @param LogRepository $logger
     */
    public function __construct(LogRepository $logger)
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
        $this->logger = $logger;
    }

    /**
     * 重写登录页面的视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * 重写登录方法，兼容email和username登录方式
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('username')]);

        $this->username = $field;

        $result =  $this->primaryLogin($request);
        $attributes = [
            'userid'       => Auth::guard('admin')->user()->id,
            'username'      => Auth::guard('admin')->user()->name,
            'httpuseragent' => $_SERVER['HTTP_USER_AGENT'],
            'sessionid'     => session()->getId(),
            'ip'            => getClientIps()
        ];
        $this->logger->log($attributes);
        return $result;

    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('admin/login');
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
        return Auth::guard('admin');
    }
}
