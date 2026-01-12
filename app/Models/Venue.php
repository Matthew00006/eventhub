<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'city',
        'country',
        'address',
        'description',
    ];

    /**
     * One venue has many events
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * SEO friendly URLs: /venues/sliema-hall instead of /venues/1
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
