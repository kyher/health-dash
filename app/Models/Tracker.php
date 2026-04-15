<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tracker extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TrackerCategory::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TrackerNote::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(TrackerAppointment::class)->orderBy('appointment_at');
    }
}
