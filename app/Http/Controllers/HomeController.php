<?php

namespace App\Http\Controllers;

use App\Account;
use App\Belong;
use App\Categorize;
use App\Liste;
use App\Rate;
use Illuminate\Http\Request;
use App\Tag;


class HomeController extends Controller
{
    public function index(){

        $top_5_ids = Categorize::top_5_most_used_tags();

        $tags_final_tab = Tag::getByIdsTag($top_5_ids);

        return view('catalogue', compact('tags_final_tab'));
    }

    public function research(){
        $tags = [14, 13];

        $nb_list = 0;


        $intersect = Tag::find($tags[0])->lists;
        foreach ($tags as $tag){
           $intersect = $intersect->intersect(Tag::find($tag)->lists);
        }

        $list_id = $intersect->pluck('id');
        $sorted_lists = array();

        foreach ($list_id as $id) {

            $average = Rate::averageForList($id);
            $sorted_lists[] = [$average, $id];
        }

        rsort($sorted_lists);

        $sorted_ids = array_column($sorted_lists, 1);
        $final_lists = array();


        foreach ($sorted_ids as $id){
            $final_lists[] = Liste::find($id);
        }


        return $final_lists;
    }
}
