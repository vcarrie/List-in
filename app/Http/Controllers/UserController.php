<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Rate;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id){
        $user = User::find($id);

        return $user;
    }

    public function myAccount(){
        $user = Auth::user();

        $my_lists = $user->createdList();

        $to_return = array(
            $user,
            $my_lists
        );



        return view('account', compact($to_return));
    }

    public function update_logged_user(Request $request){
        $user = Auth::user();
        $user->pseudo = $request->input('');
        $user->firstName = $request->input('');
        $user->lastName = $request->input('');

        $user->save();

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
