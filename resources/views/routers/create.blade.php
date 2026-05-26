@extends('layouts.adminhmd')

@section('title', 'Add Router')

@section('content')

<!-- PAGE HEADER -->

<div class="page-heading">

    <div class="page-heading-copy">

        <span class="page-icon">

            <i class="bi bi-router-fill"></i>

        </span>

        <div>

            <p class="eyebrow mb-1">

                Network Infrastructure

            </p>

            <h1 class="h3 mb-1">

                Add MikroTik Router

            </h1>

            <p class="text-muted mb-0">

                Connect and manage MikroTik routers for hotspot billing.

            </p>

        </div>

    </div>

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

<!-- ERRORS -->

@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show mb-4">

        <strong>

            Please fix the following issues:

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

<!-- FORM -->

<div class="row">

    <div class="col-xl-8">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <form method="POST"
                      action="{{ route('routers.store') }}">

                    @csrf

                    <div class="row g-4">

                        <!-- ROUTER NAME -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                Router Name

                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="HQ Main Router"
                                   required>

                        </div>

                        <!-- IP -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                IP Address

                            </label>

                            <input type="text"
                                   name="ip_address"
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
                                   placeholder="Router password"
                                   required>

                        </div>

                        <!-- API PORT -->

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">

                                API Port

                            </label>

                            <input type="number"
                                   name="port"
                                   value="8728"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- ACTIVE -->

                        <div class="col-md-6 d-flex align-items-end">

                            <div class="form-check form-switch">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_active"
                                       checked>

                                <label class="form-check-label">

                                    Router Active

                                </label>

                            </div>

                        </div>

                    </div>

                    <!-- ACTIONS -->

                    <div class="d-flex gap-2 mt-5">

                        <button class="btn btn-primary">

                            <i class="bi bi-save"></i>

                            Save Router

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

    <!-- SIDE INFO -->

    <div class="col-xl-4">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5 class="fw-bold mb-3">

                    Router Connection Tips

                </h5>

                <ul class="small text-muted ps-3">

                    <li class="mb-2">

                        Ensure MikroTik API service is enabled.

                    </li>

                    <li class="mb-2">

                        Default API port is 8728.

                    </li>

                    <li class="mb-2">

                        Router must be reachable from server.

                    </li>

                    <li class="mb-2">

                        Use strong router passwords.

                    </li>

                    <li class="mb-2">

                        API-SSL can later use port 8729.

                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>

@endsection