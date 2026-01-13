@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Tickets</h1>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">Add Ticket</a>
</div>

<form method="GET" class="row g-3 mb-4">
    <div class="col-md-5">
        <select name="event" class="form-select">
            <option value="">Filter by event</option>
            @foreach ($events as $event)
                <option value="{{ $event->id }}"
                    {{ (string)request('event') === (string)$event->id ? 'selected' : '' }}>
                    {{ $event->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <select name="sort" class="form-select">
            <option value="">Sort by</option>
            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price (low → high)</option>
            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price (high → low)</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-secondary w-100">Apply</button>
    </div>

    <div class="col-12">
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
    </div>
</form>

@if ($tickets->count())
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Type</th>
                <th>Event</th>
                <th>Price</th>
                <th>Quantity</th>
                <th style="width: 220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->type }}</td>
                    <td>{{ $ticket->event?->title }}</td>
                    <td>€{{ $ticket->price }}</td>
                    <td>{{ $ticket->quantity }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('tickets.destroy', $ticket) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this ticket?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}
@else
    <div class="alert alert-info">
        No tickets found.
    </div>
@endif
@endsection
