<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitchen_Job extends Model
{
    protected $fillable = ['job', 'ref', 'customer_id', 'customer_name', 'phone', 'email', 'address', 'price', 'created_by', 'created_at'];

//    public function getDetails()
//    {
//        return $this->hasMany('App\Appliance_Job_Detail', 'job_id', 'id');
//    }

    public function getRemarks()
    {
        return $this->hasMany('App\Kitchen_Job_Remark', 'job_id', 'id');
    }

    public function getCreated_by(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function getPayments()
    {
        return $this->hasMany('App\Kitchen_Payment', 'job_id', 'id');
    }
}
