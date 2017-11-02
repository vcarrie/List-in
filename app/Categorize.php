<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Categorize extends Model
{
    public static function getByIdList($idList){
        return static::where('idList', '=', $idList);
    }

    public static function getByIdTag($idTag){
        return static::where('$idTag', '=', $idTag);
    }

    public static function most_used_tags(){
        $popular_Tags = Categorize::all()->groupBy('idTag');
        $popular = array();
        foreach ($popular_Tags as $group){
            $popular[] = array(count($group), $group[0]['idTag']);
        }
        rsort($popular);
        return $popular;
    }

    public static function top_5_most_used_tags(){

        $popular_tags = Categorize::all()->groupBy('idTag');
        $popular = array();

        foreach ($popular_tags as $group){
            $popular[] = array(count($group), $group[0]['idTag']);
        }
        rsort($popular);

        $ids_most_used = array();
        for ($i = 0;$i<5;$i++){
            $ids_most_used[] = $popular[$i][1];
        }

        return $ids_most_used;
    }
}
