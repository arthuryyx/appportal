<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Board_Stock extends Model
{
    protected $fillable = ['brand', 'title', 'size', 'qty'];

    public function hasManyUsage()
    {
        return $this->hasMany('App\Kitchen_Board_Usage', 'stock_id');
    }

    public function hasManyOrderItem()
    {
        return $this->hasMany('App\Kitchen_Board_Order_Item', 'stock_id');
    }
}