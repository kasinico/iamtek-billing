@extends('layouts.adminhmd')
@include('partials.sidebar-collapse')

@section('content')

<h4>Manage Customers</h4>

<div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">

                <tr class="border-t hover:bg-gray-50">
                        <th class="p-3 text-left">Name</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Action</th>
                </tr>
            </thead>

                <tbody>

                    @foreach($users as $user)

                <tr class="border-t hover:bg-gray-50">

                <td class="p-3">{{ $user->name }}</td>

                <td class="p-2 border ">{{ $user->email }}</td>

                <td class="p-2 border ">

                @if($user->status == 'active')
                🟢 Active
                @elseif($user->status == 'pending')
                🟡 Pending
                @else
                🔴 Disabled
                @endif

                </td>

                <td class="p-2 border ">

                @if($user->status == 'pending')

                <a href="{{ url('/admin/users/'.$user->id.'/approve') }}">Approve</a>

                @endif


                @if($user->status == 'active')

                <a href="{{ url('/admin/users/'.$user->id.'/disable') }}">Disable</a>

                @endif


                @if($user->status == 'disabled')

                <a href="{{ url('/admin/users/'.$user->id.'/enable') }}">Enable</a>

                @endif

                </td>

                </td>

                </tr>

                @endforeach
</tbody>
</table>



</div>
</div>
@endsection