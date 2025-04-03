<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    //
    protected $table = 'education';
    protected $fillable = [
        'degree',
        'institution',
        'field_of_study',
        'start_date',
        'end_date',
        'currently_studying',
        'grade',
        'description',
        'user_id',
    ];
}
