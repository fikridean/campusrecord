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
    <div class="flex min-h-screen">
        <!-- Login Form -->
        <div class="flex flex-col justify-center items-center w-full md:w-1/2 bg-white p-8 max-md:border">
            <div class="w-full p-10">
                <h1 class="text-3xl font-semibold mb-6 text-center">Welcome back!</h1>
                <p class="mb-6 text-center">Please enter your details to log in</p>
                <form id="loginForm">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your username">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your password">
                    </div>
                    <div id="error-message" class="my-4 text-red-500 text-center hidden"></div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Sign in</button>
                    </div>
                </form>
                <p class="mt-6 text-center text-sm text-gray-600">
                    Don’t have an account? <a href="/signUp" class="font-medium text-blue-600 hover:text-blue-500">Sign up here</a>
                </p>
            </div>
        </div>
        <!-- Image Section -->
        <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('image/signIn.png');"></div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');

            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const data = await response.json();

            if (response.ok) {
                // Simpan token di localStorage
                localStorage.setItem('token', data.access_token);
                console.log(data.access_token)
                // Redirect ke halaman lain setelah login
                // window.location.href = '/dashboard';
            } else {
                errorMessage.textContent = data.message;
                errorMessage.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
