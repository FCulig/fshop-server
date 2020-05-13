<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = $this->items;
        $itemResources = array();
        foreach ($items as $item){
            $itemResources[] = new CartItem($item);
        }
        
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'items' => $itemResources,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
