<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Category extends Model
{
    protected $fillable = ['name', 'parent_id', 'type'];

    public function parent()
    {
        return $this->belongsTo('App\Product_Category', 'parent_id', 'id');
    }

    public function children() {
        return $this->hasMany('App\Product_Category','parent_id','id') ;
    }
}
