<?php

namespace App\Http\Resources;

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $productsController = new ProductsController;
        $product = new Product($productsController->getProductWithId($this->item_id));
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'coupon' => $this->coupon,
            'product' => $product,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
            'status' => $this->status,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
