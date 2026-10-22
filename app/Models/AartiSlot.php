<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AartiSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'aarti_id',
        'slot_date',
        'start_time',
        'end_time',
        'reporting_time',
        'total_capacity',
        'booked_seats',
        'general_price',
        'vip_price',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'slot_date' => 'date',
            'general_price' => 'decimal:2',
            'vip_price' => 'decimal:2',
            'total_capacity' => 'integer',
            'booked_seats' => 'integer',
        ];
    }

    public function aarti(): BelongsTo
    {
        return $this->belongsTo(Aarti::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvailableSeatsAttribute(): int
    {
        return max(0, $this->total_capacity - $this->booked_seats);
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->available_seats <= 0 || $this->status === 'sold_out';
    }

    public function getFormattedTimeAttribute(): string
    {
        $start = Carbon::parse($this->start_time)->format('h:i A');
        $end = Carbon::parse($this->end_time)->format('h:i A');

        return "{$start} - {$end}";
    }
}
