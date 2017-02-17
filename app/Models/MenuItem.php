<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'menu_id', 'title', 'url', 'urltype', 'target', 'parent_id', 'order',
    ];
}
