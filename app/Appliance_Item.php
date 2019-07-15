<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Item extends Model
{
    protected $fillable = ['aid', 'invoice_id', 'quote_id', 'stock_id', 'price', 'warranty', 'type', 'state'];

    public function getAppliance()
    {
        return $this->belongsTo('App\Appliance', 'aid', 'id');
    }
    public function getInvoice()
    {
        return $this->belongsTo('App\Appliance_Invoice', 'invoice_id', 'id');
    }

    public function getQuote()
    {
        return $this->belongsTo('App\Appliance_Quote', 'quote_id', 'id');
    }

    public function getStock()
    {
        return $this->belongsTo('App\Appliance_Stock', 'stock_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
