<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return redirect()->route('venues.index');
});

// Venues CRUD (SEO slug handled by Venue model getRouteKeyName)
Route::resource('venues', VenueController::class);

// Events CRUD (SEO slug handled by Event model getRouteKeyName)
Route::resource('events', EventController::class);

// Tickets CRUD (uses numeric ID by default; that's fine)
Route::resource('tickets', TicketController::class);
