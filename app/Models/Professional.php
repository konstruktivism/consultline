<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'specialization',
        'status',
    ];

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'professional_user', 'professional_id', 'user_id');
    }
}
