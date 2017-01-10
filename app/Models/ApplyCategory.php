<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/4
 * Time: 10:38
 * Desc:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class ApplyCategory extends Model
{

    use Notifiable, SoftDeletes;

    protected $table = 'apply_category';


    public $fillable = [
        'title',
        'url',
        'layout',
        'description',
        'deadline',
        'row',
        'column',
        'mapping',
        'area',
        'gid',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\ApplyUser', 'cid', 'id');
    }

    public function getLayout()
    {
        return $this->belongsTo('App\Models\Layout', 'layout', 'title');
    }

}