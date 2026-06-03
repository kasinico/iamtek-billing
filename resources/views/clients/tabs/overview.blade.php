<div class="tab-pane fade show active"
     id="overview">

    <div class="row g-3">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Total Revenue</small>
                    <h4 class="text-success">
                        UGX {{ number_format($revenue) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Platform Commission</small>
                    <h4 class="text-warning">
                        UGX {{ number_format($commission) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>ISP Earnings</small>
                    <h4 class="text-primary">
                        UGX {{ number_format($earnings) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Vouchers Sold</small>
                    <h4>{{ $usedVouchers }}</h4>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mt-2">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Customers</small>
                    <h4>{{ $totalCustomers }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Active Customers</small>
                    <h4 class="text-success">
                        {{ $activeCustomers }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Expired Customers</small>
                    <h4 class="text-danger">
                        {{ $expiredCustomers }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small>Routers</small>
                    <h4>{{ $routers->count() }}</h4>
                </div>
            </div>
        </div>

    </div>








</div>
