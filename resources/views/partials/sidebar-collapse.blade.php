<!-- sidebar-collapse -->

<aside class="admin-sidebar"
       id="adminSidebar">
    <!-- BRAND -->

    <div class="sidebar-header">

        <a class="brand-mark text-decoration-none"
           href="{{ route('dashboard') }}">

           

            <span class="brand-icon">
                <i class="bi bi-router-fill"></i>
            </span>

            <span class="brand-copy">

                <span class="brand-title">
                    IAMTEK
                </span>

                <span class="brand-subtitle">
                    Billing Platform
                </span>

            </span>

        </a>

    </div>
<!-- menu -->
    <!-- NAVIGATION -->

    <nav class="sidebar-nav">
<!-- menu -->

@php
    $role = strtolower(auth()->user()->role);
@endphp

{{-- ADMIN MENU --}}
@if($role === 'admin')

    
<!-- Dashboard -->

<!-- Admin Panel -->
 
    




@endif



{{-- SHOPKEEPER MENU --}}
@if($role === 'shopkeeper')

    <div class="mt-3 font-bold text-gray-500">Shopkeeper</div>
    

    <!-- Dashboard -->

@endif


<!-- end menu -->
        <!-- DASHBOARD -->

        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           href="{{ route('dashboard') }}">

            <span class="nav-icon">
                <i class="bi bi-speedometer2"></i>
            </span>

            <span class="nav-text">
                Dashboard
            </span>

        </a>

        <!-- OPERATIONS -->

        <div class="sidebar-label">
            OPERATIONS
        </div>
         @if(auth()->user()->role === 'admin')

            <a class="nav-link"
            href="/admin/staff">

                <span class="nav-icon">
                    <i class="bi bi-people"></i>
                </span>

                <span class="nav-text">
                    Manage Staff 
                </span>

            </a>

          <!-- <a class="nav-link {{ request()->is('subscription*') ? 'active' : '' }}"
            href="{{ route('subscription.index') }}">

                <span class="nav-icon">
                    <i class="bi bi-credit-card"></i>
                </span>

                <span class="nav-text">
                    Manage Subscription
                </span>

            </a> -->

        @endif

        <a class="nav-link {{ request()->is('vouchers*') ? 'active' : '' }}"
           href="{{ route('vouchers.index') }}">

            <span class="nav-icon">
                <i class="bi bi-ticket-perforated"></i>
            </span>

            <span class="nav-text">
                Vouchers
            </span>

        </a>

        <a class="nav-link {{ request()->is('packages*') ? 'active' : '' }}"
           href="{{ route('packages.index') }}">

            <span class="nav-icon">
                <i class="bi bi-box-seam"></i>
            </span>

            <span class="nav-text">
                Packages
            </span>

        </a>

        <a class="nav-link {{ request()->is('routers*') ? 'active' : '' }}"
           href="{{ route('routers.index') }}">

            <span class="nav-icon">
                <i class="bi bi-router"></i>
            </span>

            <span class="nav-text">
                Routers
            </span>

        </a>

        <a class="nav-link"
           href="#">

            <span class="nav-icon">
                <i class="bi bi-wifi"></i>
            </span>

            <span class="nav-text">
                Hotspot Sessions
            </span>

        </a>

        <!-- BUSINESS -->

        <div class="sidebar-label">
            BUSINESS
        </div>

        
        @if(auth()->user()->role === 'admin')

            <a class="nav-link"
            href="/admin/users">

                <span class="nav-icon">
                    <i class="bi bi-people"></i>
                </span>

                <span class="nav-text">
                    Manage Customers 
                </span>

            </a>

          <a class="nav-link {{ request()->is('subscription*') ? 'active' : '' }}"
            href="{{ route('subscription.index') }}">

                <span class="nav-icon">
                    <i class="bi bi-credit-card"></i>
                </span>

                <span class="nav-text">
                    Manage Subscription
                </span>

            </a>

        @endif



        <a class="nav-link"
           href="#">

            <span class="nav-icon">
                <i class="bi bi-cash-stack"></i>
            </span>

            <span class="nav-text">
                Transactions
            </span>

        </a>

        <a class="nav-link"
           href="#">

            <span class="nav-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </span>

            <span class="nav-text">
                Reports
            </span>

        </a>

{{-- SHOPKEEPER MENU --}}
@if($role === 'shopkeeper')

        <a class="nav-link "
            href="{{ route('subscription.index') }}">

                <span class="nav-icon">
                    <i class="bi bi-credit-card"></i>
                </span>

                <span class="nav-text">
                    My Subscription
                </span>

            </a>
@endif
        <!-- SYSTEM -->

        <div class="sidebar-label">
            SYSTEM
        </div>

      

        <a class="nav-link"
           href="#">

            <span class="nav-icon">
                <i class="bi bi-gear"></i>
            </span>

            <span class="nav-text">
                Settings
            </span>

        </a>

    </nav>

    <!-- USER -->

    <!-- <div class="sidebar-user">

        <img class="avatar-img avatar-md sidebar-user-avatar"
             src="{{ asset('assets/images/avatar/avatar.jpg') }}"
             alt="User">

        <strong>
            {{ auth()->user()->name ?? 'IAMTEK User' }}
        </strong>

        <small>
            {{ ucfirst(auth()->user()->role ?? 'operator') }}
        </small>

    </div> -->

    <!-- FOOTER -->

    <div class="sidebar-footer">

        <span class="status-dot"></span>

        <span class="sidebar-footer-text">
            System Online
        </span>

    </div>

</aside>

