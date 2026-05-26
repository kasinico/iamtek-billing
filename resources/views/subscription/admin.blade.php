@extends('layouts.adminhmd')

@section('title', 'Subscription Management')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            Subscription Management

        </h3>

        <p class="text-muted mb-0">

            Manage ISP client subscriptions, invoices and activation.

        </p>

    </div>

</div>

<!-- ANALYTICS -->

<div class="row g-4 mb-4">

    <!-- ACTIVE -->

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">

                    Active Subscriptions

                </small>

                <h2 class="fw-bold text-success mt-2">

                    {{ $activeSubscriptions }}

                </h2>

            </div>

        </div>

    </div>

    <!-- TRIAL -->

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">

                    Trial Accounts

                </small>

                <h2 class="fw-bold text-warning mt-2">

                    {{ $trialAccounts }}

                </h2>

            </div>

        </div>

    </div>

    <!-- EXPIRED -->

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">

                    Expired Accounts

                </small>

                <h2 class="fw-bold text-danger mt-2">

                    {{ $expiredAccounts }}

                </h2>

            </div>

        </div>

    </div>

    <!-- DUE -->

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <small class="text-muted">

                    Expiring Soon

                </small>

                <h2 class="fw-bold text-primary mt-2">

                    {{ $expiringSoon }}

                </h2>

            </div>

        </div>

    </div>

</div>

<!-- FILTERS -->

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET"
              class="row g-3">

            <!-- SEARCH -->

            <div class="col-md-4">

                <input type="search"
                       name="search"
                       class="form-control"
                       placeholder="Search name or phone..."
                       value="{{ request('search') }}">

            </div>

            <!-- STATUS -->

            <div class="col-md-3">

                <select name="status"
                        class="form-select">

                    <option value="">

                        All Status

                    </option>

                    <option value="trial"
                        {{ request('status') == 'trial' ? 'selected' : '' }}>

                        Trial

                    </option>

                    <option value="active"
                        {{ request('status') == 'active' ? 'selected' : '' }}>

                        Active

                    </option>

                    <option value="expired"
                        {{ request('status') == 'expired' ? 'selected' : '' }}>

                        Expired

                    </option>

                    <option value="suspended"
                        {{ request('status') == 'suspended' ? 'selected' : '' }}>

                        Suspended

                    </option>

                </select>

            </div>

            <!-- COUNTRY -->

            <div class="col-md-3">

                <select name="country"
                        class="form-select">

                    <option value="">

                        All Countries

                    </option>

                    <option value="UG"
                        {{ request('country') == 'UG' ? 'selected' : '' }}>

                        Uganda

                    </option>

                    <option value="KE"
                        {{ request('country') == 'KE' ? 'selected' : '' }}>

                        Kenya

                    </option>

                    <option value="PH"
                        {{ request('country') == 'PH' ? 'selected' : '' }}>

                        Philippines

                    </option>

                </select>

            </div>

            <!-- BUTTON -->

            <div class="col-md-2">

                <button class="btn btn-primary w-100">

                    Filter

                </button>

            </div>

        </form>

    </div>

</div>

<!-- TABLE -->

<div class="card border-0 shadow-sm">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="ps-4">

                            Client

                        </th>

                        <th>

                            Phone

                        </th>

                        <th>

                            Country

                        </th>

                        <th>

                            Status

                        </th>

                        <th>

                            Trial Ends

                        </th>

                        <th>

                            Subscription Ends

                        </th>

                        <th>

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                    <tr>

                        <!-- NAME -->

                        <td class="ps-4">

                            <div class="fw-semibold">

                                {{ $user->name }}

                            </div>

                            <small class="text-muted">

                                {{ $user->email }}

                            </small>

                        </td>

                        <!-- PHONE -->

                        <td>

                            {{ $user->phone ?? 'N/A' }}

                        </td>

                        <!-- COUNTRY -->

                        <td>

                            {{ $user->country ?? 'UG' }}

                        </td>

                        <!-- STATUS -->

                        <td>

                            @if($user->subscription_status == 'active')

                                <span class="badge bg-success">

                                    ACTIVE

                                </span>

                            @elseif($user->subscription_status == 'trial')

                                <span class="badge bg-warning text-dark">

                                    TRIAL

                                </span>

                            @elseif($user->subscription_status == 'expired')

                                <span class="badge bg-danger">

                                    EXPIRED

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    SUSPENDED

                                </span>

                            @endif

                        </td>

                        <!-- TRIAL -->

                        <td>

                            {{ $user->trial_ends_at ?? 'N/A' }}

                        </td>

                        <!-- SUB -->

                        <td>

                            {{ $user->subscription_ends_at ?? 'N/A' }}

                        </td>

                        <!-- ACTION -->

                        <td>

                            <div class="d-flex gap-2">

                                <!-- ACTIVATE -->

                                @if($user->subscription_status !== 'active')

                                <button type="button"
        class="btn btn-success btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#activateModal{{ $user->id }}">

    Activate

</button>

                                @endif

                                <!-- SUSPEND -->

                                @if($user->subscription_status === 'active')

                                <form method="POST"
                                      action="{{ route('subscription.suspend', $user->id) }}">

                                    @csrf

                                    <button class="btn btn-danger btn-sm">

                                        Suspend

                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>


                    

                    @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-5 text-muted">

                            No subscription records found.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>


            @foreach($users as $user)

<!-- ACTIVATE MODAL -->

<div class="modal fade"
     id="activateModal{{ $user->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Activate Subscription

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form method="POST"
                  action="{{ route('subscription.manual.activate', $user->id) }}">

                @csrf

                <div class="modal-body">

                    <!-- DURATION TYPE -->

                    <div class="mb-3">

                        <label class="form-label">

                            Duration Type

                        </label>

                        <select name="duration_type"
                                class="form-select">

                            <option value="days">

                                Days

                            </option>

                            <option value="months">

                                Months

                            </option>

                            <option value="years">

                                Years

                            </option>

                        </select>

                    </div>

                    <!-- VALUE -->

                    <div class="mb-3">

                        <label class="form-label">

                            Duration Value

                        </label>

                        <input type="number"
                               name="duration_value"
                               class="form-control"
                               value="1"
                               min="1">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button class="btn btn-success">

                        Activate

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach

            

        </div>

    </div>

    <!-- PAGINATION -->

    <div class="card-footer bg-white">

        {{ $users->withQueryString()->links() }}

    </div>

</div>

@endsection