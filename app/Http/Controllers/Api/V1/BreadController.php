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
use DB;

class BreadController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $slug = $request->segment(2);
        $dataType = DataType::where('slug', '=', $slug)->first();
        $limit = $request->get('limit', 10);
        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? call_user_func_array([$dataType->model_name, 'paginate'], [$limit])
            : DB::table($dataType->name)->paginate($limit); // If Model doest exist, get data from table name*/
        return $this->response->paginator($dataTypeContent, new BreadTransformer());


    }

}