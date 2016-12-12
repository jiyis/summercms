<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logs extends Model
{
    use SoftDeletes;

    public $table = 'logs';

    public $fillable = [
        'userid',
        'username',
        'httpuseragent',
        'sessionid',
        'ip'
    ];


}
