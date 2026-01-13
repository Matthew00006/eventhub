@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Add Venue</h1>
    <a href="{{ route('venues.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('venues.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required
                >
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">City</label>
                    <input
                        type="text"
                        name="city"
                        class="form-control"
                        value="{{ old('city') }}"
                        required
                    >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Country</label>
                    <input
                        type="text"
                        name="country"
                        class="form-control"
                        value="{{ old('country') }}"
                        required
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address (optional)</label>
                <input
                    type="text"
                    name="address"
                    class="form-control"
                    value="{{ old('address') }}"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Description (optional)</label>
                <textarea
                    name="description"
                    class="form-control"
                    rows="4"
                >{{ old('description') }}</textarea>
            </div>

            <button class="btn btn-primary">Create Venue</button>
        </form>
    </div>
</div>
@endsection
