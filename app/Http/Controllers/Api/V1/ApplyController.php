<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:02
 * Desc:
 */

namespace App\Http\Controllers\Api\V1;


use App\Models\ApplyUser;
use App\Repository\ApplyRepository;
use Illuminate\Http\Request;

class ApplyController extends BaseController
{
    private $repository;

    public function __construct(ApplyRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        //判断来源
        if(!isset($_SERVER['HTTP_REFERER'])) {
            abort(404);
        }
        $cid = $request->get('cid');
        $apply = $this->repository->findWithoutFail($cid);
        if (empty($apply)) {
            return response()->json(['msg' => '赛事不存在', 'type' => 'error', 'status' => 0]);
        }

        $data['area'] = $request->get('area');
        $data['team'] = $request->get('team');
        $registers = $request->get('register');
        $data['name'] = current($registers[0]);

        //验证第一行是否信息都填写完全
        if(count($registers) !== count(array_filter($registers[0])) || empty($data['area']) || empty($data['team']) ){
            return response()->json(['msg' => '请将信息填写完全', 'type' => 'error', 'status' => 0]);
        }

        $data['content'] = json_encode($registers);
        $data['ip'] = $request->get('ip');
        $data['cid'] = $cid;
        $apply_user = ApplyUser::create($data);
        return response()->json(['msg' => '报名成功', 'type' => 'success', 'status' => 1]);
    }

}