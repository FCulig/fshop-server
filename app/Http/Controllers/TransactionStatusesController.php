<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionStatus;
use App\Http\Resources\TransactionStatus as TransactionStatusResource;

class TransactionStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransactionStatus::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transactionStatus = new TransactionStatus;

        $transactionStatus->name = $request->input('name');

        if ($transactionStatus->save()) {
            return new TransactionStatusResource($transactionStatus);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TransactionStatusResource(TransactionStatus::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transactionStatus = TransactionStatus::findOrFail($id);

        $transactionStatus->id = $id;
        $transactionStatus->name = $request->input('name');

        if ($transactionStatus->save()) {
            return new TransactionStatusResource($transactionStatus);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transactionStatus = TransactionStatus::findOrFail($id);

        if ($transactionStatus->delete()) {
            return new TransactionStatusResource($transactionStatus);
        }
    }
}
