<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:02
 * Desc:
 */

namespace App\Http\Controllers\Api\V1;


use App\Repository\MatchRepository;
use Illuminate\Http\Request;

class MatchController extends BaseController
{
    private $repository;

    public function __construct(MatchRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        try{
            $this->repository->setPresenter("App\\Presenter\\MatchPresenter");
            $pages = $this->repository->paginate(6);
            return $this->response->array($pages);
        }catch (\Exception $e){
            \Log::useDailyFiles(storage_path('logs/api.log'));
            \Log::error("{$request->fullUrl()}:请求出错,参数为:".json_encode($request->all()),[$e->getMessage(),$e->getCode()]);
            return $this->response->errorNotFound();
        }

    }

}