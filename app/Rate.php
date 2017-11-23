<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdListandListUser($idList, $idUser){
        return static::where('idList', '=', $idList)->where('idUser', '=', $idUser);
    }

    public static function getByIdUser($idUser){
        return static::where('idUser', '=', $idUser);
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

    public static function deleteRateByIdList($idList)
    {
        self::getByIdList($idList)->delete();
    }

    public static function deleteRateByIdUser($idUser)
    {
        self::getByIdUser($idUser)->delete();
    }


    public function List(){
        return $this->belongsTo('App\List', 'idList');
    }

    public function User(){
        return $this->belongsTo('App\User', 'idUser');
    }


}

