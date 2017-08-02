<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Job extends Model
{
    protected $fillable = ['quotation_id', 'total'];

    public function quotation() {
        return $this->belongsTo(Kitchen_Quotation::class, 'quotation_id', 'id');
    }

    public function products() {
        return $this->hasMany(Kitchen_Product::class, 'job_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
