@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Venues</h1>
    <a href="{{ route('venues.create') }}" class="btn btn-primary">Add Venue</a>
</div>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <input
            type="text"
            name="city"
            value="{{ request('city') }}"
            class="form-control"
            placeholder="Filter by city"
        >
    </div>

    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">Sort by</option>
            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
            <option value="city" {{ request('sort') === 'city' ? 'selected' : '' }}>City</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-secondary">Apply</button>
        <a href="{{ route('venues.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

@if ($venues->count())
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Country</th>
                <th style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venues as $venue)
                <tr>
                    <td>{{ $venue->name }}</td>
                    <td>{{ $venue->city }}</td>
                    <td>{{ $venue->country }}</td>
                    <td>
                        <a href="{{ route('venues.show', $venue) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('venues.edit', $venue) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('venues.destroy', $venue) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this venue?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $venues->links() }}
@else
    <div class="alert alert-info">
        No venues found.
    </div>
@endif
@endsection
