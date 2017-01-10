<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/16
 * Time: 8:47
 * Desc:
 */

namespace App\Repository;


use App\Models\ApplyCategory;
use InfyOm\Generator\Common\BaseRepository;
use Overtrue\Pinyin\Pinyin;

class ApplyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApplyCategory::class;
    }

    public function save(array $data, $id = '')
    {
        $pinyin = new Pinyin();
        $data = collect($data);
        $mapping = $data->flatMap(function($values) use($pinyin) {
            if(is_array($values)) return array_map(function ($v) use($pinyin) {
                return [$pinyin->permalink($v, '') => $v];
            }, $values);
        })->collapse();
        $data->put('mapping', json_encode($mapping));
        $data = $data->transform(function($item){
            if(is_array($item)) $item = implode('||',$item);
            return $item;
        })->toArray();
        $data['url'] = '/' . trim($data['url'], '/') . '/';
        if(empty($id)) return parent::create($data);
        return parent::update($data, $id);
    }



}