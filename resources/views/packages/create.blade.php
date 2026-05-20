@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')
@include('partials.header')

@section('content')

<div class="max-w-2xl bg-white p-6 rounded-lg shadow border border-gray-200">

    <h1 class="text-2xl font-bold text-gray-800">Create Package</h1>
    <p class="text-sm text-gray-500 mb-6">
        Define the package price, duration, speed, and MikroTik hotspot profile.
    </p>

    @if($errors->any())
        <div class="bg-red-50 text-red-700 border border-red-200 p-3 rounded mb-4">
            @foreach($errors->all() as $error)
                <div>❌ {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('packages.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm mb-1 text-gray-700">Package Name</label>
            <input name="name"
                   value="{{ old('name') }}"
                   class="border rounded p-2 w-full"
                   placeholder="Example: 1 Hour Unlimited"
                   required>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">Price</label>
            <input name="price"
                   type="number"
                   value="{{ old('price') }}"
                   class="border rounded p-2 w-full"
                   placeholder="Example: 1000"
                   required>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1 text-gray-700">Duration</label>
                <input name="duration"
                       type="number"
                       min="1"
                       value="{{ old('duration') }}"
                       class="border rounded p-2 w-full"
                       placeholder="Example: 1"
                       required>
            </div>

            <div>
                <label class="block text-sm mb-1 text-gray-700">Duration Unit</label>
                <select name="duration_unit" class="border rounded p-2 w-full" required>
                    <option value="hour">Hour</option>
                    <option value="day">Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">Bandwidth / Speed (Down/Up) </label>
            <input name="bandwidth"
                   value="{{ old('bandwidth') }}"
                   class="border rounded p-2 w-full"
                   placeholder="Example: 2M/2M">
            <p class="text-xs text-gray-500 mt-1">
                This should match or guide your MikroTik rate limit. Example: 2M/2M.
            </p>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">MikroTik Profile Name</label>
            <input name="mikrotik_profile"
                   value="{{ old('mikrotik_profile') }}"
                   class="border rounded p-2 w-full"
                   placeholder="Example: 1hour"
                   required>
            <p class="text-xs text-gray-500 mt-1">
                Must match a Hotspot User Profile on MikroTik.
            </p>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="active" checked>
            <span class="text-sm text-gray-700">Active</span>
        </label>

        <div class="flex gap-2 pt-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Package
            </button>

            <a href="{{ route('packages.index') }}"
               class="px-4 py-2 rounded border text-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection