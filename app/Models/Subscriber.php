<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    //
    protected $fillable = [
        'email',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'location',
    ];
}
