<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\SeoManage;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;
use App\Services\CommonServices;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends BaseController
{
    use SeoManage;

    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-category', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('栏目管理', route('admin.category.index'));
        });
        $this->repository = $repository;
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
        $categories = $this->repository->all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-category-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-category');
            $breadcrumbs->push('新增栏目', route('admin.category.create'));
        });
        return view('admin.category.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $result = $this->repository->create($request->all());
        if(!$result) {
            Toastr::error('栏目添加失败!');
            return redirect(route('admin.category.create'));
        }
        $this->saveSeo($request->all(), $result->id);
        Toastr::success('栏目添加成功!');
        return redirect(route('admin.category.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-category-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-category');
            $breadcrumbs->push('编辑栏目', route('admin.category.edit', ['id' => $id]));
        });

        $category = $this->repository->find($id);
        $category = $this->getSeo($category, 'category');

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->repository->findWithoutFail($id);

        if (empty($category)) {
            Toastr::error('栏目未找到');

            return redirect(route('admin.category.index'));
        }
        $category = $this->repository->update($request->all(), $id);
        $this->saveSeo($request->all(), $id);
        Toastr::success('栏目更新成功.');

        return redirect(route('admin.category.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->repository->findWithoutFail($id);
        if (empty($category)) {
            Toastr::error('栏目未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}