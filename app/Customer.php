<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['first', 'last', 'phone', 'mobile', 'email', 'street', 'sub', 'city', 'zip', 'type', 'comment'];

}
