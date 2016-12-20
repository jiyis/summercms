<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 9:23
 * Desc:
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'seo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seo_title', 'seo_keyword', 'seo_description','seo_type','associ_id',
    ];


}
