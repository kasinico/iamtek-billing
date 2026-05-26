<nav class="navbar admin-navbar navbar-expand bg-white">

    <div class="container-fluid px-3 px-lg-4">

        <!-- SIDEBAR TOGGLE -->

        <button class="sidebar-toggle"
                type="button"
                data-sidebar-toggle
                aria-controls="adminSidebar"
                aria-expanded="true"
                aria-label="Toggle sidebar">

            <span></span>
            <span></span>
            <span></span>

        </button>

        <!-- SEARCH -->

        <form class="d-none d-md-flex ms-3 flex-grow-1"
              role="search">

            <input class="form-control search-input"
                   type="search"
                   placeholder="Search users, vouchers, reports"
                   aria-label="Search">

        </form>

        <!-- RIGHT SIDE -->

        <div class="navbar-actions ms-auto">

            <!-- DARK MODE -->

            <button class="icon-button theme-toggle"
                    type="button"
                    data-theme-toggle
                    aria-label="Switch color theme">

                <i class="bi bi-moon-stars"
                   data-theme-icon
                   aria-hidden="true"></i>

            </button>

            <!-- NOTIFICATIONS -->

            <div class="dropdown">

                <button class="icon-button"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                    <span class="notification-dot"></span>

                    <i class="bi bi-bell"></i>

                </button>

                <div class="dropdown-menu dropdown-menu-end notification-menu">

                    <div class="dropdown-header fw-bold text-body">

                        Notifications

                    </div>

                    <span class="dropdown-item">

                        No notifications yet

                    </span>

                </div>

            </div>

            <!-- PROFILE -->
<div class="dropdown">

    <a class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle"
       href="#"
       role="button"
       data-bs-toggle="dropdown"
       aria-expanded="false"
       style="
            color: inherit;
       ">

        <img src="{{ asset('assets/images/avatar/avatar-2.jpg') }}"
             class="rounded-circle"
             width="40"
             height="40"
             style="
                width:40px;
                height:40px;
                object-fit:cover;
                border:2px solid #52e7b8;
                flex-shrink:0;
             "
             alt="User">

        <strong>

            {{ auth()->user()->name ?? 'IAMTEK User' }}

        </strong>

    </a>

    <ul class="dropdown-menu dropdown-menu-end">

        <li>

            <a class="dropdown-item"
               href="{{ route('profile.edit') }}">

                Profile

            </a>

        </li>

        <li>
            <hr class="dropdown-divider">
        </li>

        <li>

            <form method="POST"
                  action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                        class="dropdown-item">

                    Sign out

                </button>

            </form>

        </li>

    </ul>

</div>
        </div>

    </div>

</nav>