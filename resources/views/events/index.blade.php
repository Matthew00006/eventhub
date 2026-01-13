@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Events</h1>
    <a href="{{ route('events.create') }}" class="btn btn-primary">Add Event</a>
</div>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <select name="venue" class="form-select">
            <option value="">Filter by venue</option>
            @foreach ($venues as $venue)
                <option value="{{ $venue->id }}" {{ (string)request('venue') === (string)$venue->id ? 'selected' : '' }}>
                    {{ $venue->name }} ({{ $venue->city }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="Search title..."
        >
    </div>

    <div class="col-md-3">
        <select name="sort" class="form-select">
            <option value="">Sort by</option>
            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
            <option value="starts_at" {{ request('sort') === 'starts_at' ? 'selected' : '' }}>Start date</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-secondary w-100">Apply</button>
    </div>

    <div class="col-12">
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
    </div>
</form>

@if ($events->count())
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Venue</th>
                <th>Starts</th>
                <th style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->venue?->name }}</td>
                    <td>{{ $event->starts_at?->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('events.destroy', $event) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $events->links() }}
@else
    <div class="alert alert-info">
        No events found.
    </div>
@endif
@endsection
