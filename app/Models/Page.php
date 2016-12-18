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

class Page extends Model
{
    use SoftDeletes;

    public $table = 'page';

    public $fillable = [
        'title',
        'url',
        'file_name',
        'description',
        'layout',
        'published',
        'content',
    ];

}
