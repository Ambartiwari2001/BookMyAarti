<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aarti extends Model
{
    use HasFactory;

    protected $fillable = [
        'ghat_id',
        'title',
        'slug',
        'aarti_type',
        'timing_summary',
        'duration_minutes',
        'description',
        'significance',
        'ritual_steps',
        'banner_image',
        'base_price',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function ghat(): BelongsTo
    {
        return $this->belongsTo(Ghat::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(AartiSlot::class);
    }

    public function upcomingSlots(): HasMany
    {
        return $this->hasMany(AartiSlot::class)
            ->where('slot_date', '>=', now()->toDateString())
            ->where('status', 'active')
            ->orderBy('slot_date')
            ->orderBy('start_time');
    }
}
