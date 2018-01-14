<?php

namespace App\Http\Controllers\Admin;

use App\Repository\AdminUserRepository;
use Illuminate\Http\Request;
use App\Repository\MemberRepository;
use App\Http\Requests\Admin\CreateMemberRequest;
use App\Http\Requests\Admin\UpdateMemberRequest;
use Breadcrumbs, Toastr;

class MemberController extends Controller
{
    protected $member;
    protected $adminUser;

    public function __construct(MemberRepository $member, AdminUserRepository $adminUser)
    {
        parent::__construct();
        $this->member = $member;
        $this->adminUser = $adminUser;

        Breadcrumbs::register('admin-member', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('客户管理', route('admin.member.index'));
        });
    }

    public function index()
    {
        Breadcrumbs::register('admin-member-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-member');
            $breadcrumbs->push('客户列表', route('admin.member.index'));
        });

        $members = $this->member->all();
        $users = $this->adminUser->findWhereIn('id', $members->pluck('belong_to')->toArray())->pluck('nickname', 'id')->toArray();
        return view('admin.member.index', compact('members','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Breadcrumbs::register('admin-member-create', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-member');
            $breadcrumbs->push('添加客户', route('admin.member.create'));
        });
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMemberRequest $request)
    {

        $result = $this->member->create($request->all());
        if(!$result) {
            Toastr::error('新客户添加失败!');
            return redirect(route('admin.member.create'));
        }
        Toastr::success('新客户添加成功!');
        return redirect('admin/member');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-member-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-member');
            $breadcrumbs->push('编辑客户', route('admin.member.edit', ['id' => $id]));
        });

        $member = $this->member->find($id);

        return view('admin.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $user = $this->member->findWithoutFail($id);

        if (empty($user)) {
            Toastr::error('客户未找到');

            return redirect(route('admin.member.index'));
        }
        if($request->get('password') == ''){
            $data = $request->except('password');
        }else{
            $data = $request->all();
        }
        $user = $this->member->update($data, $id);

        Toastr::success('客户更新成功.');

        return redirect(route('admin.member.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->member->findWithoutFail($id);
        if (empty($user)) {
            Toastr::error('客户未找到');

            return response()->json(['status' => 0]);
        }
        $result = $this->member->delete($id);
        //Toastr::success('客户删除成功');

        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }

    /**
     * Delete multi member
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyAll(Request $request)
    {
        if(!($ids = $request->get('ids', []))) {
            return response()->json(['status' => 0, 'msg' => '请求参数错误']);
        }

        foreach($ids as $id){
            $result = $this->member->delete($id);
        }
        return response()->json($result ? ['status' => 1] : ['status' => 0]);
    }
}
