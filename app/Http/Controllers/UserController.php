<?php

namespace App\Http\Controllers;

use App\Belong;
use App\Comment;
use App\Rate;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);

        return $user;
    }

    public function myAccount(ApiCdiscountSearchByIdProductRepository $api){
        $user = Auth::user();

        $my_lists = $user->createdList()->get();
        $complete_lists = array();

        $to_return = array(
            $user,
        );
        foreach ($my_lists as $list){
            $products = Belong::getProductsByIdList($list['id'], $api);
            $complete_lists[] = array($list, $products);

        }
        $to_return[] = $complete_lists;


        return view('account', compact('to_return'));
    }


    public function deleteUser($id){

        $user = User::find($id);
        Rate::deleteRateByIdUser($id);
        Comment::deleteCommentByIdUser($id);

        $list = new ListController();

        foreach ($user->createdList as $lists){
            $idList = $lists->id;
            $list->deleteList($idList);
        };

        $user->delete();

    }
}
