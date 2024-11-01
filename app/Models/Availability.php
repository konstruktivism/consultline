<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
