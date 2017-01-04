<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/4
 * Time: 14:08
 * Desc:
 */

namespace App\Http\Requests\Admin;


class TeamRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:50||alpha_dash',
            'logo' => 'required',
            'gid' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '标题不能为空',
            'name.alpha_dash' => '用户仅允许字母、数字、破折号（-）以及底线（_）',
            'logo.required' => '战队队标不能为空',
            'logo.gid' => '战队组别不能为空',

        ];
    }
}