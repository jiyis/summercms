<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/4
 * Time: 14:08
 * Desc:
 */

namespace App\Http\Requests\Admin;


class MatchRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required|max:50||alpha_dash',
            'gid' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '赛事名称不能为空',
            'title.alpha_dash' => '赛事名称仅允许字母、数字、破折号（-）以及底线（_）',
            'gid.required' => '所属游戏不能为空',

        ];
    }
}