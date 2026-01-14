<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Venue;
use App\Models\Event;
use App\Models\Ticket;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Ticket::truncate();
        Event::truncate();
        Venue::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --------------------
        // Venues
        // --------------------
        $venue1 = Venue::create([
            'name' => 'Malta Conference Centre',
            'slug' => Str::slug('Malta Conference Centre'),
            'city' => 'Valletta',
            'country' => 'Malta',
            'address' => 'Republic Street',
            'description' => 'A large venue used for conferences, concerts, and international events.'
        ]);

        $venue2 = Venue::create([
            'name' => 'Open Air Arena',
            'slug' => Str::slug('Open Air Arena'),
            'city' => 'St Julian\'s',
            'country' => 'Malta',
            'address' => 'Bay Street',
            'description' => 'Outdoor venue ideal for music festivals and summer events.'
        ]);

        // --------------------
        // Events
        // --------------------
        $event1 = Event::create([
            'venue_id' => $venue1->id,
            'title' => 'Tech Conference 2026',
            'slug' => Str::slug('Tech Conference 2026'),
            'starts_at' => Carbon::now()->addDays(14),
            'ends_at' => Carbon::now()->addDays(14)->addHours(6),
            'description' => 'A technology conference focusing on modern web development and cloud systems.'
        ]);

        $event2 = Event::create([
            'venue_id' => $venue2->id,
            'title' => 'Summer Music Festival',
            'slug' => Str::slug('Summer Music Festival'),
            'starts_at' => Carbon::now()->addDays(30),
            'ends_at' => Carbon::now()->addDays(30)->addHours(5),
            'description' => 'Live music performances by local and international artists.'
        ]);

        // --------------------
        // Tickets
        // --------------------
        Ticket::create([
            'event_id' => $event1->id,
            'type' => 'Standard',
            'quantity' => 300,
            'price_cents' => 2500, // €25.00
        ]);

        Ticket::create([
            'event_id' => $event1->id,
            'type' => 'VIP',
            'quantity' => 50,
            'price_cents' => 7500, // €75.00
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'type' => 'General Admission',
            'quantity' => 500,
            'price_cents' => 4000, // €40.00
        ]);

        Ticket::create([
            'event_id' => $event2->id,
            'type' => 'Backstage Pass',
            'quantity' => 30,
            'price_cents' => 12000, // €120.00
        ]);
    }
}
