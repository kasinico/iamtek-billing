<div class="tab-pane fade"
     id="vouchers">

    <div class="card border-0 shadow-sm">

        <div class="card-header">

            Voucher History

        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Code</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($vouchers as $voucher)

                    <tr>

                        <td>{{ $voucher->code }}</td>

                        <td>
                            UGX {{ number_format($voucher->price) }} - 
                                  {{ $voucher->package->name ?? 'N/A' }}

                        </td>

                        <td>
                            {{ strtoupper($voucher->status) }}
                        </td>

                        <td>
                            <!-- {{ $voucher->expires_at ?? '-' }} -->
                            {{ $voucher->created_at->format('d M Y') }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>