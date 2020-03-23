<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    public function categoryGroup()
    {
        return $this->belongsTo('App\CategoryGroup', 'group_id', 'id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id', 'id');
    }
}
