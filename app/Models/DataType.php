<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DataType extends Model
{
    protected $table = 'data_types';

    protected $fillable = [
        'name', 'slug', 'display_name_singular', 'display_name_plural', 'icon', 'model_name', 'description',
    ];

    /**
     * 过滤掉menu模型
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('id', function(Builder $builder) {
            $builder->where('id', '>', 1);
        });
    }

    public function rows()
    {
        return $this->hasMany(DataRow::class);
    }

    public function browseRows()
    {
        return $this->rows()->where('browse', '=', 1)->orderByRaw($this->getColumns());
    }

    public function readRows()
    {
        return $this->rows()->where('read', '=', 1)->orderByRaw($this->getColumns());
    }

    public function editRows()
    {
        return $this->rows()->where('edit', '=', 1)->orderByRaw($this->getColumns());
    }

    public function addRows()
    {
        return $this->rows()->where('add', '=', 1)->orderByRaw($this->getColumns());
    }

    public function deleteRows()
    {
        return $this->rows()->where('delete', '=', 1)->orderByRaw($this->getColumns());
    }

    private function getColumns()
    {
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->name);
        $columns = collect($columns)->transform(function ($item) {
            return "'" . $item . "'";
        })->implode(',');

        return \DB::raw('FIELD(field, '.$columns.')');
    }
}
