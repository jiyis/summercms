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
use App\Models\Team;

class TeamRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Team::class;
    }

    public function getTeamsByCountry()
    {
        $teams = $this->all();

        $idrows = array_column($teams->toArray(),'nationality');
        $countrys = \App\Models\Flag::whereIn('id',$idrows)->get()->toArray();

        foreach ($countrys as $index => $country) {
            $countrys[$country['id']] = $country;
        }
        foreach ($teams as $team) {
            $team->nationality = $countrys[$team->nationality]['name'];
            $team->status = $team->status ? '<span class="label label-primary">正常</span>':'<span class="label label-default">拉黑</span>';
        }
        return $teams;

    }

}