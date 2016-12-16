<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;

class LayoutController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        Breadcrumbs::register('admin-layout', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('布局管理', route('admin.layout.index'));
        });

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-layout-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-layout');
            $breadcrumbs->push('布局列表', route('admin.layout.index'));
        });
        return view('admin.layout.index');
    }

    public function create()
    {
        Breadcrumbs::register('admin-layout-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-layout');
            $breadcrumbs->push('新增布局', route('admin.layout.create'));
        });
        return view('admin.layout.create');
    }
}