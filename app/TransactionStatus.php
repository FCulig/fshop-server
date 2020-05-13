<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    public function transactions()
    {
        return $this->hasMany('App\Transcation', 'status_id', 'id');
    }
}
