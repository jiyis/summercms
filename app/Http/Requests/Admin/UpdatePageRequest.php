<?php

/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/1
 * Time: 17:48
 */

namespace App\Http\Requests\Admin;


class UpdatePageRequest extends Request
{

    public function rules()
    {
        return [
            'title' => 'required|max:50',
            'url' => 'required',
            'file_name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'published' => 'required',
            'seo_title' => 'required',
            'seo_keyword' => 'required',
            'seo_description' => 'required',
            'seo_type' => 'required',
            'layout' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'url.required' => '页面地址不能为空',
            'file_name.required' => '文件名称不能为空',
            'description.required' => '页面描述不能为空',
            'content.required' => '页面内容不能为空',
            'published.required' => '发布状态不能为空',
            'layout.required' => '页面布局不能为空',
        ];
    }
}
