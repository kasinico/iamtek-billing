<div class="tab-pane fade"
     id="transactions">

    <div class="card border-0 shadow-sm">

        <div class="card-header">

            Financial Transactions

        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Date</th>
                        <th>Voucher</th>
                        <th>Revenue</th>
                        <th>Commission</th>
                        <th>Earnings</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($transactions as $transaction)

                    <tr>

                        <td>
                            {{ $transaction->created_at }}
                        </td>

                        <td>
                            {{ $transaction->code }}
                        </td>

                        <td>
                            UGX {{ number_format($transaction->price) }}
                        </td>

                        <td>
                            UGX {{ number_format($transaction->commission_amount) }}
                        </td>

                        <td>
                            UGX {{ number_format($transaction->shopkeeper_amount) }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>