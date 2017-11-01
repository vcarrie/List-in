<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liste;
use App\Belong;

class ListController extends Controller
{

    public function getListsByIdAccount($id){
        $lists = Liste::getByIdCreator($id)->get();
        return $lists;
    }

    public function getAllLists(){
        $lists = Liste::all()->toJson();
        return $lists;
    }

    public function getListById($id){
        $list = Liste::getByIdList($id)->get();//Contains all the list's attributes
        $Products = Belong::getByIdList($id)->get();//Contains all the associated products ids

        return $Products;
    }

}
