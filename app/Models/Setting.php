<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'settings';

    public $fillable = [
        'key',
        'display_name',
        'value',
        'details',
        'type',
        'order',
    ];
}
