<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Delivery extends Model
{
    protected $fillable = ['invoice_id', 'carrier', 'packing_slip', 'signature', 'state'];

    public function hasManyStocks()
    {
        return $this->hasMany('App\Appliance_Stock', 'deliver_to', 'id');
    }

    public function getInvoice(){
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }
}
