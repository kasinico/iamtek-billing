@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')

@section('content')



<section class="panel">

    <div class="page-heading">

    <div class="page-heading-copy">

        <span class="page-icon">

            <i class="bi bi-people"></i>

        </span>

        <div>
           

            <h1 class="h3 mb-1">

                Manage ISP Clients

            </h1>

            <p class="text-muted mb-0">

                Review accounts, subscriptions and access.

            </p>

        </div>

    </div>

    <!-- RIGHT SIDE -->

    <div class="heading-actions">

        <button class="btn btn-primary btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#addUserModal">

            <i class="bi bi-person-plus"></i>

            Add Client

        </button>

    </div>

</div>

    
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show mb-4"
         role="alert">

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if($errors->any())

    <div class="alert alert-danger">

        <strong>

            Please correct the following:

        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

    <div class="table-responsive">
    <form role="search"
      method="GET"
      id="searchForm">

    <div class="d-flex gap-2">

        <input class="form-control search-input"
               type="search"
               name="search"
               id="searchInput"
               placeholder="Search users by name..."
               value="{{ request('search') }}">

        

    </div>

</form>

<script>

const searchInput =
    document.getElementById('searchInput');

searchInput.addEventListener('input', function () {

    clearTimeout(window.searchTimer);

    window.searchTimer = setTimeout(() => {

        document.getElementById('searchForm').submit();

    }, 500);

});

</script>

        <table class="table align-middle mb-0">

            <thead>

                <tr>

                    <th>
                        User
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Role
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Joined
                    </th>

                    <th class="text-end">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <!-- USER -->

                        <td>

                            <div class="d-flex align-items-center gap-2">

                                <img class="avatar-img avatar-sm"
                                     src="{{ asset('assets/images/avatar/avatar-1.jpg') }}"
                                     alt="User">

                                <div>

                                    <p class="fw-semibold mb-0">

                                        {{ $user->name }}

                                    </p>

                                    <p class="text-muted small mb-0">

                                        ID #{{ $user->id }}

                                    </p>

                                </div>

                            </div>

                        </td>

                        <!-- EMAIL -->

                        <td>

                            {{ $user->email }}

                        </td>

                        <!-- ROLE -->

                        <!-- <td>

                            <span class="badge text-bg-dark">

                                {{ ucfirst($user->role) }}

                            </span>

                        </td> -->
                        <td>

    @if($user->role === 'admin')

        <span class="badge text-bg-dark">

           IAMTEK ADMIN

        </span>

    @else

        <span class="badge text-bg-primary">

           ISP CLIENT

        </span>

    @endif

</td>

                        <!-- STATUS -->

                        <td>

                            @if($user->status == 'active')

                                <span class="badge text-bg-success">

                                    ACTIVE

                                </span>

                            @elseif($user->status == 'pending')

                                <span class="badge text-bg-warning">

                                    PENDING

                                </span>

                            @else

                                <span class="badge text-bg-danger">

                                    DISABLED

                                </span>

                            @endif

                        </td>

                        <!-- CREATED -->

                        <td>

                            {{ $user->created_at->format('d M Y') }}

                        </td>

                        <!-- ACTIONS -->

                        <td class="text-end">

                            <div class="d-flex justify-content-end gap-1">

                                @if($user->status == 'pending')

                                    <a href="{{ url('/admin/users/'.$user->id.'/approve') }}"
                                       class="btn btn-success btn-sm">

                                        Approve

                                    </a>

                                @endif

                                @if($user->status == 'active')

                                    <a href="{{ url('/admin/users/'.$user->id.'/disable') }}"
                                       class="btn btn-danger btn-sm">

                                        Disable

                                    </a>

                                @endif

                                @if($user->status == 'disabled')

                                    <a href="{{ url('/admin/users/'.$user->id.'/enable') }}"
                                       class="btn btn-primary btn-sm">

                                        Enable

                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-4 text-muted">

                            No users found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

        <div class="modal fade"
     id="addUserModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Add Client

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form method="POST"
                  action="{{ route('admin.users.store') }}">

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">

                                Name

                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Email

                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="col-md-6">

    <label class="form-label fw-semibold">

        Phone Number

    </label>

    <input type="tel"
           name="phone"
           class="form-control @error('phone') is-invalid @enderror"
           placeholder="+256700000000"
           maxlength="15"
           minlength="10"
           pattern="[0-9+]+"
           value="{{ old('phone') }}"
           required>

    <small class="text-muted">

        Example: +256700000000

    </small>

    @error('phone')

        <div class="invalid-feedback d-block">

            {{ $message }}

        </div>

    @enderror

</div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Country

                            </label>

                            <select name="country"
                                    class="form-select">

                                <option value="UG">

                                    Uganda

                                </option>

                                <option value="KE">

                                    Kenya

                                </option>

                                <option value="PH">

                                    Philippines

                                </option>

                            </select>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">

                                Password

                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>

                        </div>

                        <!-- ACCOUNT TYPE -->

<div class="col-md-6">

    <label class="form-label fw-semibold">

        Account Type

    </label>

    <select name="role"
            class="form-select"
            required>

        <option value="shopkeeper">

            ISP Client 

        </option>

        <option value="admin">

            Iamtek Admin / Staff

        </option>

    </select>

</div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button class="btn btn-primary">

                        Create Client

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

    </div>
 <!-- PAGINATION -->

    <div class="p-3 border-top">

        {{ $users->withQueryString()->links() }}

    </div>

</section>

@if($errors->any())

<script>

    document.addEventListener('DOMContentLoaded', function () {

        let modal =
            new bootstrap.Modal(
                document.getElementById('addUserModal')
            );

        modal.show();

    });

</script>

@endif


@endsection