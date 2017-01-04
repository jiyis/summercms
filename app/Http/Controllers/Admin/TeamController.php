<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/4
 * Time: 10:37
 * Desc:
 */

namespace App\Http\Controllers\Admin;

use App\Repository\TeamRepository;
use App\Http\Requests\Admin\TeamRequest;
use App\Services\CommonServices;
use Breadcrumbs, Toastr;

class TeamController extends BaseController
{
    private $repository;

    public function __construct(TeamRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-team', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('战队管理', route('admin.team.index'));
        });
        $this->repository = $repository;
        view()->share('countrys', CommonServices::getCountrys());

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-team-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-team');
            $breadcrumbs->push('战队列表', route('admin.team.index'));
        });
        $teams = $this->repository->getTeamsByCountry();
        return view('admin.team.index', compact('teams'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-team-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-team');
            $breadcrumbs->push('新增战队', route('admin.team.create'));
        });
        return view('admin.team.create');
    }

    public function store(TeamRequest $request)
    {
        $result = $this->repository->create($request->all());
        if(!$result) {
            Toastr::error('战队添加失败!');
            return redirect(route('admin.team.create'));
        }
        Toastr::success('战队添加成功!');
        return redirect(route('admin.team.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-team-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-team');
            $breadcrumbs->push('编辑战队', route('admin.team.edit', ['id' => $id]));
        });

        $team = $this->repository->find($id);
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeamRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        $team = $this->repository->findWithoutFail($id);

        if (empty($team)) {
            Toastr::error('战队未找到');

            return redirect(route('admin.team.index'));
        }
        $team = $this->repository->update($request->all(), $id);
        Toastr::success('战队更新成功.');

        return redirect(route('admin.team.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = $this->repository->findWithoutFail($id);
        if (empty($team)) {
            Toastr::error('战队未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}