@extends('layouts.admin')

@section('content')

<h2>Shopkeepers</h2>

<table border="1" width="100%">

<tr>
<th>Name</th>
<th>Email</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach($users as $user)

<tr>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>

@if($user->status == 'active')
🟢 Active
@elseif($user->status == 'pending')
🟡 Pending
@else
🔴 Disabled
@endif

</td>

<td>

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

</table>
@endsection