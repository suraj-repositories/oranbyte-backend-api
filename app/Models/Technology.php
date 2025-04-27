<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = ['name', 'logo', 'icon', 'description'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_technologies')
            ->withPivot('percentage')
            ->withTimestamps();
    }

    public function experiences()
    {
        return $this->belongsToMany(ProfessionalExperience::class, 'experience_technology')
            ->using(ExperienceTechnology::class)
            ->withTimestamps();
    }
}
