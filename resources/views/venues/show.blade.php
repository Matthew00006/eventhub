@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $venue->name }}</h1>
    <div>
        <a href="{{ route('venues.edit', $venue) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('venues.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Venue Details</h5>

                <p class="mb-1"><strong>City:</strong> {{ $venue->city }}</p>
                <p class="mb-1"><strong>Country:</strong> {{ $venue->country }}</p>

                @if ($venue->address)
                    <p class="mb-1"><strong>Address:</strong> {{ $venue->address }}</p>
                @endif

                @if ($venue->description)
                    <hr>
                    <p class="mb-0">{{ $venue->description }}</p>
                @else
                    <hr>
                    <p class="text-muted mb-0">No description provided.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Events at this venue</h5>
                    <a href="{{ route('events.create') }}" class="btn btn-sm btn-primary">Add Event</a>
                </div>

                <hr>

                @php
                    $events = $venue->events()->orderBy('starts_at')->take(5)->get();
                @endphp

                @if ($events->count())
                    <ul class="list-group">
                        @foreach ($events as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $event->title }}</div>
                                    <small class="text-muted">
                                        {{ $event->starts_at?->format('Y-m-d H:i') }}
                                    </small>
                                </div>

                                <a class="btn btn-sm btn-outline-info" href="{{ route('events.show', $event) }}">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('events.index', ['venue' => $venue->id]) }}" class="btn btn-outline-secondary btn-sm">
                            View all events for this venue
                        </a>
                    </div>
                @else
                    <p class="text-muted mb-0">No events yet for this venue.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<form action="{{ route('venues.destroy', $venue) }}" method="POST" onsubmit="return confirm('Delete this venue?');">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Delete Venue</button>
</form>
@endsection
