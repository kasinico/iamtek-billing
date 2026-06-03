@extends('layouts.adminhmd')

@section('title', 'Customers')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">

            Customers

        </h2>

        <p class="text-muted mb-0">

            Manage hotspot and PPPoE customers.

        </p>

    </div>

</div>

<!-- =========================================================
STATS
========================================================= -->

<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">

                    Total Customers

                </small>

                <h3 class="fw-bold">

                    {{ $totalCustomers }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">

                    Active Customers

                </small>

                <h3 class="fw-bold text-success">

                    {{ $activeCustomers }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <small class="text-muted">

                    Expired Customers

                </small>

                <h3 class="fw-bold text-danger">

                    {{ $expiredCustomers }}

                </h3>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
TABLE
========================================================= -->

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Voucher ID</th>
                        <th>Phone</th>
                        <th>Package</th>
                        <th>Router</th>
                        <th>Status</th>
                        <th>MAC Address  </th>
                        <th>Expiry</th>
                        <th class="text-end">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($customers as $customer)

                        <tr>
<!-- make customer name open profile -->
                            <td>

                                    <a href="{{ route('customers.show', $customer->id) }}"
                                    class="fw-bold text-decoration-none">

                                        {{ $customer->name }}

                                    </a>

                            </td>

                            <td>

                                {{ $customer->phone ?? '-' }}

                            </td>

                            <td>

                                {{ $customer->package->name ?? '-' }}

                            </td>

                            <td>

                                {{ $customer->router->name ?? '-' }}

                            </td>

                            <td>

                                @if($customer->status === 'active')

                                    <span class="badge text-bg-success">

                                        Active

                                    </span>

                                @elseif($customer->status === 'expired')

                                    <span class="badge text-bg-danger">

                                        Expired

                                    </span>

                                @else

                                    <span class="badge text-bg-secondary">

                                        {{ ucfirst($customer->status) }}

                                    </span>

                                @endif

                            </td>
                            <td>  {{ $customer->mac_address ?? '-' }}
  </td>

                            <td>

                                {{ optional($customer->expires_at)->format('d M Y H:i') }}

                            </td>

                            <td class="text-end">

                                <button class="btn btn-warning btn-sm text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCustomerModal{{ $customer->id }}">

                                    Edit

                                </button>

                                <form method="POST"
                                      action="{{ route('customers.destroy', $customer->id) }}"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @include('customers.partials.edit-modal')

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted py-4">

                                No customers found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

