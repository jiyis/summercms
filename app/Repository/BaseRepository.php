<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 17-11-14
 * Time: 上午10:41
 * Desc:
 */

namespace App\Repository;

use Prettus\Repository\Eloquent\BaseRepository as l5Repository;

abstract class BaseRepository extends l5Repository
{
    public function findWithoutFail($id, $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (Exception $e) {
            return;
        }
    }

}