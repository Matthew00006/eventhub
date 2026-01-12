<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'event_id',
        'type',
        'quantity',
        'price_cents',
    ];

    /**
     * Each ticket belongs to one event
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Convenience accessor: returns price formatted in euros
     * (stored as cents in DB)
     */
    public function getPriceAttribute(): string
    {
        return number_format($this->price_cents / 100, 2);
    }
}
