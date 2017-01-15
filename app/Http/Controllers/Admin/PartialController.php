<?php

namespace App\Http\Controllers\Admin;

use App\Repository\PartialRepository;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr, Validator;
use App\Http\Controllers\Admin\Traits\ResourceManage;

class PartialController extends BaseController
{
    use ResourceManage;

    private $repository;

    public function __construct(PartialRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-partial', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('部件管理', route('admin.partial.index'));
        });
        $this->repository = $repository;

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-partial-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-partial');
            $breadcrumbs->push('部件列表', route('admin.partial.index'));
        });
        $partials = $this->repository->all();
        return view('admin.partial.index',compact('partials'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-partial-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-partial');
            $breadcrumbs->push('新增部件', route('admin.partial.create'));
        });
        return view('admin.partial.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|unique:partial,title',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Toastr::error(implode('<br>',array_values($validator->errors()->all())));
            return redirect(route('admin.partial.create'));
        }
        $result = $this->repository->create($input);
        if(!$result) {
            Toastr::error('部件添加失败!');
            return redirect(route('admin.partial.create'));
        }
        $this->generatePartial($request->get('title'),$request->get('content'));
        Toastr::success('部件添加成功!');
        return redirect(route('admin.partial.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-partial-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-partial');
            $breadcrumbs->push('编辑部件', route('admin.partial.edit', ['id' => $id]));
        });

        $partial = $this->repository->find($id);

        return view('admin.partial.edit', compact('partial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $partial = $this->repository->findWithoutFail($id);

        if (empty($partial)) {
            Toastr::error('部件未找到');

            return redirect(route('admin.partial.index'));
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|unique:partial,title,'.$id,
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Toastr::error(implode('<br>',array_values($validator->errors()->all())));
            return redirect(route('admin.partial.edit',$id));
        }
        $partial = $this->repository->update($input, $id);
        $this->generatePartial($request->get('title'),$request->get('content'));
        Toastr::success('部件更新成功.');

        return redirect(route('admin.partial.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partial = $this->repository->findWithoutFail($id);
        if (empty($partial)) {
            Toastr::error('部件未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}