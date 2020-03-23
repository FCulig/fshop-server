<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionRequest extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
