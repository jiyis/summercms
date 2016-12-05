<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/8/30
 * Time: 15:07
 */

namespace App\Repository;

use App\Models\Logs;
use InfyOm\Generator\Common\BaseRepository;
use App\Contracts\LogInterface;

class LogRepository extends BaseRepository  implements LogInterface
{
    protected $columns = ['username','controller','method','action','querystring','ip','created_at'];

    public function model()
    {
        return Logs::class;
    }

    public function log($attributes)
    {
        parent::create($attributes);
    }

    public function pagination($limit, $offset, $search)
    {
        $query = Logs::select('*');
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
        $query = Logs::select('*');
        if(!empty($search)) {
            foreach ($this->columns as $column) {
                $query->orWhere($column, 'like', '%'.$search.'%');
            }
        }

        return $query->get()->toArray();
    }
}