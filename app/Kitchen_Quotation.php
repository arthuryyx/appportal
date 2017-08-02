<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Quotation extends Model
{
    protected $fillable = ['customer_id', 'address_id', 'created_by', 'state'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getCreated_by(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function products()
    {
        return $this->hasMany(Kitchen_Product::class, 'quotation_id', 'id');
    }

    public function job() {
        return $this->belongsTo(Kitchen_Job::class, 'id', 'quotation_id');
    }
}
