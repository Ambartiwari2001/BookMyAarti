<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ghat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'city',
        'state',
        'river',
        'description',
        'address',
        'image_url',
        'reporting_instructions',
        'guidelines',
        'contact_helpline',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function aartis(): HasMany
    {
        return $this->hasMany(Aarti::class);
    }
}
