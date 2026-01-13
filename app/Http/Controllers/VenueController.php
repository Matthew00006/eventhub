<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Support\Str;
use App\Http\Requests\StoreVenueRequest;
use App\Http\Requests\UpdateVenueRequest;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::query();

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

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

    public function create()
    {
        return view('venues.create');
    }

    public function store(StoreVenueRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        Venue::create($data);

        return redirect()
            ->route('venues.index')
            ->with('success', 'Venue created successfully.');
    }

    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }

    public function edit(Venue $venue)
    {
        return view('venues.edit', compact('venue'));
    }

    public function update(UpdateVenueRequest $request, Venue $venue)
    {
        $data = $request->validated();

        if ($venue->name !== $data['name']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $venue->update($data);

        return redirect()
            ->route('venues.index')
            ->with('success', 'Venue updated successfully.');
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();

        return redirect()
            ->route('venues.index')
            ->with('success', 'Venue deleted successfully.');
    }
}
