<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material_Attribute_Type extends Model
{
    protected $fillable = ['name'];

    public function hasManyValues()
    {
        return $this->hasMany('App\Material_Attribute_Value', 'attribute_id', 'id')->orderBy('value');
    }

}
