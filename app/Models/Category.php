<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Category extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'cms_category';

    protected $fillable = [
        'parent_id','title', 'url', 'model','template','description','order',
    ];

    /*public function posts()
    {
        return $this->hasMany(Post::class)
            ->where('status', '=', 'PUBLISHED')
            ->orderBy('created_at', 'DESC');
    }*/
}
