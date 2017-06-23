<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material_Item extends Model
{
    protected $fillable = ['model', 'type_id', 'supplier_id'];

    public function values()
    {
        return $this->belongsToMany(Material_Attribute_Value::class, 'material__item__values', 'item_id', 'attribute_value_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Material_Item_Type', 'type_id', 'id');
    }

    public function getSupplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
    }
}
