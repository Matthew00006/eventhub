@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ $ticket->type }} Ticket</h1>
    <div>
        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Ticket Details</h5>

        <p class="mb-1">
            <strong>Event:</strong>
            <a href="{{ route('events.show', $ticket->event) }}">
                {{ $ticket->event?->title }}
            </a>
        </p>

        <p class="mb-1">
            <strong>Venue:</strong>
            <a href="{{ route('venues.show', $ticket->event->venue) }}">
                {{ $ticket->event->venue?->name }}
            </a>
        </p>

        <p class="mb-1">
            <strong>Price:</strong> €{{ $ticket->price }}
        </p>

        <p class="mb-1">
            <strong>Quantity available:</strong> {{ $ticket->quantity }}
        </p>
    </div>
</div>

<form action="{{ route('tickets.destroy', $ticket) }}"
      method="POST"
      onsubmit="return confirm('Delete this ticket?');">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Delete Ticket</button>
</form>
@endsection
