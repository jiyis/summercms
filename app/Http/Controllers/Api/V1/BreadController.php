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
use DB, Schema;

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
        $slug = $request->segment(2);
        $dataType = DataType::where('slug', '=', $slug)->first();
        $per_page = $request->get('per_page', 10);

        $limit = $request->get('limit', $per_page);
        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? call_user_func_array([$dataType->model_name, 'paginate'], [$limit])
            : DB::table($dataType->name)->paginate($limit); // If Model doest exist, get data from table name*/
        return $this->response->paginator($dataTypeContent, new BreadTransformer());

    }

    public function viewCount(Request $request, $id)
    {
        $slug = $request->segment(2);
        $dataType = DataType::where('slug', '=', $slug)->first();
        if(Schema::hasColumn($dataType->name,['view_count'])) {
            if(strlen($dataType->model_name) != 0) {
                $view_count = call_user_func_array([$dataType->model_name, 'find'], [$id,'view_count']);
            }else{
                $view_count = DB::table($dataType->name)->find($id,'view_count');
            }
            return $this->response->array($view_count);
        }else{
            return $this->response->errorNotFound();
        }

    }

    public function updateViewCount(Request $request, $id)
    {
        $slug = $request->segment(2);
        $dataType = DataType::where('slug', '=', $slug)->first();
        if(Schema::hasColumn($dataType->name,['view_count'])) {
            $view_count = DB::table($dataType->name)->where(['id' => $id])->increment('view_count');
            return $this->response->array($view_count);
        }else{
            return $this->response->errorNotFound();
        }
    }

}