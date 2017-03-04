<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';

    public $timestamps = false;

    protected $fillable = ['name', 'thickness', 'brand', 'color', 'finish', 'making', 'type'];
}
