<h2>Reseller Registration</h2>

<form method="POST" action="/reseller/register">

@csrf

<input type="text" name="name" placeholder="Shop Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Register</button>

</form>