<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
    protected $fillable = [
        'name',
        'logo',
        'icon',
        'description',
    ];
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_languages')
            ->withPivot('percentage')
            ->withTimestamps();
    }
}
