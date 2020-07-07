<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Board_Order extends Model
{
    protected $fillable = ['ref', 'created_by'];

    public function hasManyItem()
    {
        return $this->hasMany('App\Kitchen_Board_Order_Item', 'order_id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
