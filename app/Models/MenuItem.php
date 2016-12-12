<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'cms_menu_items';

    protected $fillable = [
        'menu_id', 'title', 'url', 'target', 'icon', 'parent_id', 'color', 'order',
    ];
}
