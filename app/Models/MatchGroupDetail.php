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

class MatchGroupDetail extends Model
{

    use Notifiable, SoftDeletes;

    protected $table = 'match_group_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id','team_id_a', 'team_id_b', 'score_a','score_b','starttime','endtime','link','status','default',
    ];

    /**
     * 应该被转化为原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'score_a' => 'integer',
        'score_b' => 'integer',
    ];

    public function teamA()
    {
        return $this->belongsTo('App\Models\Team', 'team_id_a', 'id');
    }

    public function teamB()
    {
        return $this->belongsTo('App\Models\Team', 'team_id_b', 'id');
    }

}