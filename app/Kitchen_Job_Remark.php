<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Job_Remark extends Model
{
    protected $fillable = ['job_id', 'content', 'created_by'];

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
