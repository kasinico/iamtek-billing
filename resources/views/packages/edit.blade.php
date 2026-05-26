@extends('layouts.adminhmd')

@section('title', 'Edit Package')

@section('content')

<div class="max-w-2xl bg-white p-4 rounded shadow-sm border">

    <h1 class="h4 fw-bold mb-1">
        Edit Package
    </h1>

    <p class="text-muted mb-4">
        Update package price, duration, speed, and MikroTik profile.
    </p>

    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif

    <form method="POST"
          action="{{ route('packages.update', $package->id) }}">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label class="form-label">
                Package Name
            </label>

            <input name="name"
                   value="{{ old('name', $package->name) }}"
                   class="form-control"
                   required>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Price
            </label>

            <input name="price"
                   type="number"
                   value="{{ old('price', $package->price) }}"
                   class="form-control"
                   required>

        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Duration
                </label>

                <input name="duration"
                       type="number"
                       min="1"
                       value="{{ old('duration', $package->duration) }}"
                       class="form-control"
                       required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Duration Unit
                </label>

                <select name="duration_unit"
                        class="form-select"
                        required>

                    <option value="hour"
                        {{ $package->duration_unit === 'hour' ? 'selected' : '' }}>
                        Hour
                    </option>

                    <option value="day"
                        {{ $package->duration_unit === 'day' ? 'selected' : '' }}>
                        Day
                    </option>

                    <option value="week"
                        {{ $package->duration_unit === 'week' ? 'selected' : '' }}>
                        Week
                    </option>

                    <option value="month"
                        {{ $package->duration_unit === 'month' ? 'selected' : '' }}>
                        Month
                    </option>

                </select>

            </div>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Bandwidth / Speed
            </label>

            <input name="bandwidth"
                   value="{{ old('bandwidth', $package->bandwidth) }}"
                   class="form-control"
                   placeholder="Example: 2M/2M">

        </div>

        <div class="mb-3">

            <label class="form-label">
                MikroTik Profile
            </label>

            <input name="mikrotik_profile"
                   value="{{ old('mikrotik_profile', $package->mikrotik_profile) }}"
                   class="form-control"
                   required>

        </div>

        <div class="form-check mb-4">

            <input class="form-check-input"
                   type="checkbox"
                   name="active"
                   id="active"
                   {{ $package->active ? 'checked' : '' }}>

            <label class="form-check-label"
                   for="active">

                Active

            </label>

        </div>

        <div class="d-flex gap-2">

            <button class="btn btn-primary">

                Update Package

            </button>

            <a href="{{ route('packages.index') }}"
               class="btn btn-outline-secondary">

                Cancel

            </a>

        </div>

    </form>

</div>

@endsection