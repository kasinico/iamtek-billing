@extends('layouts.adminhmd')

@section('title', 'Subscription')

@section('content')

<div class="row g-4">

    <!-- STATUS -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Subscription Status

                        </h5>

                        <p class="text-muted mb-0">

                            IAMTEK Billing Access

                        </p>

                    </div>

                    <span class="badge bg-danger">

                        {{ strtoupper(auth()->user()->subscription_status) }}

                    </span>

                </div>

                <hr>

                @if(auth()->user()->subscription_status === 'expired')

                    <div class="alert alert-danger">

                        Your free trial has expired.

                    </div>

                @endif

                @if(auth()->user()->subscription_status === 'suspended')

                    <div class="alert alert-warning">

                        Your subscription is suspended.

                    </div>

                @endif

                <div class="mt-3">

                    <h3 class="fw-bold">

                        UGX 5000

                    </h3>

                    <small class="text-muted">

                        Monthly subscription

                    </small>

                </div>

                <button class="btn btn-primary mt-4 w-100">

                    Pay Now

                </button>

            </div>

        </div>

    </div>

    <!-- INVOICE -->

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Current Invoice

                        </h5>

                        <p class="text-muted mb-0">

                            March 2026

                        </p>

                    </div>

                    <span class="badge bg-danger">

                        OVERDUE

                    </span>

                </div>

                <div class="table-responsive">

                    <table class="table">

                        <tbody>

                            <tr>

                                <td>
                                    Subtotal
                                </td>

                                <td class="text-end">
                                    UGX 0
                                </td>

                            </tr>

                            <tr>

                                <td>
                                    Minimum charge applied
                                </td>

                                <td class="text-end">
                                    UGX 5000
                                </td>

                            </tr>

                            <tr class="fw-bold">

                                <td>
                                    Total Due
                                </td>

                                <td class="text-end">
                                    UGX 5000
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="d-flex gap-2 mt-4">

                    <button class="btn btn-success">

                        Pay via M-Pesa

                    </button>

                    <button class="btn btn-outline-secondary">

                        View Invoice

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
<br>
<div class="col-md-3">

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <small class="text-muted">

                Active Subscriptionss

            </small>

            <h3 class="fw-bold">


            </h3>

        </div>

    </div>

</div>

<div class="card border-0 shadow-sm mt-4">

    <div class="card-body">

        <h5 class="fw-bold mb-4">

            Subscription History

        </h5>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>

                            Start

                        </th>

                        <th>

                            End

                        </th>

                        <th>

                            Duration

                        </th>

                        <th>

                            Amount

                        </th>

                        <th>

                            Status

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($subscriptions as $subscription)

                    <tr>

                        <td>

                            {{ $subscription->starts_at }}

                        </td>

                        <td>

                            {{ $subscription->ends_at }}

                        </td>

                        <td>

                            {{ $subscription->duration_value }}

                            {{ ucfirst($subscription->duration_type) }}

                        </td>

                        <td>

                            UGX {{ number_format($subscription->amount) }}

                        </td>

                        <td>

                            <span class="badge bg-success">

                                {{ strtoupper($subscription->status) }}

                            </span>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection