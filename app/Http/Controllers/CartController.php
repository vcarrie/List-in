<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request){

        $request->session()->push('cart', 3);
        return session('cart');
    }

    public function RemoveFromCart(Request $request){
        $cart = session('cart');
            foreach ($cart as $key=>$id){
                if($id==3){
                unset($cart[$key]);
            }
        }

        //  session()->flush();

        session(['cart' => $cart]);
        return session('cart');
    }
}
