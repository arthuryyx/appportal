<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Invoice extends Model
{
    protected $fillable = ['receipt_id', 'job_id', 'customer_name', 'phone', 'email', 'price', 'address', 'state', 'comment', 'type', 'created_by'];

    public function hasManyStocks()
    {
        return $this->hasMany('App\Appliance_Stock', 'assign_to', 'id');
    }

    public function hasManyInits()
    {
        return $this->hasMany('App\Appliance_Stock', 'init', 'id');
    }

    public function hasManyDeposits()
    {
        return $this->hasMany('App\Appliance_Deposit', 'invoice_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function getState()
    {
        return $this->hasManyStocks()->where('state', '<', 3);
    }

    public function getDispatches()
    {
        return $this->hasMany('App\Appliance_Dispatch', 'invoice_id', 'id');
    }
}
