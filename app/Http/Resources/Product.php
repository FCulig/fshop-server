<?php

namespace App\Http\Resources;

use App\Http\Controllers\CommentsController;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $commentsController = new CommentsController();
        $comments = $commentsController->commentsOnProductFN($this->id);
        $commentsResources = array();

        foreach($comments as $comment){
            $commentsResources[] = new Comment($comment);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'comments' => $commentsResources,
            'images' => $this->productImages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
