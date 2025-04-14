<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Readme extends Model
{
    //
    protected $fillable = [
        'project_id',
        'content',
    ];
}
