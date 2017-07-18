<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Model extends Model
{
    protected $fillable = ['model', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Product_Category', 'category_id', 'id');
    }

    public function parts()
    {
        return $this->belongsToMany(Product_Part::class, 'product__model_product__part', 'model_id', 'part_id')->withPivot('qty');
    }
}
