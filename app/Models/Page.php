<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/16
 * Time: 8:48
 * Desc:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use SoftDeletes;

    public $table = 'page';

    public $fillable = [
        'controller',
        'action',
        'querystring',
        'userid',
        'username',
        'ip',
        'method',
    ];

}