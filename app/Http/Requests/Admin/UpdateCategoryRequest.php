<?php

/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/1
 * Time: 17:48
 */
namespace App\Http\Requests\Admin;


class UpdateCategoryRequest extends Request
{

    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'url' => 'required',
            'model' => 'required',
            'description' => 'required',
            'template' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'url.required' => '页面地址不能为空',
            'file_name.required' => '文件名称不能为空',
            'description.required' => '页面描述不能为空',
            'model.required' => '所属模型不能为空',
            'template.required' => '所属模版不能为空',

        ];
    }
}
