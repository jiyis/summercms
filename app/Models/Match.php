<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'match';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'title', 'description', 'gid', 'status', 'default',
        ];

    public function groups()
    {
        return $this->hasMany('App\Models\MatchGroup','match_id','id');
    }

}

