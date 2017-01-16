<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance extends Model
{
    public function belongsToBrand()
    {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    public function belongsToCategory()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
