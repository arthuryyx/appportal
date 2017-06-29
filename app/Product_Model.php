<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Model extends Model
{
    protected $fillable = ['model', 'category_id'];

    public function materials()
    {
        return $this->belongsToMany(Material_Item::class, 'product__materials', 'product_id', 'material_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Product_Category', 'category_id', 'id');
    }
}
