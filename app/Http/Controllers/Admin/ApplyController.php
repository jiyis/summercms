<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ApplyRequest;
use App\Library\Complite\Compilate;
use Illuminate\Http\Request;
use App\Repository\ApplyRepository;
use App\Services\CommonServices;
use App\Http\Controllers\Admin\Traits\ResourceManage;
use App\Library\Complite\Handlers\BladeHandler;
use Breadcrumbs, Toastr;

class ApplyController extends BaseController
{
    use ResourceManage;

    private $repository;

    public function __construct(ApplyRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-apply', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('报名管理', route('admin.apply.index'));
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
        $result = $this->repository->save($request->all());
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
        $apply->rowArr = collect(explode('||', $apply->row))->flatMap(function($v) {
            return [$v => $v];
        });
        $apply->columnArr = collect(explode('||', $apply->column))->flatMap(function($v) {
            return [$v => $v];
        });
        $apply->row = $apply->rowArr->keys()->all();
        $apply->column = $apply->columnArr->keys()->all();
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
        $apply = $this->repository->save($request->all(), $id);
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

    /**
     * 查看当前报名赛事的所有报名人信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users(Request $request, $id)
    {
        Breadcrumbs::register('admin-apply-users', function ($breadcrumbs) use($id) {
            $breadcrumbs->parent('admin-apply');
            $breadcrumbs->push('报名人员列表', route('admin.apply.users', $id));
        });
        $apply = $this->repository->find($id);
        $users = $apply->users;
        return view('admin.apply.users', compact('users','apply'));
    }

    public function publish(Compilate $build, $id)
    {
        $apply = $this->repository->find($id);
        $url = $apply->url;
        $content = \File::get(base_path('resources/stub/').'register.stub');
        $table = $this->generateTable($apply);
        //替换content的变量值
        $content = str_replace(['{{$layout}}','{{$title}}','{{$content}}','{{$table}}'],[$apply->layout, $apply->title, $apply->description,$table],$content);
        $file_name = $this->generateRegister($url,$content);
        $build->registerHandler(new BladeHandler());
        $sourcePath = base_path('resources/views/templete') . $file_name;
        $buildPath = base_path('build');
        $build->build($sourcePath, $buildPath);
        return response()->json(['status' => 1]);
    }
}
