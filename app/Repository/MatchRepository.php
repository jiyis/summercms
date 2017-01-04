<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/16
 * Time: 8:47
 * Desc:
 */

namespace App\Repository;


use InfyOm\Generator\Common\BaseRepository;
use App\Models\Match;

class MatchRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Match::class;
    }

    public function getAll()
    {
        $matches = $this->all();

        foreach ($matches as $match) {
            $match->old_status = $match->status;
            $match->old_default = $match->default;
            $match->status = $match->status ? '<span class="label label-primary">正常</span>':'<span class="label label-default">拉黑</span>';
            $match->default = $match->default ? '<span class="label label-info">当前赛事</span>' : '<span class="label label-default">否</span>';
        }
        return $matches;
    }

    public function gameGroups($id)
    {
        $match = $this->find($id);
    }
}