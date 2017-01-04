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
        'tid_a', 'tid_b', 'score_a','score_b','starttime','endtime','link','status','default',
    ];

}