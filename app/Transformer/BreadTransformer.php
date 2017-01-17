<?php
/**
 * Created by Gary.F.Dong.
 * Date: 2016/12/25
 * Time: 15:35
 * Desc：
 */

namespace App\Transformer;

use App\Models\DataRow;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use App\Models\DataType;

class BreadTransformer extends TransformerAbstract
{
    public function transform(Model $dataType)
    {
        $data_type_id = DataType::where(['name' => $dataType->getTable()])->pluck('id')->first();
        $fields = DataRow::where(['data_type_id' => $data_type_id, 'read' => 1])->pluck('field')->toArray();
        $data['id'] = $dataType->id;
        foreach ($fields as $key => $value) {
            $res = $dataType->$value;
            if($dataType->$value instanceof Carbon) $res = $dataType->$value->toDateTimeString();
            $data[$value] = $res;
        }

        return $data;
    }
}