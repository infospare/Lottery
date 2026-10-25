<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $connection = 'infospare';

    protected $table = 'subscribers';

    protected $fillable = [
        'subscriber_name',
        'phone',
        'registration_id',
        'registration_key',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function getFormattedExpiryDateAttribute(): string
    {
        return $this->expiry_date ? $this->expiry_date->format('d/m/Y') : '—';
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date && $this->expiry_date->copy()->startOfDay()->lte(now()->startOfDay());
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        if (!$this->expiry_date || $this->is_expired) {
            return false;
        }

        $today = now()->startOfDay();
        $expiry = $this->expiry_date->copy()->startOfDay();

        return $expiry->gte($today) && $expiry->lte($today->copy()->addDays(10));
    }
}
