<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:12
 * Desc:
 */

namespace App\Transformer;


use App\Models\Page;
use League\Fractal\TransformerAbstract;

class PageTransformer extends TransformerAbstract
{
    public function transform(Page $page)
    {
        return [
            'id'      => (int) $page->id,
            'title'   => $page->title,
            'url' => $page->url,
            'description' => $page->description,
            'content' => $page->content,
            'layout' => $page->layout,
            'published' => $page->published,
            'version' => $page->version,
            'created_at' => $page->created_at->toDateTimeString(),
        ];
    }

}