<?php

namespace App\Http\Controllers\Admin;

use App\Repository\SearchTempleteRepository;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UpdateTempleteRequest;
use App\Http\Requests\Admin\CreateTempleteRequest;
use App\Services\CommonServices;
use Breadcrumbs, Toastr;

class SearchTempleteController extends BaseController
{

    private $repository;

    public function __construct(SearchTempleteRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-search', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('搜索模板管理', route('admin.search.index'));
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
        Breadcrumbs::register('admin-search-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-search');
            $breadcrumbs->push('搜索模板列表', route('admin.search.index'));
        });
        $searchs = $this->repository->all();
        return view('admin.search.index', compact('searchs'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-search-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-search');
            $breadcrumbs->push('新增搜索模板', route('admin.search.create'));
        });
        return view('admin.search.create');
    }

    public function store(CreateTempleteRequest $request)
    {

        $result = $this->repository->create($request->all());
        if(!$result) {
            Toastr::error('模版添加失败!');
            return redirect(route('admin.search.create'));
        }
        //$this->generateTemplete($request->get('title'),$request->get('content'));
        Toastr::success('模版添加成功!');
        return redirect(route('admin.search.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-search-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-search');
            $breadcrumbs->push('编辑模版', route('admin.search.edit', ['id' => $id]));
        });

        $search = $this->repository->find($id);
        //$hasRoles = $user->roles()->lists('id');
        //dd($user);
        return view('admin.search.edit', compact('search'));
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
        $search = $this->repository->findWithoutFail($id);

        if (empty($search)) {
            Toastr::error('模版未找到');

            return redirect(route('admin.search.index'));
        }
        $search = $this->repository->update($request->all(), $id);
        //$this->generateTemplete($request->get('title'),$request->get('content'));
        Toastr::success('模版更新成功.');

        return redirect(route('admin.search.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $search = $this->repository->findWithoutFail($id);
        if (empty($search)) {
            Toastr::error('模版未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}