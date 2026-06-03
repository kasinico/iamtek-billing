<div class="tab-pane fade"
     id="subscription">

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <h5>

                Subscription Information

            </h5>

            <hr>

            <p>

                Status:
                <strong>

                    {{ ucfirst($subscriptionStatus) }}

                </strong>

            </p>

            <p>

                Current Plan:
                <strong>

                    Premium

                </strong>

            </p>

        </div>

    </div>


    <!-- subscriptions details -->

    
<div class="col-md-3">

@php

$daysLeft = null;

if(auth()->user()->subscription_ends_at){

    $daysLeft =
        now()->diffInDays(
            auth()->user()->subscription_ends_at,
            false
        );

}

@endphp

   <div class="alert alert-info mt-3">

    @if($daysLeft > 0)

        <strong>

            Subscription Active

        </strong>

        —

        {{ floor($daysLeft) }} days remaining.

    @elseif($daysLeft <= 0)

        <strong>

            Subscription Expired

        </strong>

        —

        Please renew to continue service.

    @endif

</div>

</div>



<div class="card border-0 shadow-sm mt-4">

    <div class="card-body">

        <h5 class="fw-bold mb-4">

            Subscription History

        </h5>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>

                            Start

                        </th>

                        <th>

                            End

                        </th>

                        <th>

                            Duration

                        </th>

                        <th>

                            Amount

                        </th>

                        <th>

                            Status

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($subscriptions as $subscription)

                    <tr>

                        <td>

                            {{ $subscription->starts_at }}

                        </td>

                        <td>

                            {{ $subscription->ends_at }}

                        </td>

                        <td>

                            {{ $subscription->duration_value }}

                            {{ ucfirst($subscription->duration_type) }}

                        </td>

                        <td>

                            UGX {{ number_format($subscription->amount) }}

                        </td>

                        <td>

                            <span class="badge bg-success">

                                {{ strtoupper($subscription->status) }}

                            </span>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>






</div>