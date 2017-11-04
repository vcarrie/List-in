<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdAccount($idAccount){
        return static::where('idAccount', '=', $idAccount);
    }

    public static function averageForList($id){
        $all_rates = Rate::getByIdList($id)->get();
        $cumul = 0;

        foreach ($all_rates as $rate){
            $cumul += $rate->rating;
        }
        if (count($all_rates)!=0){
            $cumul /= count($all_rates);
        }else{
            $cumul = null;
        }

        return $cumul;
    }
}
