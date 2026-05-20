<!-- adminhmd layout -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'IAMTEK Billing')
    </title>

    <!-- CSS -->

    <link rel="stylesheet"
          href="{{ asset('assets/css/bootstrap.min.css') }}">
    

    <link rel="stylesheet"
          href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet"
          href="{{ asset('assets/css/style.css') }}">

@vite([
    'resources/css/app.css'
])

</head>

<body>

<div class="admin-shell">

    <!-- MOBILE BACKDROP -->

    <div class="sidebar-backdrop"
         data-sidebar-close>
    </div>

    <!-- SIDEBAR -->

    @include('partials.sidebar-collapse')

    <!-- MAIN AREA -->

    <div class="admin-main">

        <!-- TOPBAR -->

   @include('partials.header')

        <!-- PAGE CONTENT -->

        <main class="dashboard-content">

            <div class="container-fluid px-3 px-lg-4 py-4">

                @yield('content')

            </div>

        </main>

    </div>

</div>

<!-- JS -->

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>