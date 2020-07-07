<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Board_Order_Item extends Model
{
    protected $fillable = ['stock_id', 'order_id', 'job_no', 'qty', 'remain'];

    public function getStock()
    {
        return $this->belongsTo('App\Kitchen_Board_Stock', 'stock_id', 'id');
    }

    public function getOrder()
    {
        return $this->belongsTo('App\Kitchen_Board_Order', 'order_id', 'id');
    }

    public function hasManyArrive()
    {
        return $this->hasMany('App\Kitchen_Board_Arrive', 'order_item_id');
    }
}
