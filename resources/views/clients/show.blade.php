@extends('layouts.adminhmd')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    @include('clients.tabs.header')

    {{-- Navigation --}}
    <ul class="nav nav-tabs mb-4">

        <li class="nav-item">
            <button class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#overview">
                Overview
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#routers">
                Routers
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#customers">
                Customers
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#vouchers">
                Vouchers
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#transactions">
                Transactions
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#subscription">
                Subscription
            </button>
        </li>

        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#activity">
                Activity
            </button>
        </li>

    </ul>

    <div class="tab-content">

        @include('clients.tabs.overview')

        @include('clients.tabs.routers')

        @include('clients.tabs.customers')

        @include('clients.tabs.vouchers')

        @include('clients.tabs.transactions')

        @include('clients.tabs.subscription')

        @include('clients.tabs.activity')

    </div>

</div>






    <div class="card-body">

        <div class="table-responsive">

            

      

</div>


</div>

    



</div>


</div>
@endsection

