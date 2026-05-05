<!DOCTYPE html>
<html>
<head>
    <title>IAMTEK Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script>

    // SIDEBAR TOGGLE
    function toggleSidebar() {

    let sidebar = document.getElementById("sidebar");

    sidebar.classList.toggle("-translate-x-full");

    }


    // USER DROPDOWN TOGGLE
    function toggleUserMenu() {

    let menu = document.getElementById("userMenu");

    menu.classList.toggle("hidden");

    }


    // CLICK OUTSIDE CLOSE MENUS
    document.addEventListener("click", function(event){

    let sidebar = document.getElementById("sidebar");
    let userMenu = document.getElementById("userMenu");
    let dropdown = document.getElementById("userDropdown");


    // CLOSE USER DROPDOWN
    if(!dropdown.contains(event.target)){
    userMenu.classList.add("hidden");
    }

    });

</script>
<body class="bg-gray-100">

@php
$current = request()->segment(1);
@endphp



<div class="flex">

    <!-- SIDEBAR -->



<div id="sidebar"
class="w-64 h-screen overflow-y-auto bg-white shadow 
fixed md:relative z-30 transform 
-translate-x-full md:translate-x-0 transition duration-200">       <div class="p-4 font-bold text-xl border-b">
            IAMTEK
        </div>

       

        <nav class="p-2 text-sm">


@php
    $role = strtolower(auth()->user()->role);
@endphp

{{-- ADMIN MENU --}}
@if($role === 'admin')
<!-- 
    <div class="mt-3 font-bold text-gray-500">Admin Panel</div>

    <a href="/admin/users" class="block p-2">Approve Users</a>
    <a href="/routers" class="block p-2">Manage Routers</a>
    <a href="/reports" class="block p-2">Reports</a>
    <a href="/settings" class="block p-2">System Settings</a> -->


    
<!-- Dashboard -->
<a href="/dashboard"
class="block p-2 rounded {{ request()->is('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Dashboard
</a>

<!-- Admin Panel -->
 <div class="mt-4 text-xs font-bold text-gray-500 uppercase">Admin Panel</div>

    <!-- <a href="/admin/users"     class="block p-2">Approve Users</a> -->
     <a href="/admin/users"
class="block p-2 rounded {{ request()->is('admin/users*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Shop Users
</a>

    
<!-- <a href="/hotspot-users"
class="block p-2 rounded {{ request()->is('hotspot-users*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Hotspot Users
</a> -->

<a href="/pppoe-users"
class="block p-2 rounded {{ request()->is('pppoe-users*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Reports
</a>

<!-- Network -->
 <!-- Users -->
<!-- <div class="mt-4 text-xs font-bold text-gray-500 uppercase">Users</div> -->




<a href="/pppoe-users"
class="block p-2 rounded {{ request()->is('pppoe-users*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
PPPoE Users
</a>


<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Network</div>

<a href="/routers"
class="block p-2 rounded {{ request()->is('routers*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Manage Routers
</a>

<a href="/hotspot-servers"
class="block p-2 rounded {{ request()->is('hotspot-servers*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Hotspot Servers
</a>


<!-- Packages -->
<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Packages</div>

<a href="/packages"
class="block p-2 rounded {{ request()->is('packages*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
View Packages
</a>

<a href="/packages/create"
class="block p-2 rounded text-gray-700 hover:bg-gray-100">
Create Package
</a>


<!-- Vouchers -->
<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Vouchers</div>

<a href="/vouchers"
class="block p-2 rounded {{ request()->is('vouchers*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Generate
</a>

<!-- <a href="/voucher-batches"
class="block p-2 rounded {{ request()->is('voucher-batches*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Batches
</a> -->

<a href="/vouchers/print"
class="block p-2 rounded text-gray-700 hover:bg-gray-100">
Print
</a>





<!-- Sales -->
<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Sales</div>

<a href="/transactions"
class="block p-2 rounded {{ request()->is('transactions*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Transactions
</a>

<a href="/revenue"
class="block p-2 rounded {{ request()->is('revenue*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Revenue
</a>


<!-- Settings -->
<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Settings</div>

<a href="/settings"
class="block p-2 rounded {{ request()->is('settings*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Settings
</a>


@endif


{{-- SHOPKEEPER MENU --}}
@if($role === 'shopkeeper')

    <div class="mt-3 font-bold text-gray-500">Shopkeeper</div>

    <!-- Dashboard -->
<a href="/dashboard"
class="block p-2 rounded {{ request()->is('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Dashboard
</a>

<a href="/vouchers" class="block p-2">Generate Vouchers</a>
<a href="/voucher-batches" class="block p-2">My Sales</a>
    <a href="/revenue" class="block p-2">Revenue</a>
    

<!-- Packages -->
<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Packages</div>

<a href="/packages"
class="block p-2 rounded {{ request()->is('packages*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
View Packages
</a>

<a href="/packages/create"
class="block p-2 rounded text-gray-700 hover:bg-gray-100">
Create Package
</a>

<div class="mt-4 text-xs font-bold text-gray-500 uppercase">Network</div>

<a href="/routers"
class="block p-2 rounded {{ request()->is('routers*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Manage Routers
</a>

<a href="/hotspot-servers"
class="block p-2 rounded {{ request()->is('hotspot-servers*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
Hotspot Servers
</a>

    

@endif


{{-- CLIENT MENU (optional if needed later) --}}
@if($role === 'client')

    <div class="mt-3 font-bold text-gray-500">Client</div>

    <a href="/hotspot/login" class="block p-2">Login WiFi</a>

@endif

</nav>
    </div>


    <!-- MAIN CONTENT AREA -->
    <div class="flex-1">

        <!-- TOPBAR -->
        <div class="bg-white shadow p-4 flex justify-between items-center relative z-50">
<div class="flex items-center gap-3">

<button onclick="toggleSidebar()" class="text-gray-600 md:hidden text-xl">
☰
</button>

<div class="font-semibold">
Control Panel
</div>

</div>

            <!-- USER MENU -->
            <div class="relative" id="userDropdown">

                <button onclick="toggleUserMenu()" 
                class="flex items-center gap-2 text-gray-700 hover:text-blue-600">
                {{ auth()->user()->name }}
                <span>▼</span>
                </button>

                <div id="userMenu"
                     class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow">

                    <a href="/profile" class="block px-4 py-2 hover:bg-gray-100">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

        <!-- PAGE CONTENT -->
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

<script>
function toggleUserMenu() {
    const menu = document.getElementById("userMenu");
    menu.classList.toggle("hidden");
}
</script>

</body>
</html>
