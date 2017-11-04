<?php

namespace App\Http\Controllers;

use App\Account;
use App\Belong;
use App\Categorize;
use App\Liste;
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
        $tags = [12, 13, 14];
        $lists_full_tags = new \Illuminate\Database\Eloquent\Collection;
        foreach ($tags as $tag) {
            $list = Categorize::getByIdsTag($tag);
            $lists_full_tags = $lists_full_tags->merge($list);
        }
        return $lists_full_tags;
    }
}
