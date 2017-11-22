<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addListToCart($id, Request $request){
        if (!$request->session()->has('cart')) {
            $cart = array();
        }else{
            $cart = session('cart');
        }


        $add_is_okay = true;
        foreach ($cart as $key=>$idList){
            if($idList==$id){
                $add_is_okay = false;
            }
        }
        if ($add_is_okay){
            $request->session()->push('cart', $id);
        }

        return session('cart');
    }

    public function RemoveListFromCart($id, Request $request){

        if (!$request->session()->has('cart')) {
            $cart = array();
        }else{
            $cart = session('cart');
        }
            foreach ($cart as $key=>$idList){
                if($idList==$id){
                unset($cart[$key]);
            }
        }

        //  session()->flush();

        session(['cart' => $cart]);
        return session('cart');
    }
    public function empty_cart(){
        $cart = null;
        session(['cart' => $cart]);
    }

    public function show_cart(Request $request){

        if (!$request->session()->has('cart')) {
            $cart = array();
        }else{
            $cart = session('cart');
        }
        return view('cart', compact('cart', 'cart'));
    }
}
