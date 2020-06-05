<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::all();
        return $this->getCouponResources($coupons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exists = Coupon::where('code', $request->code)->get();

        if ($exists == null) {
            $coupon = new Coupon($request->all());

            if ($coupon->save()) {
                return new \App\Http\Resources\Coupon($coupon);
            }
        } else {
            return response()->json([
                "message" => "Ovaj kupon je već u uporabi!"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $coupon = Coupon::where('code', $code)->first();

        if ($coupon == null) {
            return response()->json([
                "message" => "Ovaj kupon ne postoji!"
            ]);
        }

        if ($coupon->uses < 1) {
            return response()->json([
                "message" => "Ovaj kupon više nije valjan!"
            ]);
        }

        return new \App\Http\Resources\Coupon($coupon);
    }

    public function usersCoupons($id)
    {
        $coupons = Coupon::all()->where('user_id', $id);
        return $this->getCouponResources($coupons);
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
        $coupon = Coupon::findOrFail($id);
        if ($coupon->delete()) {
            return new \App\Http\Resources\Coupon($coupon);
        }
    }

    private function getCouponResources($coupons)
    {
        $resources = array();
        foreach ($coupons as $coupon) {
            $resources[] = new \App\Http\Resources\Coupon($coupon);
        }

        return $resources;
    }
}
