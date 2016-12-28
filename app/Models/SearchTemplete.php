<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class SearchTemplete extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = "search_templete";

    protected $fillable = [
        'title', 'name', 'model','layout','description','content',
    ];

    public function getModel()
    {
        return $this->belongsTo('App\Models\DataType','model','name');
    }

    public function getLayout()
    {
        return $this->belongsTo('App\Models\Layout','layout','title');
    }
}
