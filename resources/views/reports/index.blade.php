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

                Business Intelligence

            </p>

            <h1 class="h3 mb-1">

                Reports & Analytics

            </h1>

            <p class="text-muted mb-0">

                Monitor revenue, customer growth and hotspot activity.

            </p>

        </div>

    </div>

</div>

<!-- TOP METRICS -->

<div class="row g-4 mb-4">

    <!-- REVENUE -->

    <div class="col-md-6 col-xl-3">

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

    <div class="col-md-6 col-xl-3">

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

    <!-- CUSTOMERS -->

    <div class="col-md-6 col-xl-3">

        <div class="metric-card purple">

            <div class="metric-icon">

                <i class="bi bi-people-fill"></i>

            </div>


            <div class="metric-content">

                <small class="metric-label">

                    Customer Growth

                </small>

                <h3 class="metric-value">

                    {{ $customerGrowth }}

                </h3>

            </div>

        </div>

    </div>

    <!-- ROUTERS -->

    <div class="col-md-6 col-xl-3">

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
@if(auth()->user()->role === 'admin')
    <!-- Your HTML code for admin reports goes here -->
    
<!-- CHARTS -->

<div class="row g-4">

    <!-- REVENUE ANALYTICS -->

    <div class="col-xl-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Revenue Analytics

                        </h5>

                        <p class="text-muted mb-0">

                            Monthly hotspot revenue trends.

                        </p>

                    </div>

                </div>

                <div style="height:350px;">

                    <canvas id="revenueChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <!-- CUSTOMER GROWTH -->

    <div class="col-xl-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Customer Growth

                </h5>

                <div style="height:350px;">

                    <canvas id="customerChart"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

@elseif(auth()->user()->role === 'shopkeeper')
    <!-- Manager Content -->
<h5 class="fw-bold mb-4">

    WiFi User Activity

</h5>


<!-- isp client reports ------------------------------------------->


<div class="row g-4">

    <!-- REVENUE ANALYTICS -->

    <div class="col-xl-8">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">

                            Revenue Analytics

                        </h5>

                        <p class="text-muted mb-0">

                            Monthly hotspot revenue trends.

                        </p>

                    </div>

                </div>

                <div style="height:350px;">

                    <canvas id="revenueChart"></canvas>

                </div>

            </div>

        </div>

        

    </div>
      <div class="col-xl-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

    WiFi User Activity

</h5>

                <div style="height:350px;">

                    <canvas id="customerChart"></canvas>

                </div>

            </div>

        </div>

    </div>

@endif



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
            'june',
            'July',
            'Aug',
            'Sept',
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

const customerCtx =
document.getElementById('customerChart');

new Chart(customerCtx, {

    type: 'doughnut',

    data: {

        labels: [
            'Active',
            'Trial',
            'Suspended',
            // 'expired'
        ],

        datasets: [{

    data: @json($customerStats),

    backgroundColor: [

        '#198754',
        '#ffc107',
        '#dc3545',
        '#dc5987'

    ],

    borderWidth: 0

}]

    }

});

// isp client wifi bars
const customerWifi =
document.getElementById('customerWifi');

new Chart(customerCtx, {

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

    data: @json($customerStats),

    backgroundColor: [

        '#198754',
        '#ffc107',
        '#dc3545',
        '#dc5987'

    ],

    borderWidth: 0

}]

    }

});

</script>

@endpush