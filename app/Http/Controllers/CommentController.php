<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{
    public function registerComment(){

        $response = 'Le commentaire à bien été enregistré';

        $idList = Input::get('idList');
        $idUser = Auth::user()->id;
        $date = date("Y-m-d H:i:s");
        $remark = Input::get('comment');

        if (Auth::check()) {


            if (count(Rate::getByIdListandListUser($idList, $idUser)->get()) == 0) {

                $comment = new Comment();
                $comment->idList = $idList;
                $comment->idUser = $idUser;
                $comment->created_at = $date;
                $comment->remark = $remark;

                $comment->save();
            }else{
                $response = 'Vous avez deja noté cette liste';
            }


        }else{
            $response = 'Connectez-vous pour pouvoir commenter';
        }

        $to_return = array(
            'Response' => $response,
        );

        return json_encode($to_return);

    }

    public function registerRate(){


        $response = 'La note à bien été enregistrée';

        $idList = Input::get('idList');
        $idUser = Auth::user()->id;
        $rating = Input::get('rating');

        if (Auth::check()) {


            if (count(Rate::getByIdListandListUser($idList, $idUser)->get()) == 0){
                $rate = new Rate();
                $rate->idList = $idList;
                $rate->idUser = $idUser;
                $rate->rating = $rating;

                $rate->save();
            }else{
                $rate = Rate::getByIdListandListUser($idList, $idUser);
                $rate->idList = $idList;
                $rate->idUser = $idUser;
                $rate->rating = $rating;

                $rate->save();
                $response = 'Vous avez deja noté cette liste';
            }


        }else{
            $response = 'Connectez-vous pour pouvoir noter';
        }



        $to_return = array(
            'Response' => $response,
            'New_Avg' => Rate::averageForList($idList)
        );

        return json_encode($to_return);
    }
}
