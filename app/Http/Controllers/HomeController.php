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

        $sorted_lists = array();
        switch ($sort_index){
            case 0://rating

                foreach ($all_lists_by_nb_tags as $list) {
                    $sorted_lists[] = [$list['NbTag'], Rate::averageForList($list['idList']), $list['idList']];
                }
                break;

            case 1://prix croissant
                foreach ($all_lists_by_nb_tags as $list) {
                    $sorted_lists[] = [$list['NbTag'], Belong::getTotalByIdList($list['idList'], $apiCdiscountSearchByIdProduct),  $list['idList']];
                }
                break;

            case 2://prix decroissant
                foreach ($all_lists_by_nb_tags as $list) {
                    $sorted_lists[] = [$list['NbTag'], Belong::getTotalByIdList($list['idList'], $apiCdiscountSearchByIdProduct),  $list['idList']];
                }
                break;
        }

        rsort($sorted_lists);
        $tab_to_return = array();
        $sorted_lists_length = count($sorted_lists);

        for ($i = 0; $i < $sorted_lists_length; $i++) {
            
            $idList = $sorted_lists[$i][2];

            $theList = Liste::find($idList);
            $theBelong = Belong::getProductsByIdList($idList, $apiCdiscountSearchByIdProduct);
            $total = Belong::getTotalByIdList($idList,  $apiCdiscountSearchByIdProduct);
            if(Rate::averageForList($idList) != 0){ $avg = Rate::averageForList($idList); }else{ $avg = 0;}
            $tab_to_return['lists'][] = [
                'list' => $theList,
                'products'=> $theBelong,
                'rating' => round($avg / 5, 2),
                'nb_products' => count($theBelong),
                'total_price' => $total,
            ];
        }

        $tab_to_return['nb_list_total'] = count($sorted_lists);

        return $tab_to_return;

    }


}
