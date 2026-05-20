@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')
@include('partials.header')


@section('content')

<div class="bg-white shadow rounded p-4 max-w-xl">
        <h2 class="text-xl font-bold mb-4">Edit MikroTik Router</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>

        @endif

        <form method='POST' action="{{route('routers.update', $router->id) }}">
            @csrf
        @method('PUT')

        <label class="block mb-2">Router Name</label>
        <input type="text" name="name" value="{{ $router->name }}" class="border p-2 w-full mb-4" required>

        <label class="block mb-2">IP Address</label>
        <input type="text" name="ip_address" value="{{ $router->ip_address }}" class="border p-2 w-full mb-4" required>

        <label class="block mb-2">Username</label>
        <input type="text" name="username" value="{{ $router->username }}" class="border p-2 w-full mb-4" required>

        <label class="block mb-2">Password</label>
        <input type="password" name="password" class="border p-2 w-full mb-1">
        <small class="text-gray-500 block mb-4">
            Leave blank to keep current password.
        </small>

        <label class="block mb-2">API Port</label>
        <input type="number" name="port" value="{{ $router->port }}" class="border p-2 w-full mb-4" required>

        <label class="flex items-center gap-2 mb-4">
            <input type="checkbox" name="is_active" {{ $router->is_active ? 'checked' : '' }}>
            Active
        </label>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update Router
        </button>

        <a href="{{ route('routers.index') }}" class="ml-2 text-gray-600">
            Cancel
        </a>
    </form>

</div>



dsssssssss

@endsection()
