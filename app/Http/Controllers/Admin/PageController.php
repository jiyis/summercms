<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;

class PageController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        Breadcrumbs::register('admin-page', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('页面管理', route('admin.page.index'));
        });

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-page-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-page');
            $breadcrumbs->push('页面列表', route('admin.page.index'));
        });
        return view('admin.page.index');
    }

    public function create()
    {
        Breadcrumbs::register('admin-page-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-page');
            $breadcrumbs->push('新增页面', route('admin.page.create'));
        });
        return view('admin.page.create');
    }
}