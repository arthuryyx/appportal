<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Dispatch extends Model
{
    protected $fillable = ['invoice_id', 'schedule_id', 'date', 'fee', 'created_by', 'state', 'comment' ];

    public function getSchedule()
    {
        return $this->belongsTo(Appliance_Schedule::class, 'schedule_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
