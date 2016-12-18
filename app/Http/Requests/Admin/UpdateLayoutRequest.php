<?php

/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/1
 * Time: 17:48
 */

namespace App\Http\Requests\Admin;


class UpdateLayoutRequest extends Request
{

    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'name' => 'required',
            //'theme' => 'required',
            'description' => 'required',
            'content' => 'required',
            //'default' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'name.required' => '布局地址不能为空',
            'theme.required' => '主题不能为空',
            'description.required' => '布局描述不能为空',
            'content.required' => '布局内容不能为空',
            //'default.required' => '发布状态不能为空',

        ];
    }
}
