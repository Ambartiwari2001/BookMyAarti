<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'aarti_slot_id',
        'seating_type',
        'devotee_count',
        'contact_name',
        'contact_email',
        'contact_phone',
        'address_city',
        'ticket_amount',
        'add_ons_amount',
        'total_amount',
        'payment_status',
        'payment_method',
        'payment_id',
        'booking_status',
        'qr_token',
        'checked_in_at',
        'cancelled_at',
        'cancellation_reason',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'ticket_amount' => 'decimal:2',
            'add_ons_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'devotee_count' => 'integer',
            'checked_in_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(AartiSlot::class, 'aarti_slot_id');
    }

    public function devotees(): HasMany
    {
        return $this->hasMany(DevoteeDetail::class);
    }

    public function bookingAddOns(): HasMany
    {
        return $this->hasMany(BookingAddOn::class);
    }

    public function addOns(): BelongsToMany
    {
        return $this->belongsToMany(AddOn::class, 'booking_add_ons')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}
