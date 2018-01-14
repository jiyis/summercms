<?php

namespace App\Http\Controllers\Admin;

use App\Repository\AdminUserRepository;
use App\Repository\MemberRepository;
use App\Repository\ProjectRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Breadcrumbs, Toastr, Auth;

class HomeController extends Controller
{

    public $repository;

    public function __construct(AdminUserRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;


        Breadcrumbs::register('admin-home', function ($breadcrumbs) {
            $breadcrumbs->push('管理中心', route('home'));
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $pdo     = \DB::connection()->getPdo();

        $version = $pdo->query('select version()')->fetchColumn();

        $data = [
            'server'          => $_SERVER['SERVER_SOFTWARE'],
            'http_host'       => $_SERVER['HTTP_HOST'],
            'remote_host'     => isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : $_SERVER['REMOTE_ADDR'],
            'user_agent'      => $_SERVER['HTTP_USER_AGENT'],
            'php'             => phpversion(),
            'sapi_name'       => php_sapi_name(),
            'extensions'      => implode(", ", get_loaded_extensions()),
            'db_connection'   => isset($_SERVER['DB_CONNECTION']) ? $_SERVER['DB_CONNECTION'] : 'Secret',
            'db_database'     => isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : 'Secret',
            'db_version'      => $version,
        ];


        return view('admin.home', compact('data'));
    }

    public function center()
    {
        Breadcrumbs::register('admin-home-center', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-home');
            $breadcrumbs->push('个人中心', route('home.center'));
        });

        $user = $this->repository->find(Auth::guard('admin')->user()->id);

        return view("admin.center", compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $result = $this->repository->update($data, Auth::guard('admin')->user()->id);

        Toastr::success('更新成功.');

        return redirect(route('admin.home'));
    }

}
