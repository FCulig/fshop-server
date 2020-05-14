<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $soldItems = sizeof(\App\User::findOrFail($this->id)->transactions->where('status_id', 3));
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'profile_img_url' => $this->profile_img_url,
            'role_id' => $this->role_id,
            'username' => $this->username,
            'number_sold_items' => $soldItems,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
