<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of events
     * Supports filtering by venue and sorting by date/title
     */
    public function index(Request $request)
    {
        $query = Event::query()->with('venue');


        if ($request->filled('venue')) {
            $query->where('venue_id', $request->venue);
        }


        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }


        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'title':
                    $query->orderBy('title');
                    break;
                case 'starts_at':
                    $query->orderBy('starts_at');
                    break;
                case 'latest':
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $events = $query->paginate(10)->withQueryString();
        $venues = Venue::orderBy('name')->get();

        return view('events.index', compact('events', 'venues'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        $venues = Venue::orderBy('name')->get();
        return view('events.create', compact('venues'));
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'title' => 'required|string|max:150',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'description' => 'nullable|string|max:4000',
        ]);

        // SEO-friendly slug
        $validated['slug'] = $this->uniqueSlugFromTitle($validated['title']);

        Event::create($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display a specific event (slug)
     */
    public function show(Event $event)
    {
        $event->load('venue', 'tickets');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing an event
     */
    public function edit(Event $event)
    {
        $venues = Venue::orderBy('name')->get();
        return view('events.edit', compact('event', 'venues'));
    }

    /**
     * Update an event
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'title' => 'required|string|max:150',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'description' => 'nullable|string|max:4000',
        ]);

        // If title changed, regenerate slug (unique)
        if ($event->title !== $validated['title']) {
            $validated['slug'] = $this->uniqueSlugFromTitle($validated['title'], $event->id);
        }

        $event->update($validated);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove an event
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Generate a unique slug for events.
     * If the slug exists, add -2, -3, etc.
     */
    private function uniqueSlugFromTitle(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        $existsQuery = Event::query()->where('slug', $slug);
        if ($ignoreId !== null) {
            $existsQuery->where('id', '!=', $ignoreId);
        }

        while ($existsQuery->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;

            $existsQuery = Event::query()->where('slug', $slug);
            if ($ignoreId !== null) {
                $existsQuery->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }
}
