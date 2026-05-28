@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')

@section('title', 'IAMTEK Admin Dashboard')

@section('content')

<!-- =========================================================
IAMTEK ENTERPRISE ADMIN DASHBOARD
========================================================= -->

<div class="dashboard-overview mb-4">

    <!-- =========================================================
    PAGE HEADER
    ========================================================= -->

    <div class="page-heading mb-4">

        <div class="page-heading-copy">

            <!-- ORANGE ICON -->
            <span class="page-icon bg-warning text-white shadow-sm">

                <i class="bi bi-speedometer2"></i>

            </span>

            <div>

                <h1 class="h3 fw-bold mb-1">

                    Hello, {{ auth()->user()->name }}

                </h1>

                <p class="text-muted mb-1">

                    Administration Dashboard

                </p>

                <!-- LIVE DATE -->
                <small class="text-muted">

                    <span id="eat-date"></span>

                    •

                    <span id="eat-time"></span> EAT

                </small>

            </div>

        </div>

        <!-- ACTION BUTTONS -->

        <div class="heading-actions d-flex gap-2">

            <button class="btn btn-outline-secondary btn-sm">

                <i class="bi bi-download"></i>

                Export

            </button>

            <button class="btn btn-warning btn-sm text-white">

                <i class="bi bi-file-earmark-plus"></i>

                Generate Report

            </button>

        </div>

    </div>

    <!-- =========================================================
    LIVE NETWORK OPERATIONS CENTER METRICS
    ========================================================= -->

    <div class="row g-3 mb-4">

        <!-- ONLINE ROUTERS -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-success h-100">

                <div class="metric-icon">

                    <i class="bi bi-wifi"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Online Routers

                    </small>

                    <h3 class="metric-value">

                        {{ $onlineRouters }}

                    </h3>

                    <small class="text-muted">

                        Infrastructure online

                    </small>

                </div>

            </div>

        </div>

        <!-- OFFLINE ROUTERS -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-danger h-100">

                <div class="metric-icon">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Offline Routers

                    </small>

                    <h3 class="metric-value">

                        {{ $offlineRouters }}

                    </h3>

                    <small class="text-muted">

                        Require investigation

                    </small>

                </div>

            </div>

        </div>

        <!-- HOTSPOT USERS -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-warning h-100">

                <div class="metric-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Active Hotspot Users

                    </small>

                    <h3 class="metric-value">

                        {{ $activeHotspotUsers }}

                    </h3>

                    <small class="text-muted">

                        Connected clients

                    </small>

                </div>

            </div>

        </div>

        <!-- CPU LOAD -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-primary h-100">

                <div class="metric-icon">

                    <i class="bi bi-cpu-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Average CPU Load

                    </small>

                    <h3 class="metric-value">

                        {{ $avgCpuLoad }}%

                    </h3>

                    <small class="text-muted">

                        Router processing usage

                    </small>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================================================
    BUSINESS ANALYTICS
    ========================================================= -->

    <div class="row g-3 mb-4">

        <!-- TOTAL REVENUE -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-success h-100">

                <div class="metric-icon">

                    <i class="bi bi-cash-stack"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Total Revenue

                    </small>

                    <h3 class="metric-value">

                        UGX {{ number_format($totalRevenue) }}

                    </h3>

                    <small class="text-muted">

                        Successful voucher sales

                    </small>

                </div>

            </div>

        </div>

        <!-- COMMISSION -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-warning h-100">

                <div class="metric-icon">

                    <i class="bi bi-wallet2"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Total Commission

                    </small>

                    <h3 class="metric-value">

                        UGX {{ number_format($totalCommission) }}

                    </h3>

                    <small class="text-muted">

                        Generated commission

                    </small>

                </div>

            </div>

        </div>

        <!-- TOTAL ROUTERS -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-dark h-100">

                <div class="metric-icon">

                    <i class="bi bi-router-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Total Routers

                    </small>

                    <h3 class="metric-value">

                        {{ $routers }}

                    </h3>

                    <small class="text-muted">

                        Registered devices

                    </small>

                </div>

            </div>

        </div>

        <!-- MY ROUTERS -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-info h-100">

                <div class="metric-icon">

                    <i class="bi bi-hdd-network-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        My Routers

                    </small>

                    <h3 class="metric-value">

                        {{ $myRouters }}

                    </h3>

                    <small class="text-muted">

                        Linked to your account

                    </small>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================================================
    VOUCHER ANALYTICS
    ========================================================= -->

    <div class="row g-3 mb-4">

        <!-- TOTAL -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-primary h-100">

                <div class="metric-icon">

                    <i class="bi bi-ticket-perforated-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Total Vouchers

                    </small>

                    <h3 class="metric-value">

                        {{ $totalVouchers }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- UNUSED -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-warning h-100">

                <div class="metric-icon">

                    <i class="bi bi-hourglass-split"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Unused

                    </small>

                    <h3 class="metric-value">

                        {{ $unusedVouchers }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- ACTIVE -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-info h-100">

                <div class="metric-icon">

                    <i class="bi bi-lightning-charge-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Active

                    </small>

                    <h3 class="metric-value">

                        {{ $activeVouchers }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- USED -->

        <div class="col-md-6 col-xl-3">

            <div class="metric-card metric-success h-100">

                <div class="metric-icon">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

                <div class="metric-content">

                    <small class="metric-label">

                        Used

                    </small>

                    <h3 class="metric-value">

                        {{ $usedVouchers }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- =========================================================
    LIVE ROUTER STATUS PANEL
    ========================================================= -->

    <div class="panel mb-4">

        <div class="panel-header">

            <div>

                <h2 class="h5 fw-bold mb-1">

                    Live Router Monitoring

                </h2>

                <p class="text-muted mb-0">

                    Real-time MikroTik infrastructure health.

                </p>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>

                    <tr>

                        <th>Router</th>
                        <th>Status</th>
                        <th>CPU</th>
                        <th>Hotspot Users</th>
                        <th>Uptime</th>
                        <th>Last Seen</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($routerStatuses as $status)

                        <tr>

                            <td>

                                {{ $status->identity ?? 'Unknown Router' }}

                            </td>

                            <td>

                                @if($status->is_online)

                                    <span class="badge text-bg-success">

                                        Online

                                    </span>

                                @else

                                    <span class="badge text-bg-danger">

                                        Offline

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $status->cpu_load }}%

                            </td>

                            <td>

                                {{ $status->active_hotspot_users }}

                            </td>

                            <td>

                                {{ $status->uptime }}

                            </td>

                            <td>

                                {{ $status->last_seen_at }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-4">

                                No router monitoring data yet.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- =========================================================
LIVE EAT CLOCK
========================================================= -->

<script>

function updateEATTime() {

    const now = new Date();

    const optionsDate = {

        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        timeZone: 'Africa/Nairobi'

    };

    const optionsTime = {

        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true,
        timeZone: 'Africa/Nairobi'

    };

    document.getElementById('eat-date').innerHTML =
        now.toLocaleDateString('en-UG', optionsDate);

    document.getElementById('eat-time').innerHTML =
        now.toLocaleTimeString('en-UG', optionsTime);

}

updateEATTime();

setInterval(updateEATTime, 1000);

</script>

@endsection

