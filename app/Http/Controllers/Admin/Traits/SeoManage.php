<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 9:15
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Seo;

trait SeoManage
{
    /**
     * 更新或者新建seo信息
     * @param array $data
     * @param string $id
     * @throws
     */
    public function saveSeo(array $data, $id = '')
    {
        if(empty($data) || !is_array($data) || empty($id)) throw new \Exception('数据为空');
        $data['associ_id'] = $id;
        return Seo::updateOrCreate(['associ_id'=>$id,'seo_type'=>$data['seo_type']],$data);
    }

    /**
     * 获取seo信息
     * @param $data
     * @param string $seo_type
     * @return bool
     */
    public function getSeo($data, $seo_type = 'page')
    {
        if(empty($data)) return false;
        $seo =  Seo::where(['associ_id'=>$data->id, 'seo_type'=>$seo_type])->first();
        if(is_null($seo)) return $data;
        $data->seo_title = $seo->seo_title;
        $data->seo_keyword = $seo->seo_keyword;
        $data->seo_description = $seo->seo_description;
        return $data;
    }
}
