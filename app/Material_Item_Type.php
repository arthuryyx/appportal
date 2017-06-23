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
}
