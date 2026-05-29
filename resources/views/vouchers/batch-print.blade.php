<!DOCTYPE html>
<html>
<head>

<style>

body{
font-family: Arial;
font-size:10px;
}

table{
width:100%;
border-collapse: collapse;
}

td{
width:25%;
height:120px;
border:1px dashed #000;
text-align:center;
vertical-align:middle;
padding:5px;
}

.title{
font-weight:bold;
font-size:12px;
}

.small{
font-size:9px;
}

</style>

</head>

<body>

<table>

@foreach($vouchers->chunk(4) as $row)

<tr>

@foreach($row as $voucher)

<td>

<div class="title">
IAMTEK WIFI
</div>

<hr>

<!-- <b>{{ $voucher->code }}</b> -->

<br>


<b>Username: {{ $voucher->username }}</b>

<br>

<b>Password {{ $voucher->password }}</b>

<br>
Package: {{ $voucher->package->name }}

<br>
Price {{ $voucher->package->price }}

<br>

<div class="small">
{{ $voucher->created_at->format('d-m-y') }}
</div>

</td>

@endforeach

</tr>

@endforeach

</table>

</body>
</html> 



<!-- 



<!DOCTYPE html>
<html>
<head>

<style>

body{
font-family: monospace;
}

.container{
display:grid;
grid-template-columns: repeat(4, 1fr);
gap:10px;
}

.voucher{
border:1px dashed #000;
padding:10px;
height:140px;
text-align:center;
font-size:12px;
}

.title{
font-weight:bold;
font-size:14px;
}

.code{
font-size:10px;
}

</style>

</head>

<body>

<div class="container">

@foreach($vouchers as $voucher)

<div class="voucher">

<div class="title">
IAMTEK WIFI
</div>

<hr>

Username
<br>
<strong>{{ $voucher->username }}</strong>

<br><br>

Password
<br>
<strong>{{ $voucher->password }}</strong>

<br><br>

Package
<br>
{{ $voucher->package->name }}

<br>

<div class="code">
{{ $voucher->code }}
</div>

<div class="code">
{{ $voucher->created_at->format('d-m-y H:i') }}
</div>

</div>

@endforeach

</div>

</body>
</html> -