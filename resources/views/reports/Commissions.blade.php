@extends('layouts.adminhmd')

@section('title', 'Commission Report')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-warning text-dark">

            <h4 class="mb-0">

                ISP Clients Revenue Report

            </h4>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Shopkeeper</th>

                            <th>Vouchers Sold</th>

                            <th>Total Revenue</th>

                            <th>Platform Commission</th>

                            <th>Shopkeeper Earnings</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($sales as $sale)

                        <tr>

                            <td>

                                {{ $sale->creator->name ?? 'Unknown' }}

                            </td>

                            <td>

                                {{ $sale->vouchers_sold }}

                            </td>

                            <td>

                                UGX {{ number_format($sale->revenue) }}

                            </td>

                            <td>

                                UGX {{ number_format($sale->commission) }}

                            </td>

                            <td>

                                UGX {{ number_format($sale->earnings) }}

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
