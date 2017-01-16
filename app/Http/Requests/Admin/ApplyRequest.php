<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/4
 * Time: 14:08
 * Desc:
 */

namespace App\Http\Requests\Admin;


class ApplyRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required|max:50',
            //'url' => 'required||alpha_dash',
            'description' => 'required',
            'deadline' => 'required',
            'row' => 'required',
            'column' => 'required',
            'area' => 'required',
            'gid' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            //'url.alpha_dash' => '报名网址仅允许字母、数字、破折号（-）以及底线（_）',
            'url.required' => '报名网址不能为空',

            'description.required' => '简介不能为空',
            'deadline.gid' => '截止时间不能为空',
            'row.gid' => '报名人员不能为空',
            'column.gid' => '收集信息不能为空',
            'area.gid' => '赛事区域不能为空',
            'gid.gid' => '所属游戏不能为空',

        ];
    }
}