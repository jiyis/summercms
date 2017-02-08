<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Video extends Model
{
    use Notifiable, SoftDeletes, Searchable;

    public $table = 'cms_video';

    /*public $fillable = ['title',];*/

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function getColumns()
    {
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        foreach ($columns as $column) {
            $type = $this->getConnection()->getSchemaBuilder()->getColumnType($this->getTable(), $column);
            $array[$column] = $type;
        }
        //$array = $this->toArray();
        return $array;
    }

    public function searchableAs()
    {
        return 'cms_video';
    }
}
