@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')

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

            <span class="btn btn-primary">
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
                    <button class="btn btn-primary">
                        Generate Now
                    </button>
                </div>
            </form>
        </div>
    </details>



</div>



         




<section class="panel mt-3">

    <div class="panel-header">

        <div>

            <h2 class="h5 mb-1 section-title">

                <i class="bi bi-ticket-perforated" aria-hidden="true"></i>

                <span>Recent Vouchers</span>

            </h2>

            <p class="text-muted mb-0">
                Latest generated hotspot vouchers.
            </p>

        </div>

        @if($vouchers->count() && $vouchers->first()->batch_id)

            <a class="btn btn-outline-secondary btn-sm"
               href="{{ route('vouchers.printBatch', $vouchers->first()->batch_id) }}"
               target="_blank">

                Print Latest Batch

            </a>

        @endif

    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>

                <tr>

                    <th scope="col">
                        Voucher
                    </th>
                    <th scope="col">
                        Password
                    </th>

                    <th scope="col">
                        Package
                    </th>

                    <th scope="col">
                        Router
                    </th>

                    <th scope="col">
                        Status
                    </th>

                    <th scope="col">
                        Created
                    </th>
                    <th scope="col">
                        Expires
                    </th>


                    <th scope="col"
                        class="text-end">

                        Actions

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($vouchers as $voucher)

                    <tr>

                        <!-- USER / VOUCHER -->

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                

                                <div>

                                    <p class="fw-semibold mb-0">

                                        {{ $voucher->username }}

                                    </p>

                                    <p class="text-muted small mb-0">

                                        {{ $voucher->code }}

                                    </p>

                                </div>

                            </div>

                        </td>

                        <!-- PACKAGE -->

                         <td>

                            {{ $voucher->password }}

                        </td>


                        <td>

                            {{ $voucher->package->name ?? 'N/A' }}

                        </td>

                        <!-- ROUTER -->

                        <td>

                            {{ $voucher->router->name ?? 'N/A' }}

                        </td>

                        <!-- STATUS -->

                        <td>

                            @if($voucher->status == 'unused')

                                <span class="badge text-bg-warning">

                                    UNUSED

                                </span>

                            @elseif($voucher->status == 'active')

                                <span class="badge text-bg-primary">

                                    ACTIVE

                                </span>

                            @elseif($voucher->status == 'used')

                                <span class="badge text-bg-success">

                                    USED

                                </span>

                            @elseif($voucher->status == 'expired')

                                <span class="badge text-bg-danger">

                                    EXPIRED

                                </span>

                            @else

                                <span class="badge text-bg-secondary">

                                    {{ strtoupper($voucher->status) }}

                                </span>

                            @endif

                        </td>

                        <!-- CREATED -->

                        <td>

                            {{ $voucher->created_at->format('d M Y H:i') }}

                        </td>



                         <!-- expired -->
                       <td>
                        
@if($voucher->status === 'unused')

    <span class="badge text-bg-warning">

        Pending Activation

    </span>

@elseif($voucher->status === 'active')

    <span class="badge text-bg-primary">

        Active Session

    </span>

@elseif($voucher->status === 'used')

    <span class="badge text-bg-success">

        Used & Expired

    </span>

@endif



                            <!-- @if($voucher->expires_at)

                                <span class="badge text-bg-info">

                                    {{ $voucher->expires_at->format('d M Y H:i') }}

                                </span>

                            @else

                                <span class="badge text-bg-secondary">

                                    Pending Activation

                                </span>

                            @endif -->

                        </td>

                        <!-- ACTIONS -->

                        <td class="text-end">

                            <div class="d-flex justify-content-end gap-1">

                                <!-- PRINT -->

                                <a class="btn btn-light btn-sm"
                                   href="{{ route('voucher.print', $voucher->id) }}"
                                   target="_blank">

                                    Print

                                </a>

                                <!-- DELETE -->

                                <form method="POST"
                                      action="{{ route('voucher.destroy', $voucher->id) }}"
                                      onsubmit="return confirm('Delete this voucher?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-4 text-muted">

                            No vouchers found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->

    <div class="p-3 border-top">

        {{ $vouchers->links() }}

    </div>

</section>

@endsection 

