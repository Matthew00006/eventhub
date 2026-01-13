@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Edit Event</h1>
    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Venue</label>
                <select name="venue_id" class="form-select" required>
                    @foreach ($venues as $venue)
                        <option value="{{ $venue->id }}"
                            {{ (old('venue_id', $event->venue_id) == $venue->id) ? 'selected' : '' }}>
                            {{ $venue->name }} ({{ $venue->city }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $event->title) }}"
                    required
                >
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Starts at</label>
                    <input
                        type="datetime-local"
                        name="starts_at"
                        class="form-control"
                        value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ends at (optional)</label>
                    <input
                        type="datetime-local"
                        name="ends_at"
                        class="form-control"
                        value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}"
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                >{{ old('description', $event->description) }}</textarea>
            </div>

            <button class="btn btn-primary">Update Event</button>
        </form>
    </div>
</div>
@endsection
