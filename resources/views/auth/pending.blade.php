@extends('layouts.sidebar')

@section('content')



<div class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-8 rounded shadow text-center w-96">

        <h2 class="text-xl font-bold text-gray-800">
            Account Waiting For Approval
        </h2>

        <p class="text-gray-600 mt-2">
            Your shopkeeper account is awaiting admin approval.
        </p>

        <div class="mt-6 space-y-3">

            <a href="/logout"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="block bg-red-500 text-white p-2 rounded">
                Logout
            </a>

            <form id="logout-form" method="POST" action="/logout" class="hidden">
                @csrf
            </form>

            <a href="/login" class="block text-blue-500">
                Refresh Status
            </a>

        </div>

    </div>

</div>


@endsection