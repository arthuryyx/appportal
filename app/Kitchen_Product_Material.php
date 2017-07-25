<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Product_Material extends Model
{
    protected $fillable = ['kitchen_product_id', 'product_part_id', 'material_item_id', 'qty'];

}
