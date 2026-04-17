<!-- <!DOCTYPE html>
<html>
<head>
<title>Voucher</title>
<style>
body{
    font-family: Arial;
    text-align:center;
}
.card{
    border:1px dashed black;
    width:250px;
    padding:20px;
    margin:auto;
}
</style>
</head>

<body>

<div class="card">

<h3>IAMTEK WIFI</h3>

<p><b>Code:</b> {{ $voucher->code }}</p>

<p><b>Username:</b> {{ $voucher->username }}</p>

<p><b>Password:</b> {{ $voucher->password }}</p>

<p><b>Duration:</b> {{ $voucher->duration }}</p>

<p><b>Speed:</b> {{ $voucher->bandwidth }}</p>

</div>

</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Voucher</title>

<style>

body{
font-family: monospace;
text-align:center;
}

.ticket{
border:1px dashed #000;
padding:20px;
width:250px;
margin:auto;
}
.small{
font-size:9px;
}

.title{
font-size:20px;
font-weight:bold;
}

</style>

</head>

<body>

<div class="ticket">

<div class="title">IAMTEK WIFI</div>

<hr>

<p>Code</p>
<strong>{{ $voucher->code }}</strong>

<!-- <p>Password</p>
<strong>{{ $voucher->password }}</strong> -->

<p>Package</p>
<strong>{{ $voucher->package->name }}</strong>
<div class="small">
{{ $voucher->created_at->format('d-m-y') }}
</div>
<hr>

<p>Enjoy your internet</p>

</div>

</body>
</html>