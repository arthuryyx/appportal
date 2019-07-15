<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Quote extends Model
{
    protected $fillable = ['quote_no', 'invoice_id', 'customer_name', 'phone', 'email', 'address', 'price', 'comment', 'created_by'];

    public function getInvoice()
    {
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }

    public function getCreated_by()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function hasManyItems()
    {
        return $this->hasMany('App\Appliance_Item', 'quote_id');
    }
}
