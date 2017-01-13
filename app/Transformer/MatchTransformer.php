<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:12
 * Desc:
 */

namespace App\Transformer;


use App\Models\Match;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class MatchTransformer extends TransformerAbstract
{

    public function transform(Match $match)
    {

        return  [
            'id'  => (int)$match->id,
            'title'  => $match->title,
            'groupCount'  => $match->groups->count(),
            'default'  => $match->default,
            'groups' => $match->groups->transform(function ($item) {
                return [
                    'title' => $item->name,
                    'matchCount' => $item->details->count(),
                    'default'  =>  $item->default,
                    'matchs' => $item->details->transform(function ($value) {
                        return [
                            'time' => $value->starttime,
                            'teamA' => $value->teamA->name,
                            'teamAimg' => $value->teamA->logo,
                            'teamB' => $value->teamB->name,
                            'teamBimg' => $value->teamB->logo,
                            'grade' => $value->score_a.':'.$value->score_b,
                            'isOff' => $this->checkOff($value->endtime),
                            'link' => $value->link,
                            'default'  => $value->default,
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
        dd($arr);

    }


    private function checkOff($time, $status = 1)
    {
        if(Carbon::parse($time)->diffInMinutes(Carbon::now()) >= 0) {
            return true;
        }else{
            return false;
        }
    }
}