<?php

namespace App\Http\Controllers;

use App\Belong;
use App\Categorize;
use App\Comment;
use App\Rate;

class DeleteController extends Controller
{
    public function deleteRate($id){
        Rate::deleteRateByIdList($id);
    }

    public function deleteComment($id){
        Comment::deleteCommentByIdList($id);
    }

    public function deleteCategorize($id){
        Categorize::deleteCategorizeByIdList($id);
    }

    public function deleteBelong($id){
        Belong::deleteProductbyIdList($id);
    }
}
