<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/8/30
 * Time: 15:00
 */

namespace App\Repository;

use App\Models\AdminLogs;
use InfyOm\Generator\Common\BaseRepository;
use App\Contracts\LogInterface;

class AdminLogRepository extends BaseRepository implements LogInterface
{
    protected $columns = ['username','httpuseragent','sessionid','action','ip','created_at'];

    public function model()
    {
        return AdminLogs::class;
    }

    public function log($attributes)
    {
        parent::create($attributes);
    }

    public function pagination($limit, $offset, $search)
    {
        $query = AdminLogs::select('*');
        if(!empty($search)) {
            foreach ($this->columns as $column) {
                $query->orWhere($column, 'like', '%'.$search.'%');
            }
        }

        return $query->limit($limit)->offset($offset)->orderBy('created_at', 'desc')->get()->toArray();
    }

    public function search($search)
    {
        if(empty($search)){
            return parent::all();
        }
        $query = AdminLogs::select('*');
        if(!empty($search)) {
            foreach ($this->columns as $column) {
                $query->orWhere($column, 'like', '%'.$search.'%');
            }
        }

        return $query->get()->toArray();
    }
}