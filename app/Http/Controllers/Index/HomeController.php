<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 17-11-17
 * Time: 下午1:57
 * Desc:
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Repository\MemberRepository;
use App\Repository\ProjectRepository;
use Breadcrumbs, Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public $repository;

    public function __construct(MemberRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;


        Breadcrumbs::register('index-home', function ($breadcrumbs) {
            $breadcrumbs->push('管理中心', route('home'));
        });
    }

    public function index()
    {
        Breadcrumbs::register('index-home-index', function ($breadcrumbs) {
            $breadcrumbs->parent('index-home');
            $breadcrumbs->push('首页', route('home'));
        });

        $data['project_numbers'] = app(ProjectRepository::class)->get()->count();

        $data['project_uncheck_numbers'] = app(ProjectRepository::class)->findWhere(['report' => 0])->count();

        $data['project_check_numbers'] = app(ProjectRepository::class)->findWhere(['review_status' => 1])->count();

        $data['project_uncheck_numbers'] = app(ProjectRepository::class)->findWhere(['review_status' => 0])->count();


        return view("index.home", compact('data'));
    }

    public function center()
    {
        Breadcrumbs::register('index-home-center', function ($breadcrumbs) {
            $breadcrumbs->parent('index-home');
            $breadcrumbs->push('个人中心', route('home.center'));
        });

        $user = $this->repository->find(Auth::guard('web')->user()->id);

        return view("index.center", compact('user'));
    }

    public function update(Request $request)
    {
        if($request->get('password') == ''){
            $data = $request->except(['password', 'name']);
        }else{
            $data = $request->except(['name']);
        }

        $result = $this->repository->update($data, Auth::guard('web')->user()->id);

        Toastr::success('更新成功.');

        return redirect(route('home'));
    }


}