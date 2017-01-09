<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ApplyRequest;
use Illuminate\Http\Request;
use App\Repository\ApplyRepository;
use Breadcrumbs, Toastr;

class ApplyController extends BaseController
{

    private $repository;

    public function __construct(ApplyRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-apply', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('报名管理', route('admin.apply.index'));
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
        Breadcrumbs::register('admin-apply-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-apply');
            $breadcrumbs->push('报名管理', route('admin.apply.index'));
        });
        $applies = $this->repository->all();
        return view('admin.apply.index', compact('applies'));
    }

    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Breadcrumbs::register('admin-apply-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-apply');
            $breadcrumbs->push('新增报名', route('admin.apply.create'));
        });
        return view('admin.apply.create');
    }

    public function store(ApplyRequest $request)
    {
        $result = $this->repository->create($request->all());
        if(!$result) {
            Toastr::error('报名添加失败!');
            return redirect(route('admin.apply.create'));
        }
        Toastr::success('报名添加成功!');
        return redirect(route('admin.apply.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-apply-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-apply');
            $breadcrumbs->push('编辑报名', route('admin.apply.edit', ['id' => $id]));
        });

        $apply = $this->repository->find($id);
        return view('admin.apply.edit', compact('apply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ApplyRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplyRequest $request, $id)
    {
        $apply = $this->repository->findWithoutFail($id);

        if (empty($apply)) {
            Toastr::error('报名未找到');

            return redirect(route('admin.apply.index'));
        }
        $apply = $this->repository->update($request->all(), $id);
        Toastr::success('报名更新成功.');

        return redirect(route('admin.apply.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apply = $this->repository->findWithoutFail($id);
        if (empty($apply)) {
            Toastr::error('报名未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}
