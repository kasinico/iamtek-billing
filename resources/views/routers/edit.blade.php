@extends('layouts.adminhmd')

@section('title', 'Edit Router')

@section('content')

<!-- PAGE HEADER -->

<div class="page-heading mb-4">

    <div class="page-heading-copy">

        <span class="page-icon">

            <i class="bi bi-router-fill"></i>

        </span>

        <div>

            <p class="eyebrow mb-1">

                Infrastructure Management

            </p>

            <h1 class="h3 mb-1">

                Edit MikroTik Router

            </h1>

            <p class="text-muted mb-0">

                Update router connection settings, API access and operational status.

            </p>

        </div>

    </div>

</div>

<!-- ERROR ALERT -->

@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show mb-4">

        <strong>

            Please correct the following issues:

        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif

<div class="row g-4">

    <!-- FORM SECTION -->

    <div class="col-xl-8">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <form method="POST"
                      action="{{ route('routers.update', $router->id) }}">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <!-- ROUTER NAME -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Router Name

                            </label>

                            <input type="text"
                                   name="name"
                                   value="{{ $router->name }}"
                                   class="form-control"
                                   placeholder="HQ Main Router"
                                   required>

                        </div>

                        <!-- IP ADDRESS -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                IP Address

                            </label>

                            <input type="text"
                                   name="ip_address"
                                   value="{{ $router->ip_address }}"
                                   class="form-control"
                                   placeholder="192.168.100.1"
                                   required>

                        </div>

                        <!-- USERNAME -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Username

                            </label>

                            <input type="text"
                                   name="username"
                                   value="{{ $router->username }}"
                                   class="form-control"
                                   placeholder="admin"
                                   required>

                        </div>

                        <!-- PASSWORD -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Password

                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Leave blank to keep existing password">

                            <small class="text-muted">

                                Existing password will remain unchanged if left empty.

                            </small>

                        </div>

                        <!-- API PORT -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                API Port

                            </label>

                            <input type="number"
                                   name="port"
                                   value="{{ $router->port }}"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- ACTIVE SWITCH -->

                        <div class="col-md-6 d-flex align-items-end">

                            <div class="form-check form-switch">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_active"
                                       {{ $router->is_active ? 'checked' : '' }}>

                                <label class="form-check-label fw-semibold">

                                    Router Active

                                </label>

                            </div>

                        </div>

                    </div>

                    <!-- ACTIONS -->

                    <div class="d-flex gap-2 mt-5">

                        <button class="btn btn-primary">

                            <i class="bi bi-save"></i>

                            Update Router

                        </button>

                        <a href="{{ route('routers.index') }}"
                           class="btn btn-light border">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- SIDEBAR INFO -->

    <div class="col-xl-4">

        <!-- ROUTER STATUS -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">

                        Router Status

                    </h5>

                    @if($router->is_active)

                        <span class="badge text-bg-success">

                            ONLINE

                        </span>

                    @else

                        <span class="badge text-bg-danger">

                            OFFLINE

                        </span>

                    @endif

                </div>

                <div class="small text-muted">

                    Current router configuration and operational state.

                </div>

            </div>

        </div>

        <!-- SECURITY PANEL -->

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5 class="fw-bold mb-3">

                    Security Recommendations

                </h5>

                <ul class="small text-muted ps-3 mb-0">

                    <li class="mb-2">

                        Use strong API credentials.

                    </li>

                    <li class="mb-2">

                        Restrict API access by firewall rules.

                    </li>

                    <li class="mb-2">

                        Consider API-SSL on port 8729.

                    </li>

                    <li class="mb-2">

                        Monitor failed login attempts regularly.

                    </li>

                    <li class="mb-2">

                        Ensure router firmware remains updated.

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

@endsection