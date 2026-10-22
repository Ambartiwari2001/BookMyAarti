<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevoteeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'name',
        'age',
        'gender',
        'gotra',
        'sankalp_purpose',
        'id_proof_type',
        'id_proof_number',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
