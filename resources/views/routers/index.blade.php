@extends('layouts.adminhmd')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <!-- HEADER -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="h4 fw-bold mb-0">

                MikroTik Routers

            </h2>

            <a href="{{ route('routers.create') }}"
               class="btn btn-primary">

                Add Router

            </a>

        </div>

        <!-- SUCCESS -->

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show mb-4">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        <!-- ERROR -->

        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show mb-4">

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif

        <!-- TABLE -->

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>
                        <th>ISP client</th>

                        <th>Router Naming</th>
                        <th>IP Address</th>
                        <th>Username</th>
                        <th>Port</th>
                        <th>Status</th>
                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                

                    @forelse($routers as $router)

                        <tr>
                            <!-- LINKED ACCOUNT -->

<td class="ps-4">

    <div class="d-flex align-items-center gap-2">

        <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
             class="rounded-circle"
             width="40"
             height="40"
             style="object-fit:cover;">

        <div>

            <div class="fw-semibold">

                {{ $router->user->name ?? 'Unassigned' }}

            </div>

            <small class="text-muted">

                {{ ucfirst($router->user->role ?? 'No Role') }}

            </small>

        </div>

    </div>

</td>

                            <td>

                                {{ $router->name }}

                            </td>

                            <td>

                                {{ $router->ip_address }}

                            </td>

                            <td>

                                {{ $router->username }}

                            </td>

                            <td>

                                {{ $router->port }}

                            </td>

                            <td>

                                @if($router->is_active)

                                    <span class="badge text-bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge text-bg-danger">

                                        Disabled

                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="d-flex gap-2 flex-wrap">

                                    <!-- TEST -->

                                    <a href="{{ route('routers.test', $router->id) }}"
                                       class="btn btn-success btn-sm">

                                        Test

                                    </a>

                                    <!-- EDIT -->

                                    <a href="{{ route('routers.edit', $router->id) }}"
                                       class="btn btn-primary btn-sm">

                                        Edit

                                    </a>

                                    <!-- DELETE -->

                                    <form method="POST"
                                          action="{{ route('routers.destroy', $router->id) }}"
                                          onsubmit="return confirm('Delete this router?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-5">

                                No routers added yet.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>
            <!-- PAGINATION -->

    <div class="p-3 border-top">

        {{ $routers->withQueryString()->links() }}

    </div>

        </div>

    </div>

</div>

@endsection