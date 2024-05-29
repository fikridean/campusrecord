<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-900">
    <div class="flex min-h-screen p-10 md:p-0">
        <!-- Login Form -->
        <div class="flex flex-col justify-center items-center w-full md:w-1/2 bg-white p-8 max-md:border rounded-2xl shadow-md md:rounded-none">
            <div class="md:hidden flex justify-center items-center">
                <img src="image/sunshineboy.jpg" alt="helloPerson" class="w-2/3">
            </div>
            <div class="w-full p-10">
                <h1 class="text-3xl font-semibold mb-6 text-center">Hi, Welcome back!</h1>
                <p class="mb-6 text-center">Please enter your details to log in</p>
                <form id="loginForm" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your username">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your password">
                    </div>
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="showPassword" class="form-checkbox text-blue-600">
                            <span class="ml-2 text-sm text-gray-600">Show Password</span>
                        </label>
                    </div>
                    <div id="error-message" class="my-4 text-red-500 text-center hidden"></div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign in</button>
                    </div>
                </form>
                <p class="mt-6 text-center text-sm text-gray-600">
                    Don’ts have an account? <a href="/signUp" class="font-medium text-blue-600 hover:text-blue-500">Sign up here</a>
                </p>
            </div>
        </div>
        <!-- Image Section -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('image/signIn.png');"></div>
    </div>
    <script>
        document.getElementById('showPassword').addEventListener('change', function () {
            var passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>
</html>
