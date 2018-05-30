<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance extends Model
{

    protected $table = 'appliances';

    protected $fillable = [
        'model',
        'barcode',
        'brand_id',
        'category_id',
        'state',
        'rrp',
        'lv1',
        'lv2',
        'lv3',
        'lv4',
        'description'
    ];

    public function belongsToBrand()
    {
        return $this->belongsTo('App\Brand', 'brand_id', 'id');
    }

    public function belongsToCategory()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
