<?php

namespace App\Http\Controllers;

use App\Belong;
use App\Categorize;
use App\Liste;
use App\Rate;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
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

    public function struct()
    {
        return view('include.catalogue-struct');
    }

    public function research(ApiCdiscountSearchByIdProductRepository $apiCdiscountSearchByIdProduct)
    {

        $tags = Input::get('tags');
        $sort_index = Input::get('sort');
        $all_lists_by_nb_tags = Categorize::getIdListsByNumberOfTags($tags)->get();

        $tab_to_return = array();
        $nbLists = count($all_lists_by_nb_tags);


        for ($i = 0; $i < $nbLists; $i++) {

            $list = $all_lists_by_nb_tags[$i];
            $idList = $list->idList;

            $theList = Liste::find($idList);

            $theBelong = Belong::getProductsByIdList($idList, $apiCdiscountSearchByIdProduct);
            $price = $theBelong[1];


            if (Rate::averageForList($idList) != 0) {
                $avg = Rate::averageForList($idList);
            } else {
                $avg = 0;
            }


            $tab_to_return['lists'][] = [
                'list' => $theList,
                'products' => $theBelong[0],
                'rating' => round($avg / 5, 2),
                'nb_products' => count($theBelong[0]),
                'total_price' => round($price, 2),
            ];

        }

        dd(\Log::info($tab_to_return['lists'][0]['rating']));

        switch ($sort_index) {
            case 0://rating
                sort($tab_to_return['lists']['rating']);
                break;

            case 1://prix croissant
                rsort($tab_to_return['lists']['total_price']);
                break;

            case 2://prix decroissant
                sort($tab_to_return['lists']['total_price']);
                break;
        }

        $tab_to_return['nb_list_total'] = count($tab_to_return['lists']);


        return $tab_to_return;
    }
}
