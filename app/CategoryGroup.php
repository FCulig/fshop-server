<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    protected $table = "category_groups";

    public function categories()
    {
        return $this->hasMany('App\Category', 'group_id', 'id');
    }

    public function categoryRequests()
    {
        return $this->hasMany('App\CategoryRequest', 'group_id', 'id');
    }
}
