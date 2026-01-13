@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Add Ticket</h1>
    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Event</label>
                <select name="event_id" class="form-select" required>
                    <option value="">Select event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}"
                            {{ (old('event_id', $selectedEventId) == $event->id) ? 'selected' : '' }}>
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
                    value="{{ old('type') }}"
                    placeholder="Standard / VIP / Student..."
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
                        value="{{ old('quantity') }}"
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
                        value="{{ old('price') }}"
                        step="0.01"
                        min="0"
                        required
                    >
                </div>
            </div>

            <button class="btn btn-primary">Create Ticket</button>
        </form>
    </div>
</div>
@endsection
