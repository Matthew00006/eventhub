@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $event->title }}</h1>
    <div>
        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Event Details</h5>

                <p class="mb-1">
                    <strong>Venue:</strong>
                    <a href="{{ route('venues.show', $event->venue) }}">
                        {{ $event->venue?->name }}
                    </a>
                </p>

                <p class="mb-1">
                    <strong>Starts:</strong>
                    {{ $event->starts_at?->format('Y-m-d H:i') }}
                </p>

                @if ($event->ends_at)
                    <p class="mb-1">
                        <strong>Ends:</strong>
                        {{ $event->ends_at->format('Y-m-d H:i') }}
                    </p>
                @endif

                @if ($event->description)
                    <hr>
                    <p class="mb-0">{{ $event->description }}</p>
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
                    <h5 class="card-title mb-0">Tickets</h5>
                    <a href="{{ route('tickets.create', ['event_id' => $event->id]) }}"
                       class="btn btn-sm btn-primary">
                        Add Ticket
                    </a>
                </div>

                <hr>

                @if ($event->tickets->count())
                    <ul class="list-group">
                        @foreach ($event->tickets as $ticket)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $ticket->type }}</div>
                                    <small class="text-muted">
                                        €{{ $ticket->price }} • Qty: {{ $ticket->quantity }}
                                    </small>
                                </div>

                                <a href="{{ route('tickets.show', $ticket) }}"
                                   class="btn btn-sm btn-outline-info">
                                    View
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No tickets added for this event yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<form action="{{ route('events.destroy', $event) }}"
      method="POST"
      onsubmit="return confirm('Delete this event?');">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Delete Event</button>
</form>
@endsection
