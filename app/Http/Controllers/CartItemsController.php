<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartItem;
use Illuminate\Http\Request;

class CartItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productId, $cartId)
    {
        $cartController = new CartsController();
        $items = $cartController->cartItems($cartId);
        $cartItem = new CartItem();
        $productExists = false;

        foreach ($items as $item) {
            if ($item->product_id == $productId) {
                $productExists = true;
                $cartItem = $item;
                $cartItem->quantity = $request->input('quantity');
                break;
            }
        }

        if(!$productExists){
            $cartItem->product_id = $productId;
            $cartItem->cart_id = $cartId;
            $cartItem->quantity = $request->input('quantity');
        }

        if ($cartItem->save()) {
            return new \App\Http\Resources\CartItem($cartItem);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);

        if($cartItem->delete()){
            return $cartItem;
        }
    }
}
