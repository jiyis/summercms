<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/4
 * Time: 16:59
 * Desc:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MatchGroup extends Model
{

    use Notifiable, SoftDeletes;

    protected $table = 'match_group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'match_id', 'name', 'description','default',
    ];

    public function details()
    {
        return $this->hasMany('App\Models\MatchGroupDetail', 'group_id', 'id');
    }
}