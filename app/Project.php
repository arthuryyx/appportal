<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['receipt_id', 'job_id', 'customer_name', 'address', 'state', 'created_by'];

//    public function hasManyAppliances()
//    {
//        return $this->hasMany('App\Project_Appliance_Record', 'project_id', 'id');
//    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
