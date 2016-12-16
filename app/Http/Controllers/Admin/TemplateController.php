<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;

class TemplateController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        Breadcrumbs::register('admin-template', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('模板管理', route('admin.template.index'));
        });

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-template-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-template');
            $breadcrumbs->push('模板列表', route('admin.template.index'));
        });
        return view('admin.template.index');
    }

    public function create()
    {
        Breadcrumbs::register('admin-template-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-template');
            $breadcrumbs->push('新增模板', route('admin.template.create'));
        });
        return view('admin.template.create');
    }
}