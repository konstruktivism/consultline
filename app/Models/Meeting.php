<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'client_name',
        'client_email',
        'scheduled_at',
        'duration',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }
}
