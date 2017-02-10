<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/27
 * Time: 15:48
 * Desc:
 */

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Transformer\SearchTransformer;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends BaseController
{

    protected $_models = ['App\Models\News','App\Models\Video'];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 全局搜索
     * @param Request $request
     * @return \Dingo\Api\Http\Response|\Illuminate\Http\JsonResponse|void
     */
    public function search(Request $request)
    {

        try {
            $per_page = $request->get('per_page', 10);
            $page     = $request->get('page', 1);
            $search   = $request->get('search');
            //如果显示太多，取最小值
            if ($per_page >= 25) $per_page = 25;
            $order = $request->get('order', 'id');
            $limit = $request->get('limit', $per_page);
            $type  = $request->get('type', '');
            $this->checkType($type);
            if (empty($search)) {
                return response()->json(['msg' => '搜索关键字不能为空', 'status' => 0]);
            }
            //根据传递模型值，获取数据来源，为空则全文搜索
            $models = empty($type) ? $this->_models : ['App\Models\\'.ucfirst($type)];

            $result = collect([]);
            //合并搜索结果
            foreach ($models as $model) {
                $result = $result->merge($model::search($search)->orderBy($order, 'desc')->get());
            }
            //根据权重排序
            $result = $result->sortByDesc(function ($value) {
                return $value->document['weight'];
            })->sortByDesc(function ($value) {
                return $value->document['percent'];
            });
            //高亮关键字
            foreach ($result as $item) {
                $xsearch           = $item::searchableUsing()->getXunsearch()->search;
                $item->title       = $xsearch->highlight($item->title);
                $item->description = $xsearch->highlight($item->description);
            }

            //collention 转 分页
            $paginator = new LengthAwarePaginator($result->forPage($page, $limit), $result->count(), $limit, $page, [
                'path'     => $request->url(),
                'query'    => $request->query(),
                'pageName' => 'page',
            ]);

            return $this->response->paginator($paginator, new SearchTransformer());

        }catch (\Exception $e){
            \Log::useDailyFiles(storage_path('logs/api.log'));
            \Log::error("{$request->fullUrl()}:请求出错,参数为:".json_encode($request->all()),[$e->getMessage(),$e->getCode()]);
            return $this->response->errorNotFound();
        }

    }

    /**
     * 校验传递的模型是否合法
     * @param $type
     */
    private function checkType($type)
    {
        if(!empty($type) && !in_array('App\Models\\'.ucfirst($type), $this->_models))
            return $this->response->errorNotFound();
    }

}