@extends('layouts.admin')
@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')
@include('partials.header')


@section('title', 'Dashboard')

@section('content')

<!-- dashboard cards/tables/charts -->
<h2 class="text-xl font-bold mb-4">ISP. Live Dashboard</h2>

<div class="grid grid-cols-4 gap-4">
    

    <div class="bg-white p-4 shadow rounded">
        <div>Total Vouchers</div>
        <div class="text-2xl font-bold"></div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <div>Used Vouchers</div>
        <div class="text-2xl font-bold"></div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <div>Active Users</div>
        <div class="text-2xl font-bold"></div>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <div>Routers</div>
        <div class="text-2xl font-bold"></div>hffffffffgjjjf
    </div>

</div>


  
<script src="{{ asset('assets/js/vendors/chart.js') }}"></script>


@endsection
