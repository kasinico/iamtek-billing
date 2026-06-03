<div class="tab-pane fade"
     id="routers">

    <div class="card border-0 shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Router Infrastructure
            </h5>

        </div>

        <div class="card-body">

            <div class="mb-3">

                <span class="badge bg-success">
                    Online: {{ $onlineRouters }}
                </span>

                <span class="badge bg-danger">
                    Offline: {{ $offlineRouters }}
                </span>

            </div>

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>IP</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($routers as $router)

                    <tr>

                        <td>{{ $router->name }}</td>

                        <td>{{ $router->ip_address }}</td>

                        <td>

                            @if($router->is_active)

                            <span class="badge bg-success">
                                Online
                            </span>

                            @else

                            <span class="badge bg-danger">
                                Offline
                            </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>