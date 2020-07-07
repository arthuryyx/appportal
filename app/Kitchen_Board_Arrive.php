<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Board_Arrive extends Model
{
    protected $fillable = ['order_item_id', 'value', 'remark', 'created_by'];

    public function getItem()
    {
        return $this->belongsTo('App\Kitchen_Board_Order_Item', 'order_item_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
