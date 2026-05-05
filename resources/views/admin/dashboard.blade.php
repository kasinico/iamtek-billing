@extends('layouts.admin')

@section('content')

<div class="p-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">ISP Live Dashboard</h1>
        <p class="text-gray-500">Real-time voucher usage & system overview</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- totalVouchers -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-gray-500">Total Vouchers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalVouchers }}</h2>
        </div>
<!-- new tiles start -->

        <div class="bg-yellow-50 p-4 shadow rounded">
            <div class="text-gray-500 text-sm">Unused</div>
            <div class="text-2xl font-bold">{{ $unusedVouchers }}</div> 
        </div>

        <div class="bg-blue-50 p-4 shadow rounded">
            <div class="text-gray-500 text-sm">Active</div>
            <div class="text-2xl font-bold">{{ $activeVouchers }}</div>
        </div>

        <div class="bg-green-50 p-4 shadow rounded">
            <div class="text-gray-500 text-sm">Used</div>
            <div class="text-2xl font-bold">{{ $usedVouchers }}</div>
        </div>
<!-- new tiles end -->


        <!-- My Vouchers -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-gray-500">My Vouchers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $myVouchers }}</h2>
        </div>

        

        <!-- Used -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-green-500">
            <p class="text-gray-500">Used Vouchers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $usedVouchers }}</h2>
        </div>

        <!-- Active Sessions -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-purple-500">
            <p class="text-gray-500">Active Sessions</p>
            <h2 class="text-3xl font-bold mt-2">{{ $activeSessions }}</h2>
        </div>

        <!-- Routers -->
        <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-orange-500">
            <p class="text-gray-500">Routers</p>
            <h2 class="text-3xl font-bold mt-2">{{ $routers }}</h2>
        </div>

    </div>

    <!-- Analytics Section -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Chart Placeholder -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">Usage Analytics</h3>
            <div class="h-64 flex items-center justify-center text-gray-400">
                Chart (integrate Chart.js / ApexCharts)
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">Recent Activity</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li>✔ Voucher created successfully</li>
                <li>✔ User logged into hotspot</li>
                <li>✔ Router connected</li>
            </ul>
        </div>

    </div>

</div>



    

</div>

@endsection