<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Board_Usage extends Model
{
    protected $fillable = ['stock_id', 'job_no', 'val', 'created_by'];

    public function getStock()
    {
        return $this->belongsTo('App\Kitchen_Board_Stock', 'stock_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
