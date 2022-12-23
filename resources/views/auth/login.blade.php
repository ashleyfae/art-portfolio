<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Log In</title>
</head>
<body class="antialiased">
<form method="POST" action="{{ route('login') }}">
    @csrf
    <p>
        <label for="email">Email:</label> <br>
        <input
            type="email"
            id="email"
            name="email"
            autofocus
        >
    </p>

    <p>
        <label for="password">Password:</label> <br>
        <input
            type="password"
            id="password"
            name="password"
        >
    </p>

    <p>
        <input
            type="checkbox"
            id="remember"
            name="remember"
            checked
        >
        <label for="remember">Remember me</label>
    </p>

    <p>
        <button type="submit">Login</button>
    </p>
</form>
</body>
</html>
