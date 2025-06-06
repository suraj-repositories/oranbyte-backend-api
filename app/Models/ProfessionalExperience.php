<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalExperience extends Model
{
    //
    protected $table = "professional_experiences";
    protected $fillable = [
        'job_title',
        'company',
        'location',
        'start_date',
        'end_date',
        'currently_working',
        'description',
        'user_id',
    ];


    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'experience_technology')
            ->using(ExperienceTechnology::class)
            ->withTimestamps();
    }
}
