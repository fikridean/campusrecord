<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
</head>

<body>

    @if (Auth::check())
        <form action="{{ route('logout', Auth::user()) }}" method="POST">
            <button>
                Logout
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('login') }}">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Login">
        </form>
    @endif

</body>

</html>
