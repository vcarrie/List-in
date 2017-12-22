<?php

namespace App\Http\Controllers;

use App\Belong;
use App\Liste;
use App\Repositories\ApiCdiscount\ApiCdiscountPushToCart;
use App\Repositories\ApiCdiscount\ApiCdiscountSearchByIdProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addListToCart($id, Request $request)
    {
        if (!$request->session()->has('cart')) {
            $cart = array();
        } else {
            $cart = session('cart');
        }


        $add_is_okay = true;
        foreach ($cart as $key => $idList) {
            if ($idList == $id) {
                $add_is_okay = false;
            }
        }
        if ($add_is_okay) {
            $request->session()->push('cart', $id);
        }

        return session('cart');
    }

    public function RemoveListFromCart($id, Request $request)
    {

        if (!$request->session()->has('cart')) {
            $cart = array();
        } else {
            $cart = session('cart');
        }
        foreach ($cart as $key => $idList) {
            if ($idList == $id) {
                unset($cart[$key]);
            }
        }

        $cart = array_values($cart);

        session(['cart' => $cart]);
        return session('cart');
    }

    public function empty_cart()
    {
        $cart = null;
        session(['cart' => $cart]);
    }

    public function get_cart(Request $request)
    {
        if (!$request->session()->has('cart')) {
            $cart = array();
        } else {
            $cart = session('cart');
        }
        return $cart;
    }

    public function show_cart(Request $request, ApiCdiscountSearchByIdProductRepository $api, ApiCdiscountPushToCart $apicreate)
    {
        $url = "#";
        if (!$request->session()->has('cart')) {
            $cart = array();
        } else {
            $cart = session('cart');
            $idproducts = Belong::getProductsByIdsList($cart);




            $result = $apicreate->createCart($idproducts->first()->idCdiscount, $idproducts->first()->quantity);
            if (isset($result->CartGUID)){

                $numCart = $result->CartGUID;
                $cpt = 0;
                foreach($idproducts as $id) {
                    if ($cpt != 0){
                        $request_result = $apicreate->pushToCart($id->idCdiscount, $id->quantity, $numCart);
                        if (isset($request_result->CheckoutUrl)){

                            $url = $request_result->CheckoutUrl;
                        }
                    }
                    $cpt ++;

                }
            }

        }
        $to_return = array();
        foreach ($cart as $id) {
            $list = Liste::find($id);
            $theBelong = Belong::getProductsByIdList($id, $api);
            $to_return[] = array($list, $theBelong[0], count($theBelong[0]), $theBelong[1]);
        }
        $to_return[] = $url;
        return view('cart', compact('to_return', 'to_return'));
    }
}
