<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .active-nav-link {
            background-color: #fff;
            color: #1c3faa;
            font-weight: bold;
            border-top-left-radius: 999px;
            border-bottom-left-radius: 999px;
        }

        .hidden {
            display: none;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="w-64 bg-blue-700 text-white flex flex-col min-h-screen fixed transform -translate-x-full transition-transform duration-200 ease-in-out">
            <div class="p-6 font-bold text-center">
                <p class="font-bold text-2xl text-center">Dashboard</p>
                <p class="font-bold text-md text-center">UID : 123456789</p>
            </div>
            <div class="pl-7">
                <nav class="flex-1">
                    <ul>
                        <li class="p-4 hover:text-blue-800 hover:bg-white hover:rounded-tl-full hover:rounded-bl-full hover:font-bold {{ request()->is('dashboard') ? 'active-nav-link' : '' }}">
                            <a href="/dashboard" class="block">Dashboard</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex w-full flex-col h-screen bg-white transition-all duration-200 ease-in-out">
            <div class="flex justify-between items-center bg-white p-4 shadow px-10">
                <div class="flex items-center">
                    <button id="menu-button" class="text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                    <div class="ml-5">
                        <h1 class="font-bold text-xl">Dashboard</h1>
                    </div>
                </div>
                <div class="relative flex space-x-5 text-blue-700">
                    <div>
                        <button id="notification-button" class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h2a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v3a2 2 0 002 2h2m0 0v5a2 2 0 002 2h4a2 2 0 002-2v-5m-6 0h6" />
                            </svg>
                            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
                        </button>
                         <!-- Pop-up notification -->
                        <div id="notification-popup" class="hidden absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg p-4">
                            <p>No new notifications</p>
                        </div>
                    </div>
                    <a class="relative" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                            <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                            <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex w-full p-10 bg-white overflow-auto">
                <div class="bg-white p-6 rounded-lg shadow w-full">
                    <h1 class="text-2xl font-bold my-5">Your friend List</h1>
                   <!-- code here -->
                   <table class="min-w-full bg-white">
                       <thead>
                           <tr>
                               <th class="py-2 px-4 bg-blue-600 text-white text-center">Nomor</th>
                               <th class="py-2 px-4 bg-blue-600 text-white text-center">Nama</th>
                               <th class="py-2 px-4 bg-blue-600 text-white text-center">Alamat</th>
                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td class="py-2 px-4 border-b text-center">1</td>
                               <td class="py-2 px-4 border-b text-center">John Doe</td>
                               <td class="py-2 px-4 border-b text-center">
                                   <button class="py-1 bg-blue-600 text-white px-2 rounded hover:opacity-80">
                                       <a href="#">Cari Rumah</a>
                                    </button>
                               </td>
                           </tr>
                           <!-- Tambahkan data lainnya di sini -->
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const menuButton = document.getElementById('menu-button');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            mainContent.classList.toggle('ml-64');
        });

        const notificationButton = document.getElementById('notification-button');
        const notificationPopup = document.getElementById('notification-popup');

        notificationButton.addEventListener('click', () => {
            notificationPopup.classList.toggle('hidden');
        });

        // Optional: Hide the popup when clicking outside of it
        document.addEventListener('click', (event) => {
            if (!notificationButton.contains(event.target) && !notificationPopup.contains(event.target)) {
                notificationPopup.classList.add('hidden');
            }
        });
    </script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
