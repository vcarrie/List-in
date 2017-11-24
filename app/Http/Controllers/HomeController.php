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
        $tab_products = array();
        $nbLists = count($all_lists_by_nb_tags);
        $maxTags = 0;

        for ($i = 0; $i < $nbLists; $i++) {

            $list = $all_lists_by_nb_tags[$i];
            $idList = $list->idList;
            $nbTag = $list->NbTag;

            if ($nbTag > $maxTags)
                $maxTags = $nbTag;

            $theList = Liste::find($idList);

            $theBelong = Belong::getProductsByIdList($idList, $apiCdiscountSearchByIdProduct);
            $price = $theBelong[1];


            if (Rate::averageForList($idList) != 0) {
                $avg = Rate::averageForList($idList);
            } else {
                $avg = 0;
            }


            $tab_products[$nbTag][] = [
                'list' => $theList,
                'products' => $theBelong[0],
                'rating' => round($avg / 5, 2),
                'nb_products' => count($theBelong[0]),
                'total_price' => round($price, 2),
            ];

        }

        $tab_to_return['lists'] = array();

        switch ($sort_index) {
            case 0://rating
                for ($i = $maxTags; $i >= 1; $i--) {
                    if (isset($tab_products[$i])) {
                        $sortRate = $this->array_sort($tab_products[$i], 'rating', SORT_DESC);

                        foreach ($sortRate as $product) {
                            array_push($tab_to_return['lists'], $product);
                        }
                    }
                }
                break;

            case 1://prix croissant
                for ($i = $maxTags; $i >= 1; $i--) {
                    if (isset($tab_products[$i])) {
                        $sortPriceAsc = $this->array_sort($tab_products[$i], 'total_price');

                        foreach ($sortPriceAsc as $product) {
                            array_push($tab_to_return['lists'], $product);
                        }
                    }
                }
                break;

            case 2://prix decroissant
                for ($i = $maxTags; $i >= 1; $i--) {
                    if (isset($tab_products[$i])) {
                        $sortPriceDesc = $this->array_sort($tab_products[$i], 'total_price', SORT_DESC);

                        foreach ($sortPriceDesc as $product) {
                            array_push($tab_to_return['lists'], $product);
                        }
                    }
                }
                break;
        }


        $tab_to_return['nb_list_total'] = count($tab_to_return['lists']);

        return $tab_to_return;
    }

    private function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[] = $array[$k];
            }
        }

        return $new_array;
    }

}
