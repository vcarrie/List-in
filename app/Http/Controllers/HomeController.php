<?php

namespace App\Http\Controllers;

use App\User;
use App\Belong;
use App\Categorize;
use App\Liste;
use App\Rate;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Input;


class HomeController extends Controller
{
    public function index()
    {

        $top_5_ids = Categorize::top_5_most_used_tags();

        $tags_final_tab = Tag::getByIdsTag($top_5_ids);

        return view('catalogue', compact('tags_final_tab'));
    }

    public function research(Request $request, ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct)
    {

        ////////////////////////////////////Params received from request
        $tags = Input::get('tags');

        $pagination = Input::get('pagination');

        $sort_index = Input::get('sort_index');


        ////////////////////////////////////




        $all_lists_by_nb_tags = Categorize::getIdListsByNumberOfTags($tags)->get();

        $sorted_lists = array();
        switch ($sort_index){
            case 0://rating

                foreach ($all_lists_by_nb_tags as $list) {
                    $sorted_lists[] = [$list['NbTag'], Rate::averageForList($list['idList']), $list['idList']];
                }

                rsort($sorted_lists);
                break;

            case 1://prix croissant
                foreach ($all_lists_by_nb_tags as $list) {
                    $sorted_lists[] = [$list['NbTag'], Belong::getTotalByIdList($list['idList'], $apiCdiscountSearchByIdProduct),  $list['idList']];
                }

                sort($sorted_lists);
                break;

            case 2://prix decroissant
                foreach ($all_lists_by_nb_tags as $list) {
                    $sorted_lists[] = [$list['NbTag'], Belong::getTotalByIdList($list['idList'], $apiCdiscountSearchByIdProduct),  $list['idList']];
                }

                rsort($sorted_lists);
                break;
        }


        $tab_to_return = array();

        for ($i = 0; $i < 4; $i++) {
            if (isset($sorted_lists[$pagination * 4 + $i])) {
                $theList = Liste::find($sorted_lists[$pagination * 4 + $i][2]);
                $theBelong = Belong::getProductsByIdList($sorted_lists[$pagination * 4 + $i][2], $apiCdiscountSearchByIdProduct);
                $total = Belong::getTotalByIdList($sorted_lists[$pagination * 4 + $i][2],  $apiCdiscountSearchByIdProduct);
                $tab_to_return[] = [
                    'list' => $theList,
                    'products'=> $theBelong,
                    'avg' => $sorted_lists[$pagination * 4 + $i][1],
                    'nb_products' => count($theBelong),
                    'total' => $total

                ];
            }
        }

        return $tab_to_return;

    }


}
