@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Add Event</h1>
    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('events.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Venue</label>
                <select name="venue_id" class="form-select" required>
                    <option value="">Select venue</option>
                    @foreach ($venues as $venue)
                        <option value="{{ $venue->id }}"
                            {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
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
                    value="{{ old('title') }}"
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
                        value="{{ old('starts_at') }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Ends at (optional)</label>
                    <input
                        type="datetime-local"
                        name="ends_at"
                        class="form-control"
                        value="{{ old('ends_at') }}"
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                >{{ old('description') }}</textarea>
            </div>

            <button class="btn btn-primary">Create Event</button>
        </form>
    </div>
</div>
@endsection
