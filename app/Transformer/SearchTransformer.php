<?php
/**
 * Created by Gary.F.Dong.
 * Date: 2016/12/25
 * Time: 15:35
 * Desc：
 */

namespace App\Transformer;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class SearchTransformer extends TransformerAbstract
{
    public function transform(Model $model)
    {
        return [
            //'id' => (int)$model->id,
            'title'       => $model->title,
            'titleurl'    => '/' . trim($model->getCategory->url, '/') . '/' . $model->id, //结果连接
            'description' => $model->description,
            'content'     => $model->content,
            'created_at'  => $model->created_at->toDateString(),
        ];
    }
}