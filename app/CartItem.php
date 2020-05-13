<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function cart(){
        return $this->belongsTo('App\Cart', 'cart_id', 'id');
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
