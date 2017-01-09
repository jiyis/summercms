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

class ApplyUser extends Model
{

    use Notifiable, SoftDeletes;

    protected $table = 'apply_user';

    public $fillable = [
        'name',
        'area',
        'team',
        'cid',
        'content',
        'ip',
    ];

}