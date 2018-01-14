<?php

namespace App\Http\Middleware;

use App\Repository\LogRepository;
use App\Repository\OperationLogRepository;
use Closure;
use Route,URL,Auth;

class AuthenticateAdmin
{

    private $logger;
    private $guard = 'admin';

    public function __construct(OperationLogRepository $logger)
    {
        $this->logger = $logger;
        $this->guard = 'admin';
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guard($this->guard)->check()){
            return redirect('admin/login');
        }

        if(Auth::guard($this->guard)->user()->is_super){
            $this->log($request);
            return $next($request);
        }

        $previousUrl = URL::previous();
        if(!Auth::guard($this->guard)->user()->can(Route::currentRouteName())) {
            if($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            } else {
                return response()->view('admin.errors.403', compact('previousUrl'));
            }
        }

        $response = $next($request);
        //验证成功了，记录用户操作日志，主要是看当前请求了哪个页面。
        $this->log($request);
        return $response;
    }

    private function log($request)
    {
        if($request->method() == 'GET') return;
        $route = Route::current()->getActionName();
        list($class, $action) = explode('@', $route);

        $attributes = [
            'controller'  => $class,
            'action'      => $action,
            'querystring' => empty($request->route()->parameters()) ? '' : json_encode($request->route()->parameters()),
            'userid'      => Auth::guard($this->guard)->user()->id,
            'username'    => Auth::guard($this->guard)->user()->name,
            'method'      => $request->method(),
            'ip'          => $request->ip(),
        ];

        $this->logger->log($attributes);
    }
}
