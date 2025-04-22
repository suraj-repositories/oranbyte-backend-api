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
}
