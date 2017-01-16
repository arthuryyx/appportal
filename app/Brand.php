<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = ['name', 'type'];

//    public function belongsToGroup()
//    {
//        return $this->belongsTo('App\Group', 'group_id', 'id');
//    }

    public function hasManyAppliances()
    {
        return $this->hasMany('App\Appliance', 'brand_id', 'id');
    }
}
