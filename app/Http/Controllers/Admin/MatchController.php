<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MatchRequest;
use App\Models\MatchGroup;
use App\Models\MatchGroupDetail;
use App\Repository\MatchRepository;
use App\Services\CommonServices;
use Breadcrumbs, Toastr, Validator;
use Illuminate\Http\Request;

class MatchController extends BaseController
{

    private $repository;

    public function __construct(MatchRepository $repository)
    {
        parent::__construct();

        Breadcrumbs::register('admin-match', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('赛事管理', route('admin.match.index'));
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
        Breadcrumbs::register('admin-match-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-match');
            $breadcrumbs->push('赛事列表', route('admin.match.index'));
        });
        $matches = $this->repository->getAll();
        return view('admin.match.index', compact('matches'));
    }

    public function create()
    {
        Breadcrumbs::register('admin-match-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-match');
            $breadcrumbs->push('新增赛事', route('admin.match.create'));
        });
        return view('admin.match.create');
    }

    public function store(MatchRequest $request)
    {
        $input = $this->resetDefault($request->all(), $this->repository->makeModel());
        $result = $this->repository->create($input);
        if(!$result) {
            Toastr::error('赛事添加失败!');
            return redirect(route('admin.match.create'));
        }
        Toastr::success('赛事添加成功!');
        return redirect(route('admin.match.index'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-match-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-match');
            $breadcrumbs->push('编辑赛事', route('admin.match.edit', ['id' => $id]));
        });

        $match = $this->repository->find($id);
        return view('admin.match.edit', compact('match'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MatchRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MatchRequest $request, $id)
    {
        $match = $this->repository->findWithoutFail($id);

        if (empty($match)) {
            Toastr::error('赛事未找到');

            return redirect(route('admin.match.index'));
        }
        $input = $this->resetDefault($request->all(), $this->repository->makeModel());
        $match = $this->repository->update($input, $id);
        Toastr::success('赛事更新成功.');

        return redirect(route('admin.match.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $match = $this->repository->findWithoutFail($id);
        if (empty($match)) {
            Toastr::error('赛事未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->repository->delete($id);

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }

    /**
     * 构建赛事
     * @param $id 这里是赛事id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function build($id)
    {
        Breadcrumbs::register('admin-match-build', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-match');
            $breadcrumbs->push('构建赛事', route('admin.match.build', ['id' => $id]));
        });

        $match = $this->repository->find($id);
        $groups = MatchGroup::where(['match_id' => $id])->get();
        //获取所有战队列表
        $teams = CommonServices::getTeams($match->gid);
        return view('admin.match.build', compact('match','id','groups','teams'));
    }

    /**
     * 保存比赛分组
     * @param Request $request
     * @param $id 这里是赛事id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeGroup(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'match_id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Toastr::error(implode('<br>',array_values($validator->errors()->all())));
            return redirect(route('admin.match.build',$id));
        }
        $input = $this->resetDefault($input, MatchGroup::where(['match_id' => $id]));
        $group = MatchGroup::create($input);
        Toastr::success('小组添加成功.');
        return redirect(route('admin.match.build',$id));

    }

    /**
     * 更新比赛分组信息
     * @param Request $request
     * @param $id 这里是分组id，赛事id是 $request->get('match_id')
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateGroup(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'match_id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            Toastr::error(implode('<br>',array_values($validator->errors()->all())));
            return redirect(route('admin.match.build',$input['match_id']));
        }
        $input = $this->resetDefault($input, MatchGroup::where(['match_id' => $input['match_id']]));
        $group = MatchGroup::find($id)->update($input);
        Toastr::success('小组更新成功.');
        return redirect(route('admin.match.build',$input['match_id']));
    }

    /**
     * 删除比赛分组
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyGroup($id)
    {
        $match = MatchGroup::find($id);
        if (empty($match)) {
            Toastr::error('组别未找到');
            return response()->json(['status' => 0]);
        }
        $result = MatchGroup::find($id)->delete();
        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }

    /**
     * 新建小组比赛详细内容
     * @param Request $request
     * @param $id 这里是赛事id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storeGroupDetails(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'group_id' => 'required',
            'team_id_a' => 'required',
            'team_id_b' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails() || $input['team_id_a'] == $input['team_id_b']) {
            $errors = implode('<br>',array_values($validator->errors()->all()));
            if(!$errors) $errors = '同一队伍不能比赛';
            Toastr::error($errors);
            return redirect(route('admin.match.build',$id));
        }
        $input = $this->resetDefault($input, MatchGroupDetail::where(['group_id' => $input['group_id']]));
        $group_detail = MatchGroupDetail::create($input);
        Toastr::success('比赛详情添加成功.');
        return redirect(route('admin.match.build',$id));
    }

    /**
     * 更新小组比赛详细内容信息
     * @param Request $request
     * @param $id 这里是小组详情id，小组id是 $request->get('group_id')
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateGroupDetails(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'group_id' => 'required',
            'match_id' => 'required',
            'team_id_a' => 'required',
            'team_id_b' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails() || $input['team_id_a'] == $input['team_id_b']) {
            $errors = implode('<br>',array_values($validator->errors()->all()));
            if(!$errors) $errors = '同一队伍不能比赛';
            Toastr::error($errors);
            return redirect(route('admin.match.build',$input['match_id']));
        }
        $input = $this->resetDefault($input, MatchGroupDetail::where(['group_id' => $input['group_id']]));
        $group_detail = MatchGroupDetail::find($id)->update($input);
        Toastr::success('比赛详情更新成功.');
        return redirect(route('admin.match.build',$input['match_id']));
    }

    /**
     * 删除比赛分组详细信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyGroupDetails($id)
    {
        $match = MatchGroupDetail::find($id);
        if (empty($match)) {
            Toastr::error('比赛详情未找到');
            return response()->json(['status' => 0]);
        }
        $result = MatchGroupDetail::find($id)->delete();
        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }

    private function resetDefault(array $input,  $model)
    {
        if(!isset($input['default'])) {
            $input['default'] = 0;
            return $input;
        } else{
            $model->where(['default' => 1])->update(['default' => 0]);
            return $input;
        }
    }
}