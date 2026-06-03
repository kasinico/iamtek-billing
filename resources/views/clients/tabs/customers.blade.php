<div class="tab-pane fade"
     id="customers">

    <div class="card border-0 shadow-sm">

        <div class="card-header">

            Customers

        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($customers as $customer)

                    <tr>

                        <td>{{ $customer->name }}</td>

                        <td>{{ $customer->phone }}</td>

                        <td>

                            <span class="badge bg-success">

                                {{ $customer->status }}

                            </span>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>