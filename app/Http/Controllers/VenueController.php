<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VenueController extends Controller
{
    /**
     * Display a listing of venues
     * Supports filtering and sorting
     */
    public function index(Request $request)
    {
        $query = Venue::query();

        
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // 🔃 Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name':
                    $query->orderBy('name');
                    break;
                case 'city':
                    $query->orderBy('city');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $venues = $query->paginate(10);

        return view('venues.index', compact('venues'));
    }

    /**
     * Show the form for creating a new venue
     */
    public function create()
    {
        return view('venues.create');
    }

    /**
     * Store a newly created venue
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'city' => 'required|string|max:80',
            'country' => 'required|string|max:80',
            'address' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:2000',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Venue::create($validated);

        return redirect()
            ->route('venues.index')
            ->with('success', 'Venue created successfully.');
    }

    /**
     * Display a specific venue (SEO slug)
     */
    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }

    /**
     * Show the form for editing a venue
     */
    public function edit(Venue $venue)
    {
        return view('venues.edit', compact('venue'));
    }

    /**
     * Update a venue
     */
    public function update(Request $request, Venue $venue)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'city' => 'required|string|max:80',
            'country' => 'required|string|max:80',
            'address' => 'nullable|string|max:200',
            'description' => 'nullable|string|max:2000',
        ]);

        // Regenerate slug if name changes
        if ($venue->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $venue->update($validated);

        return redirect()
            ->route('venues.index')
            ->with('success', 'Venue updated successfully.');
    }

    /**
     * Remove a venue
     */
    public function destroy(Venue $venue)
    {
        $venue->delete();

        return redirect()
            ->route('venues.index')
            ->with('success', 'Venue deleted successfully.');
    }
}
