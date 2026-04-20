@extends('layouts.admin')

@section('content')

<h1>Voucher Generator</h1>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ url('/vouchers/generate') }}">
@csrf

<label>Package</label>
<select name="package_id" required>
@foreach($packages as $package)
<option value="{{ $package->id }}">
{{ $package->name }} - {{ $package->price }}
</option>
@endforeach
</select>

<br><br>

<label>Router</label>
<select name="router_id" required>
<option value="">Select Router</option>

@foreach($routers as $router)
<option value="{{ $router->id }}">
{{ $router->name }} ({{ $router->ip_address }})
</option>
@endforeach

</select>

<br><br>

<label>Quantity</label>
<input type="number" name="quantity" value="10" min="1" max="1000" required>

<br><br>

<label>Duration</label>
<input type="number" name="duration" placeholder="e.g 1 day / 24h" required>

<br><br>

<button type="submit">Generate Vouchers</button>

</form>

<hr>


 <h3>Recent Vouchers</h3>

@if($vouchers->count())
   <a href="{{ route('vouchers.printBatch', $vouchers->first()->batch_id) }}" target="_blank">
    Print Latest Batch
</a>
@endif



<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Code</th>
            <th>Username</th>
            <th>Password</th>
            <th>Package</th>
            <th>Router</th>
            <th>Status</th>
            <th>Created</th>
            <th>Print</th>
        </tr>
    </thead>

    <tbody>
        @foreach($vouchers as $voucher)
        <tr>
            <td>{{ $voucher->code }}</td>
            <td>{{ $voucher->username }}</td>
            <td>{{ $voucher->password }}</td>

            <td>
                {{ $voucher->package->name ?? 'N/A' }}
            </td>

            <td>
                {{ $voucher->router->name ?? 'N/A' }}
            </td>

            <td style="color:green">{{ $voucher->status }}</td>

            <td>
                {{ $voucher->created_at }}
            </td>
            <td>
                



                
            <a href="/voucher/print/{{ $voucher->id }}">
            Print
            </a>

            |

            



           
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
