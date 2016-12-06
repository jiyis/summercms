<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/8/31
 * Time: 9:10
 */

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Repository\AdminLogRepository;
use App\Repository\LogRepository;
use Illuminate\Http\Request;
use Breadcrumbs;

class LogController extends BaseController
{
    private $logRespository;

    private $adminLogRespository;

    public function __construct(LogRepository $logRespository, AdminLogRepository $adminLogRespository)
    {
        parent::__construct();
        $this->logRespository = $logRespository;
        $this->adminLogRespository = $adminLogRespository;

    }

    /**
     * @return mixed
     * 后台用户操作日志
     */
    public function operationLog ()
    {
        Breadcrumbs::register('admin-logs-logs', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('操作日志', route('admin.operationlog.index'));
        });
        $logs = $this->logRespository->all();
        return view('admin.logs.operationlog',compact('logs'));
    }

    /**
     * @param Request $request
     * datatable ajax返回数据
     */
    public function ajaxOperationLog(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->get('start');
        $length = $request->get('length');
        $logs = $this->logRespository->pagination($length,$start,$search);
        $alllogs = $this->logRespository->search($search);
        $data = [];
        $data['draw'] = $request->get('draw');
        $data['recordsTotal'] = count($alllogs);
        $data['recordsFiltered'] = count($alllogs);
        $data['data'] = $logs;
        echo json_encode($data);exit;
    }

    /**
     * @return mixed
     * 用户登陆日志
     */
    public function logs()
    {
        Breadcrumbs::register('admin-logs-adminlogs', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('登录日志', route('admin.logs.index'));
        });
        $logs = $this->adminLogRespository->all();
        return view('admin.logs.logs',compact('logs'));
    }

    /**
     * @param Request $request
     * 用户登录日志ajax接口
     */
    public function ajaxLogs(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->get('start');
        $length = $request->get('length');
        $logs = $this->adminLogRespository->pagination($length,$start,$search);
        $alllogs = $this->adminLogRespository->search($search);
        $data = [];
        $data['draw'] = $request->get('draw');
        $data['recordsTotal'] = count($alllogs);
        $data['recordsFiltered'] = count($alllogs);
        $data['data'] = $logs;
        echo json_encode($data);exit;
    }

}