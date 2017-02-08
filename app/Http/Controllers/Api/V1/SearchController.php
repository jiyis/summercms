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
use App\Models\News;
use App\Models\Video;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function search(Request $request)
    {

        $per_page = $request->get('per_page', 10);
        $page     = $request->get('page', 1);
        $search   = $request->get('search');
        //如果显示太多，取最小值
        if ($per_page >= 25) $per_page = 25;
        $order = $request->get('order', 'id');
        $limit = $request->get('limit', $per_page);

        if (empty($search)) {
            return response()->json(['msg' => '搜索关键字不能为空', 'status' => 0]);
        }
        $news  = News::search($search)->orderBy($order, 'desc')->get();
        $video = Video::search($search)->orderBy($order, 'desc')->get();

        //根据权重排序
        $result = $news->merge($video)->sortByDesc(function ($value) {
            return $value->document['percent'];
        })->sortByDesc(function ($value) {
            return $value->document['weight'];
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

    }
}