<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>

<body>

    <form method="POST" action="{{ route('login') }}">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>

        <input type="submit" value="Login">
    </form>

    <br>

    <a href="/test2">Test udah login apa blom</a>

    <br>

    {{ Auth::check() ? 'Logged in' : 'Logged out' }}

    @if (Auth::check())
        <a href="{{ route('logout') }}">Logout</a>
    @endif

</body>

</html>
