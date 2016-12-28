<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/27
 * Time: 15:48
 * Desc:
 */

namespace App\Http\Controllers\Api\V1;


use App\Models\OperationLogs;
use Illuminate\Http\Request;
use Searchy;

class SearchController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function search(Request $request)
    {
        $model = new OperationLogs();
        $res = Searchy::search('operation_logs')->fields('action')->query('edit')->get();
        dd($res);
    }
}