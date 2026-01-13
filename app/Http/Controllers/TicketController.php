<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets
     * Supports filtering by event and sorting by price
     */
    public function index(Request $request)
    {
        $query = Ticket::query()->with('event');

        // Filter by event
        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price_cents');
                    break;
                case 'price_high':
                    $query->orderByDesc('price_cents');
                    break;
                case 'latest':
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $tickets = $query->paginate(10)->withQueryString();
        $events  = Event::orderBy('starts_at')->get();

        return view('tickets.index', compact('tickets', 'events'));
    }

    /**
     * Show the form for creating a new ticket
     */
    public function create(Request $request)
    {
        $events = Event::orderBy('starts_at')->get();

        // Optional: preselect event if provided (e.g., from event show page)
        $selectedEventId = $request->get('event_id');

        return view('tickets.create', compact('events', 'selectedEventId'));
    }

    /**
     * Store a newly created ticket
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'type' => 'required|string|max:60',
            'quantity' => 'required|integer|min:1|max:100000',
            'price' => 'required|numeric|min:0|max:100000',
        ]);

        // Convert price (e.g., 12.50) to cents (1250)
        $priceCents = (int) round(((float) $validated['price']) * 100);

        Ticket::create([
            'event_id' => $validated['event_id'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'price_cents' => $priceCents,
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display a specific ticket
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('event.venue');
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing a ticket
     */
    public function edit(Ticket $ticket)
    {
        $events = Event::orderBy('starts_at')->get();
        return view('tickets.edit', compact('ticket', 'events'));
    }

    /**
     * Update a ticket
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'type' => 'required|string|max:60',
            'quantity' => 'required|integer|min:1|max:100000',
            'price' => 'required|numeric|min:0|max:100000',
        ]);

        $priceCents = (int) round(((float) $validated['price']) * 100);

        $ticket->update([
            'event_id' => $validated['event_id'],
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'price_cents' => $priceCents,
        ]);

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove a ticket
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
}
