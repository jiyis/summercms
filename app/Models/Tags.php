<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/26
 * Time: 13:14
 * Desc:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Tags extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'tags';

    protected $fillable = ['name', 'num'];

    public function category()
    {
        return $this->belongsToMany('App\Models\Category','tags_data','tag_id','catagory_id');
    }

}