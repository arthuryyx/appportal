<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Invoice extends Model
{
    protected $fillable = ['receipt_id', 'job_id', 'customer_name', 'address', 'state', 'type', 'created_by'];

    public function hasManyStocks()
    {
        return $this->hasMany('App\Stock', 'assign_to', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
