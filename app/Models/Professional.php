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
    ];

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
