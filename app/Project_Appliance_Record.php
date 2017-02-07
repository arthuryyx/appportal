<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_Appliance_Record extends Model
{
    public function belongsToProject()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
}
