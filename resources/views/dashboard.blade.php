@extends('layouts.admin')

@section('content')

<h2 class="text-xl font-bold mb-4">ISP Live Dashboard</h2>

<div class="grid grid-cols-4 gap-4">
    

    <div class="bg-white p-4 shadow rounded">
        <div>Total Vouchers</div>
        <div class="text-2xl font-bold">{{ $totalVouchers }}</div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <div>Used Vouchers</div>
        <div class="text-2xl font-bold">{{ $usedVouchers }}</div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <div>Active Users</div>
        <div class="text-2xl font-bold">{{ $activeVouchers }}</div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <div>Routers</div>
        <div class="text-2xl font-bold">{{ $routers }}</div>hffffffffgjjjf
    </div>

</div>

@endsection