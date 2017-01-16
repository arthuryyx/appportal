<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'type'];

//    public function belongsToGroup()
//    {
//        return $this->belongsTo('App\Group', 'group_id', 'id');
//    }

    public function hasManyAppliances()
    {
        return $this->hasMany('App\Appliance', 'category_id', 'id');
    }
}
