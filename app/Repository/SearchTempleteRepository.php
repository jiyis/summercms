<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/21
 * Time: 10:42
 * Desc:
 */

namespace App\Repository;


use App\Models\SearchTemplete;
use InfyOm\Generator\Common\BaseRepository;

class SearchTempleteRepository extends BaseRepository
{

    public function model()
    {
        return SearchTemplete::class;
    }

}