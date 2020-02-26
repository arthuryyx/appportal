<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Job_Quote extends Model
{
    protected $fillable = ['quote_no', 'customer', 'phone', 'email', 'address', 'price', 'comment', 'created_by'];

    public function hasManyItems()
    {
        return $this->hasMany('App\Kitchen_Product_Item', 'quote_id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
