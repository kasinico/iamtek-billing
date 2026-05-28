hghghghghg```blade
@extends('layouts.adminhmd')

@section('title', 'Reports & Analytics')

@section('content')

<!-- PAGE HEADER -->

<div class="page-heading mb-4">

    <div class="page-heading-copy">

        <span class="page-icon">

            <i class="bi bi-bar-chart-fill"></i>

        </span>

        <div>

            <p class="eyebrow mb-1">

                Hotspot Analytics

            </p>

            <h1 class="h3 mb-1">

                Reports & Analytics

            </h1>

            <p class="text-muted mb-0">

                Monitor hotspot performance and voucher sales.

            </p>

        </div>

    </div>

</div>

<!-- TOP METRICS -->

<div class="row g-4 mb-4">

    <!-- REVENUE -->

    <div class="col-md-6 col-xl-4">

        <div class="metric-card success">

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

            </div>

        </div>

    </div>

    <!-- VOUCHERS -->

    <div class="col-md-6 col-xl-4">

        <div class="metric-card primary">

            <div class="metric-icon">

                <i class="bi bi-ticket-perforated"></i>

            </div>

            <div class="metric-content">

                <small class="metric-label">

                    Voucher Sales

                </small>

                <h3 class="metric-value">

                    {{ $voucherSales }}

                </h3>

            </div>

        </div>

    </div>

    <!-- ROUTERS -->

    <div class="col-md-6 col-xl-4">

        <div class="metric-card warning">

            <div class="metric-icon">

                <i class="bi bi-router-fill"></i>

            </div>

            <div class="metric-content">

                <small class="metric-label">

                    Active Routers

                </small>

                <h3 class="metric-value">

                    {{ $activeRouters }}

                </h3>

            </div>

        </div>

    </div>

</div>

<!-- CHARTS -->

<div class="row g-4">

    <!-- REVENUE -->

    <div class="col-xl-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-1">

                    Revenue Analytics

                </h5>

                <p class="text-muted mb-4">

                    Monthly hotspot revenue trends.

                </p>

                <div style="height:350px;">

                    <canvas id="revenueChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- WIFI USERS -->

    <div class="col-xl-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-1">

                    WiFi User Activity

                </h5>

                <p class="text-muted mb-4">

                    Weekly hotspot usage analytics.

                </p>

                <div style="height:350px;">

                    <canvas id="customerWifi"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

const revenueCtx =
document.getElementById('revenueChart');

new Chart(revenueCtx, {

    type: 'line',

    data: {

        labels: [

            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'

        ],

        datasets: [{

            label: 'Revenue (UGX)',

            data: @json($monthlyRevenue),

            borderColor: '#05096F',

            backgroundColor: 'rgba(5,9,111,0.1)',

            fill: true,

            borderWidth: 3,

            tension: 0.4

        }]

    }

});

const customerWifi =
document.getElementById('customerWifi');

new Chart(customerWifi, {

    type: 'bar',

    data: {

        labels: [

            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun'

        ],

        datasets: [{

            label: 'Active Sessions',

            data: [12, 19, 8, 14, 20, 9, 16],

            backgroundColor: '#05096F',

            borderRadius: 8

        }]

    }

});

</script>

@endpush
```
