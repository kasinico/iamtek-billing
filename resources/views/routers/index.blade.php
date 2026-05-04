@extends('layouts.admin')

@section('content')

<div class="bg-white shadow rounded p-4">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">MikroTik Routers</h2>

        <a href="{{ route('routers.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Router
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Name</th>
                <th class="p-2 border">IP Address</th>
                <th class="p-2 border">Username</th>
                <th class="p-2 border">Port</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($routers as $router)
                <tr>
                    <td class="p-2 border">{{ $router->name }}</td>
                    <td class="p-2 border">{{ $router->ip_address }}</td>
                    <td class="p-2 border">{{ $router->username }}</td>
                    <td class="p-2 border">{{ $router->port }}</td>

                    <td class="p-2 border">
                        @if($router->is_active)
                            <span class="text-green-600 font-bold">Active</span>
                        @else
                            <span class="text-red-600 font-bold">Disabled</span>
                        @endif
                    </td>


                    <td class="p-2 border">
                        <div class="flex gap-2 flex-wrap">

                            <a href="{{ route('routers.test', $router->id) }}"
                            class="bg-green-500 text-white px-2 py-1 rounded text-xs">
                                Test
                            </a>

                            <a href="{{ route('routers.edit', $router->id) }}"
                            class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                                Edit
                            </a>

                            <form method="POST"
                                action="{{ route('routers.destroy', $router->id) }}"
                                onsubmit="return confirm('Delete this router?')">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>

                    @if(session('error'))
    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

                    <!-- <td class="p-2 border flex gap-2">
                        <a href="{{ route('routers.edit', $router->id) }}"
                           class="text-blue-600">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('routers.destroy', $router->id) }}"
                              onsubmit="return confirm('Delete this router?')">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600">
                                Delete
                            </button>
                        </form>
                    </td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        No routers added yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection