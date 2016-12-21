<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Templete extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "templete";

    protected $fillable = [
        'title', 'name', 'model','layout','description','list','content',
    ];

    public function getModel()
    {
        return $this->belongsTo('App\Models\DataType','model','name');
    }
}
