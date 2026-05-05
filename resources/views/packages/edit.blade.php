@extends('layouts.admin')

@section('content')

<div class="max-w-2xl bg-white p-6 rounded-lg shadow border border-gray-200">

    <h1 class="text-2xl font-bold text-gray-800">Edit Package</h1>
    <p class="text-sm text-gray-500 mb-6">
        Update package price, duration, speed, and MikroTik profile.
    </p>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 border border-red-200 p-3 rounded mb-4">
            @foreach($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('packages.update', $package->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm mb-1 text-gray-700">Package Name</label>
            <input name="name"
                   value="{{ old('name', $package->name) }}"
                   class="border rounded p-2 w-full"
                   required>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">Price</label>
            <input name="price"
                   type="number"
                   value="{{ old('price', $package->price) }}"
                   class="border rounded p-2 w-full"
                   required>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1 text-gray-700">Duration</label>
                <input name="duration"
                       type="number"
                       min="1"
                       value="{{ old('duration', $package->duration) }}"
                       class="border rounded p-2 w-full"
                       required>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700">Duration Unit</label>
                <select name="duration_unit" class="border rounded p-2 w-full" required>
                    <option value="hour" {{ $package->duration_unit === 'hour' ? 'selected' : '' }}>Hour</option>
                    <option value="day" {{ $package->duration_unit === 'day' ? 'selected' : '' }}>Day</option>
                    <option value="week" {{ $package->duration_unit === 'week' ? 'selected' : '' }}>Week</option>
                    <option value="month" {{ $package->duration_unit === 'month' ? 'selected' : '' }}>Month</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">Bandwidth / Speed Limit</label>
            <input name="bandwidth"
                   value="{{ old('bandwidth', $package->bandwidth) }}"
                   class="border rounded p-2 w-full"
                   placeholder="Example: 2M/2M">
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">MikroTik Profile Name</label>
            <input name="mikrotik_profile"
                   value="{{ old('mikrotik_profile', $package->mikrotik_profile) }}"
                   class="border rounded p-2 w-full"
                   required>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="active" {{ $package->active ? 'checked' : '' }}>
            <span class="text-sm text-gray-700">Active</span>
        </label>

        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update Package
            </button>

            <a href="{{ route('packages.index') }}"
               class="px-4 py-2 rounded border text-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection