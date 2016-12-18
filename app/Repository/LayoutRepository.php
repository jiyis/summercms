<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/16
 * Time: 8:47
 * Desc:
 */

namespace App\Repository;

use InfyOm\Generator\Common\BaseRepository;
use App\Models\Layout;

class LayoutRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Layout::class;
    }

}