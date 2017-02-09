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
        $url = $model->getCategory->url;
        return [
            //'id' => (int)$model->id,
            'title'       => $model->title,
            'type'        => $this->getTypeName($url),
            'titleurl'    => '/' . trim($url, '/') . '/' . $model->id, //结果连接
            'description' => $model->description,
            'content'     => $model->content,
            'created_at'  => $model->created_at->toDateString(),
        ];
    }

    private function getTypeName($url)
    {
        switch ($url){
            case 'news' :
                $type = '新闻';
                break;
            case 'video' :
                $type = '视频';
                break;
            default :
                $type = '视频';
        }
        return $type;
    }
}