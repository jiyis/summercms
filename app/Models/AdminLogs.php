<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminLogs extends Model
{
    use SoftDeletes;

    public $table = 'admin_logs';

    public $fillable = [
        'userid',
        'username',
        'httpuseragent',
        'sessionid',
        'ip'
    ];


}
