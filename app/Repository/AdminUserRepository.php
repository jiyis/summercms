<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 17-11-13
 * Time: 下午2:32
 * Desc:
 */

namespace App\Repository;


use App\Models\AdminUser;


class AdminUserRepository extends BaseRepository
{

    public function model()
    {
        return AdminUser::class;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $user = parent::create($attributes);
        if($user->id){
            $roles = array_get($attributes, 'roles');
            $user->assignRole($roles);
            //$this->model->find($user->id)->attachRoles($roles);
        }
        return $user;
    }

    public function update(array $attributes, $id)
    {
        $isAble = $this->model->where('id', '<>', $id)->where('name', $attributes['name'])->count();
        if($isAble) {
            return [
                'status' => 0,
                'msg' => '用户名已被使用'
            ];
        }

        $isAble = $this->model->where('id', '<>', $id)->where('email', $attributes['email'])->count();
        if($isAble) {
            return [
                'status' => 0,
                'msg' => '邮箱已被使用'
            ];
        }
        if(empty($attributes['password'])) unset($attributes['password']);
        $user = parent::update($attributes, $id);


        if (!empty($attributes['roles'])) {
            $user->syncRoles($attributes['roles']);
        }
        else {
            $user->syncRoles([]);
        }

        //$this->model->find($id)->roles()->detach();
        /*if(isset($attributes['roles'])) {
            $this->model->find($id)->attachRoles($attributes['roles']);
        }*/
        return true;
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        if(!$user) {
            return false;
        }
        $user->roles()->detach();
        return parent::delete($id);
    }

}