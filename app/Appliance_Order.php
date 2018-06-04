<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Order extends Model
{
    protected $fillable = ['ref', 'invoice_id', 'state', 'comment', 'created_by'];

    public function getStocks()
    {
        return $this->hasMany('App\Appliance_Stock', 'order_id', 'id');
    }

    public function getInvoice()
    {
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function getState()
    {
        return $this->getStocks()->where('state', 0);
    }
}
