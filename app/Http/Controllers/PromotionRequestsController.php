<?php

namespace App\Http\Controllers;

use App\PromotionRequest;
use App\User;
use Illuminate\Http\Request;

class PromotionRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = PromotionRequest::all();
        $requestResources = array();
        foreach ($requests as $req){
            $requestResources[] = new \App\Http\Resources\PromotionRequest($req);
        }

        return $requestResources;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $promotionRequest = new PromotionRequest;

        $promotionRequest->user_id = $request->input('user_id');

        if($promotionRequest->save()){
            return new \App\Http\Resources\PromotionRequest($promotionRequest);
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
        return PromotionRequest::findOrFail($id);
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
        $promotionRequest = PromotionRequest::findOrFail($id);

        if(is_null($promotionRequest->result) != false){
            $promotionRequest->id = $id;
            $promotionRequest->user_id = $request->input('user_id');
            $promotionRequest->result = null;

            if($promotionRequest->save()){
                return new \App\Http\Resources\PromotionRequest($promotionRequest);
            }
        }else{
            //TODO: poruka za onemogućenje editanja promotion requesta
            return "Nije moguće editat!";
        }
    }

    public function approveRequest($id){
        //TODO: provjera je li declinean vec
        $promotionRequest = PromotionRequest::findOrFail($id);
        $promotionRequest->result = true;

        $user = User::findOrFail($promotionRequest->user_id);
        $user->role_id = 2;

        if($user->save() && $promotionRequest->save()){
            return new \App\Http\Resources\PromotionRequest($promotionRequest);
        }
    }

    public function declineRequest($id){
        $promotionRequest = PromotionRequest::findOrFail($id);
        $promotionRequest->result = false;

        if($promotionRequest->save()){
            return new \App\Http\Resources\PromotionRequest($promotionRequest);
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
        $promotionRequest = PromotionRequest::findOrFail($id);

        if($promotionRequest->delete()) {
            return new \App\Http\Resources\PromotionRequest($promotionRequest);
        }
    }
}
