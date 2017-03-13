<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Stock extends Model
{
    protected $fillable = ['aid', 'init', 'assign_to', 'deliver_to', 'shelf', 'state'];

    public function appliance()
    {
        return $this->belongsTo('App\Appliance', 'aid', 'id');
    }

    public function getAssignTo()
    {
        return $this->belongsTo('App\Appliance_Invoice', 'assign_to', 'id');
    }

    public function getInvoice()
    {
        return $this->belongsTo('App\Appliance_Invoice', 'init', 'id');
    }
}
