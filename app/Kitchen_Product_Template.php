<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Product_Template extends Model
{
    protected $fillable = [
        'model',
        'brand',
        'category',
        'description',
        'status',
        'size',
        'lv1',
        'lv2',
        'lv3',
        'lv4'
    ];

}
