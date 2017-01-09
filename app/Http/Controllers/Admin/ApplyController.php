<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;

class ApplyController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-apply-index', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('报名管理', route('admin.apply.index'));
        });
        return view('admin.apply.index');
    }

    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Breadcrumbs::register('admin-apply-create', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('新增报名', route('admin.apply.create'));
        });
        return view('admin.apply.create');
    }
}
