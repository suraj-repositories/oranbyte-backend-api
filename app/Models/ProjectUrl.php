<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUrl extends Model
{
    //
    protected $fillable = [
        'project_id',
        'type',
        'url',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }


}
