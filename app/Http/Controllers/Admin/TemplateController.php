<?php

namespace App\Http\Controllers\Admin;

use App\Events\GenerateTpl;
use App\Repository\TempleteRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateTempleteRequest;
use App\Http\Requests\Admin\CreateTempleteRequest;
use App\Services\CommonServices;
use Breadcrumbs, Toastr;

class TemplateController extends BaseController
{

    private $repository;

    public function __construct(TempleteRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-template', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('模板管理', route('admin.template.index'));
        });
        $this->repository = $repository;
        view()->share('models',CommonServices::getModels());
        view()->share('layouts',CommonServices::getLayouts());

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
        $templates = $this->repository->all();
        return view('admin.template.index', compact('templates'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-template-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-template');
            $breadcrumbs->push('新增模板', route('admin.template.create'));
        });
        return view('admin.template.create');
    }

    public function store(CreateTempleteRequest $request)
    {

        $result = $this->repository->create($request->all());
        if(!$result) {
            Toastr::error('模版添加失败!');
            return redirect(route('admin.template.create'));
        }
        //更新引用此模版的栏目以及内容
        event(new GenerateTpl($result));
        Toastr::success('模版添加成功!');
        return redirect(route('admin.template.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-template-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-template');
            $breadcrumbs->push('编辑模版', route('admin.template.edit', ['id' => $id]));
        });

        $template = $this->repository->find($id);
        //$hasRoles = $user->roles()->lists('id');
        //dd($user);
        return view('admin.template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTempleteRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTempleteRequest $request, $id)
    {
        $template = $this->repository->findWithoutFail($id);

        if (empty($template)) {
            Toastr::error('模版未找到');

            return redirect(route('admin.template.index'));
        }
        $template = $this->repository->update($request->all(), $id);
        //更新引用此模版的栏目以及内容
        event(new GenerateTpl($template));
        Toastr::success('模版更新成功.');

        return redirect(route('admin.template.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = $this->repository->findWithoutFail($id);
        if (empty($template)) {
            Toastr::error('模版未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}