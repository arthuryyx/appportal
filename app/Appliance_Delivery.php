<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Delivery extends Model
{
    protected $fillable = ['invoice_id', 'carrier', 'packing_slip', 'signature', 'state', 'created_by'];

    public function hasManyStocks()
    {
        return $this->hasMany('App\Appliance_Stock', 'deliver_to', 'id');
    }

    public function getInvoice(){
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
