<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //
    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'dob',
        'gender',
        'bio',
        'profile_image',
    ];

    /**
     * Get the user associated with this detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
