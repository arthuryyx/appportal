<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Product_Item extends Model
{
    protected $fillable = ['aid', 'quote_id', 'template_id', 'model', 'brand', 'category', 'price', 'size'];

    public function getQuote()
    {
        return $this->belongsTo('App\Kitchen_Job_Quote', 'quote_id', 'id');
    }

}
