<!DOCTYPE html>
<html>
<head>
    <title>WiFi Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 20px;
            width: 90%;
            max-width: 350px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .title {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>






<h2>Connect to WiFi</h2>

<!-- OPTION A: VOUCHER LOGIN -->
<form method="POST" action="/login-voucher">
    @csrf
    <input type="text" name="voucher" placeholder="Enter Voucher Code" required>
    <button type="submit">Login</button>
</form>

<hr>

<!-- OPTION B: BUY INTERNET -->
<h3>Buy Data</h3>

<form method="POST" action="/pay">
    @csrf

    <select name="package_id">
        @foreach($packages as $package)
            <option value="{{ $package->id }}">
                {{ $package->name }} - UGX {{ $package->price }}
            </option>
        @endforeach
    </select>

    <input type="text" name="phone" placeholder="2567XXXXXXXX" required>

    <select name="network">
        <option value="MTN">MTN</option>
        <option value="AIRTEL">AIRTEL</option>
    </select>

    <button type="submit">Pay & Get Voucher</button>
</form>

</body>
</html>