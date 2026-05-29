@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Packages</h1>
            <p class="text-sm text-gray-500">
                Manage hotspot internet packages, duration, speed, and MikroTik profile.
            </p>
        </div>

        <a href="{{ route('packages.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            Create Package
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 border border-green-200 p-3 rounded-lg">
             {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 text-red-700 border border-red-200 p-3 rounded-lg">
             {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden table-responsive">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left">Client User</th>
                         <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Price</th>
                        <th class="p-3 text-left">Duration</th>
                        <th class="p-3 text-left">Bandwidth</th>
                        <th class="p-3 text-left">MikroTik Profile</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($packages as $package)
                        <tr class="border-t hover:bg-gray-50">
                                                   <!-- LINKED ACCOUNT -->

<td class="ps-4">

    <div class="d-flex align-items-center gap-2">

        <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
             class="rounded-circle"
             width="40"
             height="40"
             style="object-fit:cover;">

        <div>

            <div class="fw-semibold">

                {{ $package->user->name ?? 'Unassigned' }}

            </div>

            <small class="text-muted">

                {{ ucfirst($package->user->role ?? 'No Role') }}

            </small>

        </div>

    </div>

</td>

                            <td class="p-3 font-medium">
                                {{ $package->name }}
                            </td>

                            <td class="p-3">
                                UGX {{ number_format($package->price) }}
                            </td>

                            <td class="p-3">
                                {{ $package->duration }} {{ $package->duration_unit }}
                                <div class="text-xs text-gray-400">
                                    {{ $package->duration_in_hours }} hour(s)
                                </div>
                            </td>

                            <td class="p-3">
                                {{ $package->bandwidth ?? '-' }}
                            </td>

                            <td class="p-3 font-mono">
                                {{ $package->mikrotik_profile ?? '-' }}
                            </td>

                            <td class="p-3">
                                @if($package->active)
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                        Disabled
                                    </span>
                                @endif
                            </td>

                            <td class="p-3">
                                <div class="flex gap-3">
                                    <a href="{{ route('packages.edit', $package->id) }}"
                                       class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('packages.destroy', $package->id) }}"
                                          onsubmit="return confirm('Delete this package?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">
                                No packages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t">
            {{ $packages->links() }}
        </div>
    </div>

</div>

@endsection