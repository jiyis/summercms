<?php
/**
 * Created by Gary.F.Dong.
 * Date: 2016/12/25
 * Time: 15:14
 * Desc：
 */

namespace App\Http\Controllers\Api\V1;

use App\Transformer\BreadTransformer;
use Illuminate\Http\Request;
use App\Models\DataType;
use DB, Schema, Cache;

class BreadController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 自定义模型的api接口
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $slug     = $request->segment(1);
            $dataType = Cache::tags($slug)->remember($slug.'_date_type_cache', 60, function() use($slug) {
                return DataType::where('slug', '=', $slug)->first();
            });

            $per_page = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            $where = $request->except(['per_page', 'order', 'limit', 'page']);
            //如果显示太多，取最小值
            if ($per_page >= 25) $per_page = 25;
            $order           = $request->get('order', 'id');
            $limit           = $request->get('limit', $per_page);
            $model_name      = $dataType->model_name;
            //根据传递的条件生成唯一key值
            $unique_key = implode(array_filter([$slug, $per_page, implode($where, '_'), $order, $limit, $page]), '_');
            //把取到的数据缓存1个小时
            $dataTypeContent = Cache::tags($dataType->name)->remember($unique_key.'_orm_cache', 60, function() use($model_name,  $order,$limit,$where, $dataType) {
                return (strlen($model_name) != 0)
                    ? call_user_func_array([$model_name::orderBy($order, 'desc')->where($where), 'paginate'], [$limit])
                    : DB::table($dataType->name)->orderBy($order, 'desc')->where($where)->paginate($limit);
            });
            return $this->response->paginator($dataTypeContent, new BreadTransformer());
        }catch (\Exception $e){
            \Log::useDailyFiles(storage_path('logs/api.log'));
            \Log::error("{$request->fullUrl()}:请求出错,参数为:".json_encode($request->all()),[$e->getMessage(),$e->getCode()]);
            return $this->response->errorNotFound();
        }

    }

    /**
     * 获取某一篇文章的浏览数
     * @param Request $request
     * @param $id
     */
    public function viewCount(Request $request, $id)
    {
        try {
            $slug     = $request->segment(1);
            $dataType = DataType::where('slug', '=', $slug)->first();
            if (Schema::hasColumn($dataType->name, 'view_count')) {
                if (strlen($dataType->model_name) != 0) {
                    $view_count = call_user_func_array([$dataType->model_name, 'find'], [$id, ['view_count']]);
                } else {
                    $view_count = DB::table($dataType->name)->find($id, ['view_count']);
                }
                return $this->response->array($view_count->view_count);
            } else {
                return $this->response->errorNotFound();
            }
        }catch (\Exception $e){
            \Log::useDailyFiles(storage_path('logs/api.log'));
            \Log::error("{$request->fullUrl()}:请求出错,参数为:".json_encode($request->all()),[$e->getMessage(),$e->getCode()]);
            return $this->response->errorNotFound();
        }

    }

    /**
     * 更新某一篇文章的浏览数
     * @param Request $request
     * @param $id
     */
    public function updateViewCount(Request $request, $id)
    {
        try {
            $slug     = $request->segment(1);
            $dataType = DataType::where('slug', '=', $slug)->first();
            if (Schema::hasColumn($dataType->name, 'view_count')) {
                DB::table($dataType->name)->where(['id' => $id])->increment('view_count');
                $view_count = DB::table($dataType->name)->find($id,['view_count']);

                return $this->response->array($view_count->view_count);
            } else {
                return $this->response->errorNotFound();
            }
        }catch (\Exception $e){
            \Log::useDailyFiles(storage_path('logs/api.log'));
            \Log::error("{$request->fullUrl()}:请求出错,参数为:".json_encode($request->all()),[$e->getMessage(),$e->getCode()]);
            return $this->response->errorNotFound();
        }
    }

}