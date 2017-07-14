<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Part extends Model
{
    protected $fillable = ['name'];

    public function materialTypes()
    {
        return $this->belongsToMany(Material_Item_Type::class, 'product__part_material__type', 'part_id', 'type_id');
    }

}
