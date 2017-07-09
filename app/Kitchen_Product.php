<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Product extends Model
{
    protected $fillable = ['product_id', 'quotation_id', 'job_id'];

    public function product(){
        return $this->belongsTo(Product_Model::class, 'product_id', 'id');
    }
}
