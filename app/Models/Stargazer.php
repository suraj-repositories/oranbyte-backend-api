<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stargazer extends Model
{
    //
    protected $fillable = [
        'project_id',
        'github_id',
        'github_username',
        'github_url',
        'avatar_url',
        'created_at',
        'updated_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
