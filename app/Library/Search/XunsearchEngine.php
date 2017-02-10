<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/2/6
 * Time: 11:11
 * Desc:
 */

namespace App\Library\Search;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine as Engine;
use Illuminate\Database\Eloquent\Collection;

class XunsearchEngine extends Engine
{
    private $xs;
    private $host;
    private $searchPort;
    private $indexPort;

    /**
     * XunsearchEngine constructor.
     */
    public function __construct()
    {
        $this->host       = config('xunsearch.host');
        $this->searchPort = config('xunsearch.searchport');
        $this->indexPort  = config('xunsearch.indexport');
    }

    private function hasDB($db)
    {
        return !empty(cache('xunsearch_' . $db));
    }

    private function setDB($model)
    {
        $dbconfig = [];
        if (!$this->hasDB($model->searchableAs())) {
            $dbconfig['project.name']            = $model->searchableAs();
            $dbconfig['project.default_charset'] = 'utf-8';
            $dbconfig['server.index']            = $this->indexPort;
            $dbconfig['server.search']           = $this->searchPort;
            $dbconfig                            = array_merge($dbconfig, $this->changeType($model->getColumns()));
            $dbconfig['id']                      = ['type' => 'id'];
            cache(['xunsearch_' . $dbconfig['project.name'] => $dbconfig], 60 * 24 * 7);
        } else {
            $dbconfig = cache('xunsearch_' . $model->searchableAs());
        }
        $dbconfig['id'] = ['type' => 'id'];
        $this->xs       = new \XS($dbconfig);
    }

    /**
     * Update the given model in the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     * @throws \XSException
     * @return void
     */
    public function update($models)
    {
        $this->setDB($models->first());
        $index = $this->xs->index;
        $models->map(function ($model) use ($index) {
            $array = $model->toSearchableArray();
            if (empty($array)) {
                return;
            }
            $array['id'] = $model->getKey();
            $doc         = new \XSDocument;
            $doc->setFields($array);
            $index->update($doc);
        });
        $index->flushIndex();
    }

    /**
     * Remove the given model from the index.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $models
     * @return void
     */
    public function delete($models)
    {
        $this->setDB($models->first());
        $index = $this->xs->index;
        $models->map(function ($model) use ($index) {
            $index->del($model->getKey());
        });
        $index->flushIndex();
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder $builder
     * @return mixed
     */
    public function search(Builder $builder)
    {
        return $this->performSearch($builder, array_filter([
            'hitsPerPage' => $builder->limit,
        ]));
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder $builder
     * @param  int $perPage
     * @param  int $page
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        return $this->performSearch($builder, [
            'hitsPerPage' => $perPage,
            'page'        => $page - 1,
        ]);
    }

    /**
     * Perform the given search on the engine.
     *
     * @param  \Laravel\Scout\Builder $builder
     * @param  array $options
     * @return mixed
     */
    protected function performSearch(Builder $builder, array $options = [])
    {
        $this->setDB($builder->model);
        $search = $this->xs->search;

        if ($builder->callback) {
            return call_user_func(
                $builder->callback,
                $search,
                $builder->query,
                $options
            );
        }
        $search->setFuzzy()->setQuery($builder->query);
        collect($builder->wheres)->map(function ($value, $key) use ($search) {
            $search->addRange($key, $value, $value);
        });

        $offset  = 0;
        $perPage = $options['hitsPerPage'];
        if (!empty($options['page'])) {
            $offset = $perPage * $options['page'];
        }
        return $search->setLimit($perPage, $offset)->search();
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  mixed $results
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function map($results, $model)
    {
        if (count($results) === 0) {
            return Collection::make();
        }
        $keys   = collect($results)
            ->pluck('id')->values()->all();
        $models = $model->whereIn(
            $model->getQualifiedKeyName(), $keys
        )->get()->keyBy($model->getKeyName());
        return Collection::make($results)->map(function ($hit) use ($model, $models) {
            $key = $hit['id'];
            if (isset($models[$key])) {
                $models[$key]->document = [
                    'docid'   => $hit->docid(),
                    'percent' => $hit->percent(),
                    'rank'    => $hit->rank(),
                    'weight'  => $hit->weight(),
                    'ccount'  => $hit->ccount(),
                ];
                return $models[$key];
            }
        })->filter();
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  mixed $results
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function mapIds($results)
    {
        return collect($results['hits'])->pluck('id')->values();
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param  mixed $results
     * @return int
     */
    public function getTotalCount($results)
    {
        return count($results);
    }

    /**
     * 根据xunsearch的配置项规范，动态生成
     * @param $attrs
     * @return mixed
     */
    public function changeType($attrs)
    {
        $titleMark = false;
        foreach ($attrs as $value => $type) {
            if (in_array($value, ['updated_at', 'deleted_at'])) continue;
            switch ($type) {
                case 'integer' :
                case 'double' :
                    $array = ['type' => 'numeric'];
                    break;
                case 'string' :
                    $array = ['type' => 'string', 'index' => 'both', 'weight' => 3];
                    if (!$titleMark) {
                        $array     = ['type' => 'title', 'weight' => 10];
                        $titleMark = true;
                    }
                    break;
                case 'text' :
                    $array = ['type' => 'body', 'weight' => 1];
                    break;
                case 'datetime' :
                    $array = ['type' => 'numeric', 'weight' => 0];
                    break;
            }
            $dbconfig[$value] = $array;
        }
        return $dbconfig;
    }

    /**
     * 获取xunsearch的实例
     * @return mixed
     */
    public function getXunsearch()
    {
        return $this->xs;
    }
}