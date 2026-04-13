<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackerNote extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function tracker(): BelongsTo
    {
        return $this->belongsTo(Tracker::class);
    }
}
