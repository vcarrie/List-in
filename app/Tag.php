<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public static function getByIdsTag($array_ids){
        return static::all()->whereIn('id', $array_ids);
    }

    public function lists(){
        return $this->belongsToMany('App\Liste', 'categorizes', 'idTag', 'idList');
    }


}
