<?php

/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/1
 * Time: 17:48
 */
namespace App\Http\Requests\Admin;


class CreateSettingRequest extends Request
{

    public function rules()
    {
        return [
            'key' => 'required|max:50||alpha_dash',
            'display_name' => 'required',
            //'description' => 'required',
            //'value' => 'required',
            //'details' => 'required',
            //'type' => 'required',
            //'order' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'key.required' => '标题不能为空',
            'key.alpha_dash' => '用户仅允许字母、数字、破折号（-）以及底线（_）',
            'display_name.required' => '页面地址不能为空',
            //'description.required' => '页面描述不能为空',
            //'value.required' => '页面内容不能为空',

        ];
    }
}
