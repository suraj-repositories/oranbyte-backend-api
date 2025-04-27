<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExperienceTechnology extends Pivot
{
    protected $table = 'experience_technology';

    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'professional_experience_id',
        'technology_id',
    ];

    public function experience()
    {
        return $this->belongsTo(ProfessionalExperience::class, 'professional_experience_id');
    }

    public function technology()
    {
        return $this->belongsTo(Technology::class, 'technology_id');
    }
}

