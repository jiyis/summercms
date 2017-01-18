<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Video extends Model
{
    use Notifiable, SoftDeletes;

    public $table = 'cms_video';

    /*public $fillable = ['title',];*/

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

}
