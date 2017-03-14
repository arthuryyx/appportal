<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Deposit extends Model
{
    protected $fillable = ['invoice_id', 'amount'];

    public function getInvoice(){
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }
}
