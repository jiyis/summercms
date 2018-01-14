<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 17-11-14
 * Time: 上午10:08
 * Desc:
 */

namespace App\Repository;

use App\Models\Permission;


class PermissionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    public function topPermissions()
    {
        return $this->model->where('fid', 0)->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();
    }

}