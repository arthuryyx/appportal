<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['address', 'street', 'sub', 'city', 'zip', 'customer_id', 'type'];

}
