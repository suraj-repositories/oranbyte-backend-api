<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'user_id',
        'repository_id',
        'name',
        'description',
        'url',
        'image',
        'stars',
        'language',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function urls()
    {
        return $this->hasMany(ProjectUrl::class);
    }

    public function technologies()
    {
        return $this->hasMany(ProjectTechnology::class);
    }

    public function readme(){
        return $this->hasOne(Readme::class);
    }
}
