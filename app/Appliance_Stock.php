<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Stock extends Model
{
    protected $fillable = ['aid', 'order_id', 'arrival_id', 'assign_to', 'deliver_to', 'shelf', 'state', 'price', 'warranty'];

    public function appliance()
    {
        return $this->belongsTo('App\Appliance', 'aid', 'id');
    }

    public function getAssignTo()
    {
        return $this->belongsTo('App\Appliance_Invoice', 'assign_to', 'id');
    }

    public function getOrder()
    {
        return $this->belongsTo('App\Appliance_Order', 'order_id', 'id');
    }

    public function getDeliveryHistory()
    {
        return $this->belongsTo('App\Appliance_Delivery', 'deliver_to', 'id');
    }
}
