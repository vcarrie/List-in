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

        $idList_at_least_1_tag = Categorize::getByIdsTag($tags);
        $List_at_least_1_tag = array();
        foreach ($idList_at_least_1_tag as $categorize){
            $List_at_least_1_tag[] = Liste::find($categorize['idList']);
        }

        $diff = array_diff($List_at_least_1_tag, $final_lists);

        $ids_1_tag_lists = array();

        foreach ($diff as $list){

            $average = Rate::averageForList($list['id']);
            $ids_1_tag_lists[] = [$average, $list['id']];

        }

        rsort($ids_1_tag_lists);

        $sorted_ids_1_tag = array_column($ids_1_tag_lists, 1);
        $final_lists_1_tag = array();

        foreach ($sorted_ids_1_tag as $id){
            $final_lists_1_tag[] = Liste::find($id);
        }

        $final_tab_lists_sorted = array_merge($final_lists, $final_lists_1_tag);

        return $final_tab_lists_sorted;
    }
}
