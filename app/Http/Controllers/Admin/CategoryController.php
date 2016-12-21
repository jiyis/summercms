<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;
use App\Services\CommonServices;

class CategoryController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        Breadcrumbs::register('admin-category', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('栏目管理', route('admin.category.index'));
        });
        view()->share('layouts',CommonServices::getLayouts());

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-category-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-category');
            $breadcrumbs->push('栏目列表', route('admin.category.index'));
        });
        return view('admin.category.index');
    }

    public function create()
    {
        Breadcrumbs::register('admin-category-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-category');
            $breadcrumbs->push('新增栏目', route('admin.category.create'));
        });
        return view('admin.category.create');
    }
}