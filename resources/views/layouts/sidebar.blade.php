<!DOCTYPE html>
<html>
<head>
    <title>IAMTEK Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>

<body class="bg-gray-100">





          

        </div>

        <!-- PAGE CONTENT -->
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>



</body>
</html>
