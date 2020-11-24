<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Payment extends Model
{
    protected $fillable = ['amount', 'job_id', 'created_by'];

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
