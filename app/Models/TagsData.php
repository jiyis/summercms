<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/26
 * Time: 13:51
 * Desc:
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class TagsData extends Model
{
    use Notifiable;

    protected $table = "tags_data";

    protected $fillable = ['tag_id','data_id','category_id','model_id'];

    public function tags()
    {
        return $this->belongsTo('App\Models\Tags', 'tag_id', 'id');
    }

}