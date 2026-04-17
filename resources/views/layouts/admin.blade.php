<!DOCTYPE html>
<html>
<head>
    <title>Hotspot System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

<div class="sidebar">
    @include('layouts.sidebar')
</div>

<div class="main">
    <div class="topbar">
        Logged in as: {{ auth()->user()->name }}
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

</body>
</html>