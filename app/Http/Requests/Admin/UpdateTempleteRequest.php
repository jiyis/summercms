<?php

/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/1
 * Time: 17:48
 */
namespace App\Http\Requests\Admin;


class UpdateTempleteRequest extends Request
{

    public function rules()
    {
        return [
            'title' => 'required|max:50|alpha_dash',
            'name' => 'required',
            'model' => 'required',
            //'description' => 'required',
            'list' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'title.alpha_dash' => '标题仅允许字母、数字、破折号（-）以及底线（_）',
            'name.required' => '中文标识不能为空',
            'model.required' => '所属模型不能为空',
            //'description.required' => '布局描述不能为空',
            'list.required' => '列表模版不能为空',
            'content.required' => '内容模版不能为空',
            //'default.required' => '发布状态不能为空',

        ];
    }
}
