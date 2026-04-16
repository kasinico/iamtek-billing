<h2>Voucher Generator</h2>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="/vouchers/generate">
    @csrf

    <label>Package</label>
    <select name="package_id">
        @foreach($packages as $package)
            <option value="{{ $package->id }}">
                {{ $package->name }} - {{ $package->price }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Quantity</label>
    <input type="number" name="quantity" value="10">

    <br><br>

    <button type="submit">Generate Vouchers</button>
</form>

<hr>

<h3>Recent Vouchers</h3>

@foreach($vouchers as $voucher)
    <p>
        {{ $voucher->code }} |
        {{ $voucher->status }}
    </p>
@endforeach