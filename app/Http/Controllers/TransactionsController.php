<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Http\Requests\NewTransactionRequest;
use App\Http\Resources\Transaction;
use App\Product;
use App\Transcation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransactionsController extends Controller
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

    public function usersTransactions(Request $request, $id)
    {
        $transactionResources = array();
        $transactions = User::findOrFail($id)->transactions;

        if ($request->exists('type')) {
            $transactions = $transactions->where('status_id', $request->query('type'));
        }

        if ($request->exists('latest')) {
            $date = Carbon::today()->subDays(7);
            $transactions = $transactions->where('created_at', '>=', $date);
        }

        foreach ($transactions as $transaction) {
            $transactionResources[] = new Transaction($transaction);
        }

        return $transactionResources;
    }

    public function cancelTransaction($id)
    {
        $transaction = Transcation::findOrFail($id);
        $transaction->status_id = 4;

        $product = Product::findOrFail($transaction->item_id);
        $product->quantity = $product->quantity + $transaction->quantity;

        if ($transaction->save() && $product->save()) {
            return new Transaction($transaction);
        }
    }

    public function shipTransaction($id)
    {
        $transaction = Transcation::findOrFail($id);
        $transaction->status_id = 3;

        if ($transaction->save()) {
            Mail::to('email@email.com')->send(new \App\Mail\ShippedItemMail(\App\Product::findOrFail($transaction->item_id)->name));
            return new Transaction($transaction);
        }
    }

    public function usersOrders(Request $request, $userId)
    {
        $products = User::findOrFail($userId)->products;
        $transactions[] = array();

        if ($request->exists('type')) {
            foreach ($products as $product) {
                foreach ($product->transactions as $transaction) {
                    if ($transaction->status_id == $request->query('type')) {
                        $transactions[] = new Transaction($transaction);
                    }
                }
            }
        } else {
            foreach ($products as $product) {
                foreach ($product->transactions as $transaction) {
                    $transactions[] = new Transaction($transaction);
                }
            }
        }

        return $transactions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewTransactionRequest $request)
    {
        $cartController = new CartsController;
        $cartItemsController = new CartItemsController;
        $productsController = new ProductsController;
        $items = $cartController->getCartByUser($request->input('user_id'))->items;
        $user = User::findOrFail($request->input('user_id'));

        $usedCoupon = false;
        $couponId = null;
        $transactions = array();
        foreach ($items as $item) {
            $transaction = new Transcation($request->all());
            $transaction->item_id = $item->product_id;
            $transaction->status_id = 1;
            $transaction->quantity = $item->quantity;

            if (($item->coupon_id != null && $transaction->coupon->user_id != $item->product->user_id && $transaction->coupon->uses >= 1) || $transaction->coupon_id == null) {
                $transaction->coupon_id = null;
            } else {
                $usedCoupon = true;
                $couponId = $transaction->coupon->id;
            }

            if ($transaction->save()) {
                if ($productsController->buyProduct($transaction->item_id, $transaction->quantity, $user)) {
                    $transactions[] = new Transaction($transaction);
                    $cartItemsController->destroy($item->id);
                }
            }
        }

        if ($usedCoupon) {
            $coupon = Coupon::findOrFail($couponId);
            $coupon->uses = $coupon->uses - 1;

            $coupon->save();
        }

        return $transactions;
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
    public function destroy($id)
    {
        //
    }
}
