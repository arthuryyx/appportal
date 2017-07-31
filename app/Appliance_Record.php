<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appliance_Record extends Model
{
    protected $fillable = ['sid', 'type', 'created_by'];

    public function stock()
    {
        return $this->belongsTo(Appliance_Stock::class, 'sid', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

}
