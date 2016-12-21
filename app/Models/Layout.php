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
use Illuminate\Database\Eloquent\SoftDeletes;

class Layout extends Model
{
    use SoftDeletes;

    public $table = 'layout';

    public $fillable = [
        'title',
        'name',
        'file_name',
        'description',
        'default',
        'content',
    ];

}
