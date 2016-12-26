<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/26
 * Time: 14:43
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Tags;
use App\Models\TagsData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait TagsManage
{
    /**
     * 保存tags
     * @param Request $request
     * @param Model $data
     * @param $model_id
     */
    public function saveTags(Request $request, Model $data, $model_id)
    {
        foreach ($request->get('tags') as $tag) {
            $tag = Tags::updateOrCreate(['name' => $tag]);
            TagsData::create([
                'tag_id' => $tag->id,
                'data_id' => $data->id,
                'category_id' => $data->category_id,
                'model_id' => $model_id,
            ]);
            $tag->increment('num');
        }
    }

    /**
     * 更新tags
     * @param Request $request
     * @param Model $data
     * @param $model_id
     * @param $id
     */
    public function updateTags(Request $request, Model $data, $model_id, $id)
    {
        $tag_builder = TagsData::where(['category_id' => $request->get('category_id'), 'data_id' => $id]);
        $exits_tags = $tag_builder->get()->flatMap(function($item){
            return [$item->tags->name];
        })->toArray();
        if(array_diff($exits_tags, $request->get('tags'))){
            $tag_builder->forceDelete();
            $this->saveTags($request, $data, $model_id);
        }
    }
}