@extends('layouts.adminhmd')

@section('title', 'Customer Profile')

@section('content')

<div class="container-fluid">

    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small>Name</small>

                    <h5>{{ $customer->name }}</h5>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small>Phone</small>

                    <h5>{{ $customer->phone }}</h5>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small>Status</small>

                    <h5>

                        <span class="badge bg-success">

                            {{ strtoupper($customer->status) }}

                        </span>

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small>Total Spend</small>

                    <h5>

                        UGX {{ number_format($totalSpend) }}

                    </h5>

                </div>

            </div>

        </div>

    </div>

    {{-- LIVE SESSION --}}

<div class="row mb-4">

    <div class="col-md-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header">

                <strong>

                    Live Session

                </strong>

            </div>

            <div class="card-body">

                @if($liveSession)

                    <div class="row">

                        <div class="col-md-4">

                            <p>

                                <strong>Status:</strong>

                                <span class="badge bg-success">

                                    Online

                                </span>

                            </p>

                            <p>

                                <strong>IP Address:</strong>

                                {{ $liveSession['address'] }}

                            </p>

                            <p>

                                <strong>MAC Address:</strong>

                                {{ $liveSession['mac-address'] }}

                            </p>

                        </div>

                        <div class="col-md-4">

                            <p>

                                <strong>Router:</strong>

                                {{ $customer->router->name ?? '-' }}

                            </p>

                            <p>

                                <strong>Login Time:</strong>

                                Active

                            </p>

                            <p>

                                <strong>Uptime:</strong>

                                {{ $liveSession['uptime'] }}

                            </p>

                        </div>

                        <div class="col-md-4">

                            <p>

                                <strong>Download:</strong>

                                {{ number_format(($liveSession['bytes-in'] ?? 0) / 1024 / 1024,2) }}

                                MB

                            </p>

                            <p>

                                <strong>Upload:</strong>

                                {{ number_format(($liveSession['bytes-out'] ?? 0) / 1024 / 1024,2) }}

                                MB

                            </p>

                        </div>

                    </div>

                @else

                    <div class="alert alert-secondary mb-0">

                        Customer currently offline

                    </div>

                @endif

            </div>

        </div>

    </div>

        <div class="col-md-4">

        <div class="card border-0 shadow-sm">

            <div class="card-header">

                <strong>

                    Actions

                </strong>

            </div>

            <div class="card-body d-grid gap-2">

                <button
                    class="btn btn-warning">

                    Edit Customer

                </button>

                <button
                    class="btn btn-danger"
                    disabled>

                    Disconnect User

                </button>

                <a
                    href="#"
                    class="btn btn-primary">

                    View Router

                </a>

                <a
                    href="#voucher-history"
                    class="btn btn-outline-secondary">

                    View Voucher History

                </a>

            </div>

        </div>

    </div>

</div>

    {{-- CUSTOMER DETAILS --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header">

            Customer Details

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p>

                        <strong>Username:</strong>

                        {{ $customer->username }}

                    </p>

                    <p>

                        <strong>Router:</strong>

                        {{ $customer->router->name ?? '-' }}

                    </p>

                    <p>

                        <strong>Package:</strong>

                        {{ $customer->package->name ?? '-' }}

                    </p>

                </div>

                <div class="col-md-6">

                    <p>

                        <strong>MAC:</strong>

                        {{ $customer->mac_address }}

                    </p>

                    <p>

                        <strong>Expiry:</strong>

                        {{ optional($customer->expires_at)->format('d M Y H:i') }}

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- VOUCHER HISTORY --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header">

            Voucher History

        </div>

        <div class="card-body">

            <table class="table">

                <thead>

                    <tr>

                        <th>Voucher</th>
                        <th>Price</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($vouchers as $voucher)

                    <tr>

                        <td>

                            {{ $voucher->code }}

                        </td>

                        <td>

                            UGX {{ number_format($voucher->price) }}

                        </td>

                        <td>

                            {{ strtoupper($voucher->status) }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <div class="card border-0 shadow-sm">

    <div class="card-header">

        Session History

    </div>

    <div class="card-body">

        <table class="table table-striped">

            <thead>

                <tr>

                    <th>Login</th>

                    <th>Logout</th>

                    <th>IP Address</th>

                    <th>MAC Address</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($sessions as $session)

                <tr>

                    <td>

                        {{ $session->login_at }}

                    </td>

                    <td>

                        {{ $session->logout_at ?? '-' }}

                    </td>

                    <td>

                        {{ $session->ip_address }}

                    </td>

                    <td>

                        {{ $session->mac_address }}

                    </td>

                    <td>

                        {{ strtoupper($session->status) }}

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5">

                        No session history found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection