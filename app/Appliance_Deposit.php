<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Deposit extends Model
{
    protected $fillable = ['invoice_id', 'amount', 'created_by'];

    public function getInvoice(){
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
