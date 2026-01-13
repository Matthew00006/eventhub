@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Edit Ticket</h1>
    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.update', $ticket) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select" required>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}"
                            {{ (old('event_id', $ticket->event_id) == $event->id) ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ticket Type</label>
                <input
                    type="text"
                    name="type"
                    class="form-control"
                    value="{{ old('type', $ticket->type) }}"
                    required
                >
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Quantity</label>
                    <input
                        type="number"
                        name="quantity"
                        class="form-control"
                        value="{{ old('quantity', $ticket->quantity) }}"
                        min="1"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Price (€)</label>
                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        value="{{ old('price', $ticket->price) }}"
                        step="0.01"
                        min="0"
                        required
                    >
                </div>
            </div>

            <button class="btn btn-primary">Update Ticket</button>
        </form>
    </div>
</div>
@endsection
