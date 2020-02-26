<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['code', 'name', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
