@extends('layouts.adminhmd')

@section('title', 'Profile')

@section('content')

<div class="page-heading">

    <div class="page-heading-copy">

        <span class="page-icon">

            <i class="bi bi-person-badge"></i>

        </span>

        <div>

            <p class="eyebrow mb-1">
                Account
            </p>

            <h1 class="h3 mb-1">
                Profile
            </h1>

            <p class="text-muted mb-0">
                Manage your IAMTEK account settings and security.
            </p>

        </div>

    </div>

</div>

<section class="row g-3">

    <!-- PROFILE CARD -->

    <div class="col-12 col-xl-4">

        <div class="panel h-100 text-center profile-card">

            <div class="profile-cover">

                <img src="{{ asset('assets/images/png/dasher-ui-bootstrap-5.jpg') }}"
                     alt="Cover">

            </div>

            <img class="avatar-img avatar-xl profile-photo"
                 src="{{ asset('assets/images/avatar/avatar.jpg') }}"
                 alt="User">

            <h2 class="h5 mt-3 mb-1">

                {{ auth()->user()->name }}

            </h2>

            <p class="text-muted mb-3">

                {{ ucfirst(auth()->user()->role) }}

            </p>

            <div class="d-flex justify-content-center gap-2">

                <span class="badge text-bg-primary">

                    {{ ucfirst(auth()->user()->role) }}

                </span>

                <span class="badge text-bg-success">

                    {{ ucfirst(auth()->user()->status) }}

                </span>

            </div>

            <div class="info-list mt-4 text-start">

                <div>

                    <span>Email</span>

                    <strong>
                        {{ auth()->user()->email }}
                    </strong>

                </div>

                <div>

                    <span>Joined</span>

                    <strong>
                        {{ auth()->user()->created_at->format('d M Y') }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

    <!-- PROFILE SETTINGS -->

    <div class="col-12 col-xl-8">

        <!-- UPDATE PROFILE -->

        <div class="panel mb-3">

            <div class="panel-header">

                <div>

                    <h2 class="h5 mb-1 section-title">

                        <i class="bi bi-person-gear"></i>

                        <span>
                            Profile Information
                        </span>

                    </h2>

                    <p class="text-muted mb-0">

                        Update your account details.

                    </p>

                </div>

            </div>

            @include('profile.partials.update-profile-information-form')

        </div>

        <!-- UPDATE PASSWORD -->

        <div class="panel mb-3">

            <div class="panel-header">

                <div>

                    <h2 class="h5 mb-1 section-title">

                        <i class="bi bi-shield-lock"></i>

                        <span>
                            Update Password
                        </span>

                    </h2>

                    <p class="text-muted mb-0">

                        Change your account password.

                    </p>

                </div>

            </div>

            @include('profile.partials.update-password-form')

        </div>

        <!-- DELETE ACCOUNT -->

        <div class="panel">

            <div class="panel-header">

                <div>

                    <h2 class="h5 mb-1 section-title text-danger">

                        <i class="bi bi-trash"></i>

                        <span>
                            Delete Account
                        </span>

                    </h2>

                    <p class="text-muted mb-0">

                        Permanently remove this account.

                    </p>

                </div>

            </div>

            @include('profile.partials.delete-user-form')

        </div>

    </div>

</section>

@endsection