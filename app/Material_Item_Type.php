<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material_Item_Type extends Model
{
    protected $fillable = ['name'];

    public function hasManyItems()
    {
        return $this->hasMany('App\Material_Item', 'type_id', 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Material_Attribute_Type::class, 'material__item__attributes', 'mat_tid', 'att_tid');
    }

}
