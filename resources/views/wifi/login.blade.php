<!DOCTYPE html>
<html>
<head>
<title>WiFi Login</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body{
font-family:Arial;
background:#f3f4f6;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:white;
padding:25px;
width:90%;
max-width:350px;
border-radius:10px;
box-shadow:0 10px 20px rgba(0,0,0,0.1);
}

input{
width:100%;
padding:12px;
margin-top:10px;
border:1px solid #ccc;
border-radius:6px;
}

button{
width:100%;
padding:12px;
margin-top:15px;
background:#2563eb;
color:white;
border:none;
border-radius:6px;
font-weight:bold;
}

</style>

</head>

<body>

<div class="box">

<h3 style="text-align:center">Connect to WiFi</h3>

@if(session('error'))
<p style="color:red">{{ session('error') }}</p>
@endif

<form method="POST" action="/wifi/login">

@csrf

<input type="text" name="code" placeholder="Voucher Code" required>

<input type="text" name="phone" placeholder="Phone Number" required>

<input type="hidden" name="router_id" value="{{ request('router') }}">

<button type="submit">Connect</button>

</form>

</div>

</body>

</html>