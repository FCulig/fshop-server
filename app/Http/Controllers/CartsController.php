<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function index(){
        return Cart::all();
    }

    public function store($userId){
        $cart = new Cart();
        $cart->user_id = $userId;

        if($cart->save()){
            return new \App\Http\Resources\Cart($cart);
        }
    }

    public function cartItems($cartId){
        $cart = $this->getCartWithId($cartId);
        return $cart->items;
    }

    public function getCartWithId($id){
        return Cart::findOrFail($id);
    }

    public function getCartByUser($userId){
        return Cart::where('user_id', $userId)->first();
    }

}
