<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['customer_id', 'job_id', 'address', 'state'];

    public function haManyAppliances()
    {
        return $this->hasMany('App\Project_Appliance_Record', 'project_id', 'id');
    }
}
