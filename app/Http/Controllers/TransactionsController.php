<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewTransactionRequest;
use App\Http\Resources\Transaction;
use App\Transcation;
use App\User;
use Illuminate\Http\Request;

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

        if ($request->exists('type')) {
            $transactions = User::findOrFail($id)->transactions->where('status_id', $request->query('type'));
        } else {
            $transactions = User::findOrFail($id)->transactions;
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

        if ($transaction->save()) {
            return new Transaction($transaction);
        }
    }

    public function shipTransaction($id)
    {
        $transaction = Transcation::findOrFail($id);
        $transaction->status_id = 3;

        if ($transaction->save()) {
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

        $transactions = array();
        foreach ($items as $item) {
            $transaction = new Transcation($request->all());
            $transaction->item_id = $item->product_id;
            $transaction->status_id = 1;
            $transaction->quantity = $item->quantity;

            if ($transaction->save()) {
                if ($productsController->buyProduct($transaction->item_id, $transaction->quantity)) {
                    $transactions[] = $transaction;
                    $cartItemsController->destroy($item->id);
                }
            }
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
