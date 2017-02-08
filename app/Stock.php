<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['aid', 'receipt', 'init', 'assign_to', 'deliver_to', 'shelf', 'state'];

    public function appliance()
    {
        return $this->belongsTo('App\Appliance', 'aid', 'id');
    }
}
