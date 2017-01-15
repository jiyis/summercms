<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Partial extends Model
{
    use SoftDeletes, Notifiable;

    public $table = 'partial';

    public $fillable = [
        'title',
        'name',
        'group',
        'content',
        'order',
    ];
}
