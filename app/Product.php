<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany('App\ProductImage', 'product_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'product_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transcation', 'item_id', 'id');
    }
}
