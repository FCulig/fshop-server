<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transcation extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'user_id', 'address', 'city', 'country', 'zip_code',
    ];

    public function product()
    {
        //return $this->hasOne('App\Product', 'id', 'product_id');
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\TransactionStatus', 'status_id', 'id');
    }
}
