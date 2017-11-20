<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addListToCart($id, Request $request){

        $cart = session('cart');
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
        $cart = session('cart');
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
        session()->get('cart')->flush();
    }
}
