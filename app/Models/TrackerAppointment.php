<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackerAppointment extends Model
{
    use HasFactory;

    protected $fillable = ['appointment_at'];

    protected $casts = [
        'appointment_at' => 'datetime',
    ];

    public function tracker(): BelongsTo
    {
        return $this->belongsTo(Tracker::class);
    }
}
