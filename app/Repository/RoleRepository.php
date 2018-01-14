<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 17-11-14
 * Time: 上午10:07
 * Desc:
 */

namespace App\Repository;

use App\Models\Role;



class RoleRepository extends BaseRepository
{

    public function model()
    {
        return Role::class;
    }

    /**
     * delete role
     * @param $id
     * @return bool|int
     */
    public function delete($id)
    {
        $role = $this->model->find($id);
        if(!$role) {
            return false;
        }
        $role->users()->detach();
        return parent::delete($id);
    }

    /**
     * save role permissions
     * @param $id
     * @param array $perms
     * @return bool
     */
    public function savePermissions($id, $perms = [])
    {
        $role = $this->model->find($id);
        $role->permissions()->sync($perms);
        //$result = $role->givePermissionTo($perms);
        //$role->perms()->sync($perms);

        return true;
    }

    /**
     * get role's permissions
     * @param $id
     * @return array
     */
    public function rolePermissions($id)
    {
        $perms = [];
        $permissions = $this->model->find($id)->permissions()->get();

        foreach ($permissions as $item) {
            $perms[$item->id] = $item->name;
        }

        return $perms;
    }
}