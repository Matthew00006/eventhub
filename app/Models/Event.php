<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'venue_id',
        'title',
        'slug',
        'starts_at',
        'ends_at',
        'description',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Each event belongs to one venue
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Each event has many tickets (we'll create Ticket next)
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * SEO friendly URLs: /events/laravel-meetup-malta instead of /events/1
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
