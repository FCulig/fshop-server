<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryRequest extends Model
{
    public function categoryGroup()
    {
        return $this->belongsTo('App\CategoryGroup', 'group_id', 'id');
    }
}
