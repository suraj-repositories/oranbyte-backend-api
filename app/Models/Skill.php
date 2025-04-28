<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    //
    protected $fillable = ['technology_id', 'percentage'];

    public function technology(){
        return $this->belongsTo(Technology::class);
    }
}
