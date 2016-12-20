<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateLayoutRequest;
use App\Http\Requests\Admin\UpdateLayoutRequest;
use App\Repository\LayoutRepository;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr, Validator;
use App\Http\Controllers\Admin\Traits\ResourceManage;

class LayoutController extends BaseController
{
    use ResourceManage;

    private $layoutRepository;

    public function __construct(LayoutRepository $layoutRepository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-layout', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('布局管理', route('admin.layout.index'));
        });
        $this->layoutRepository = $layoutRepository;

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
        $layouts = $this->layoutRepository->all();
        return view('admin.layout.index',compact('layouts'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-layout-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-layout');
            $breadcrumbs->push('新增布局', route('admin.layout.create'));
        });
        return view('admin.layout.create');
    }

    public function store(CreateLayoutRequest $request)
    {

        $result = $this->layoutRepository->create($request->all());
        if(!$result) {
            Toastr::error('布局添加失败!');
            return redirect(route('admin.layout.create'));
        }
        $this->generateLayout($request->get('title'),$request->get('content'));
        Toastr::success('布局添加成功!');
        return redirect(route('admin.layout.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-layout-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-layout');
            $breadcrumbs->push('编辑布局', route('admin.layout.edit', ['id' => $id]));
        });

        $layout = $this->layoutRepository->find($id);
        //$hasRoles = $user->roles()->lists('id');
        //dd($user);
        return view('admin.layout.edit', compact('layout'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLayoutRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLayoutRequest $request, $id)
    {
        $layout = $this->layoutRepository->findWithoutFail($id);

        if (empty($layout)) {
            Toastr::error('布局未找到');

            return redirect(route('admin.layout.index'));
        }
        $layout = $this->layoutRepository->update($request->all(), $id);
        $this->generateLayout($request->get('title'),$request->get('content'));
        Toastr::success('布局更新成功.');

        return redirect(route('admin.layout.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $layout = $this->layoutRepository->findWithoutFail($id);
        if (empty($layout)) {
            Toastr::error('布局未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->layoutRepository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}