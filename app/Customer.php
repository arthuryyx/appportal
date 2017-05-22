<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['first', 'last', 'phone', 'mobile', 'email', 'type', 'comment'];

    public function hasManyAddresses()
    {
        return $this->hasMany('App\Address', 'customer_id', 'id');
    }

    public function getDefaultAddress()
    {
        return $this->hasManyAddresses()->where('type', 1);
    }

}
