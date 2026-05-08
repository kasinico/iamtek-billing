@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Page header --}}
    <!-- <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Vouchers</h1>
            <p class="text-gray-500 text-sm">Generate and manage hotspot vouchers.</p>
        </div>
    </div> -->

    

    {{-- Success message --}}
    @if(session('success'))
        <div class="border border-green-200 bg-green-50 text-green-700 px-4 py-3 rounded-lg">
             {{ session('success') }}
        </div>
    @endif

    {{-- Error message --}}
    @if(session('error'))
        <div class="border border-red-200 bg-red-50 text-red-700 px-4 py-3 rounded-lg">
             {{ session('error') }}
        </div>
    @endif

   {{-- Generate vouchers collapsible card --}}
    <details id="generateBox" class="bg-white shadow rounded-lg border border-gray-200" {{ $errors->any() ? 'open' : '' }}>
        <summary class="cursor-pointer list-none px-4 py-4 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-gray-800">Generate Vouchers</h2>
                <p class="text-xs text-gray-500">Click to open or hide the voucher generator.</p>
            </div>

            <span class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
                Generate
            </span>
        </summary>

        <div class="border-t border-gray-200 px-4 py-4">
            <form id="generateForm" method="POST" action="{{ route('vouchers.generate') }}" class="grid md:grid-cols-4 gap-4">
                @csrf

                <div>
                    <label class="block text-sm mb-1 text-gray-700">Package</label>
                    <select name="package_id" required class="border rounded p-2 w-full">
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}">
                                {{ $package->name }} - {{ $package->price }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700">Router</label>
                    <select name="router_id" required class="border rounded p-2 w-full">
                        <option value="">Select Router</option>
                        @foreach($routers as $router)
                            <option value="{{ $router->id }}">
                                {{ $router->name }} ({{ $router->ip_address }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-700">Quantity</label>
                    <input type="number" name="quantity" value="10" min="1" max="1000"
                           class="border rounded p-2 w-full" required>
                </div>

               
                <div class="flex items-end">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                        Generate Now
                    </button>
                </div>
            </form>
        </div>
    </details>

    <div class="bg-white shadow rounded p-4">

        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="font-semibold">Recent Vouchers</h2>
                <p class="text-xs text-gray-500">Showing latest generated vouchers.</p>
            </div>

            @if($vouchers->count() && $vouchers->first()->batch_id)
                <a href="{{ route('vouchers.printBatch', $vouchers->first()->batch_id) }}"
                   target="_blank"
                   class="bg-gray-800 text-white px-3 py-2 rounded text-sm">
                    Print Latest Batch
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-2 border">Code</th>
                        <th class="p-2 border">Username</th>
                        <th class="p-2 border">Password</th>
                        <th class="p-2 border">Package</th>
                        <th class="p-2 border">Router</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Created</th>
                        <th class="p-2 border">Print</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($vouchers as $voucher)
                        <tr>
                            <td class="p-2 border font-mono">{{ $voucher->code }}</td>
                            <td class="p-2 border font-mono">{{ $voucher->username }}</td>
                            <td class="p-2 border font-mono">{{ $voucher->password }}</td>
                            <td class="p-2 border">{{ $voucher->package->name ?? 'N/A' }}</td>
                            <td class="p-2 border">{{ $voucher->router->name ?? 'N/A' }}</td>

                            
                            <td class="p-2 border">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($voucher->status == 'unused') bg-yellow-100 text-yellow-700
                                    @elseif($voucher->status == 'active') bg-blue-100 text-blue-700
                                    @elseif($voucher->status == 'expired') bg-blue-100 text-red-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ strtoupper($voucher->status) }}
                                </span>
                            </td>

                            <td class="p-2 border">
                                {{ $voucher->created_at->format('Y-m-d H:i') }}
                            </td>

                            <td class="p-2 border">
                                <a href="{{ route('voucher.print', $voucher->id) }}"
                                   class="text-blue-600">
                                    Print
                                </a>
                            </td>
                            <td>

                             <form method="POST"
                                action="{{ route('voucher.destroy', $voucher->id) }}"
                                onsubmit="return confirm('Delete this voucher?')">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-2 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </form>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">
                                No vouchers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $vouchers->links() }}
        </div>

    </div>

</div>



@endsection 





