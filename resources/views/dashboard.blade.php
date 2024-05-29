<?php 
    $value = 1
?>

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
        <!-- Main Content -->
        <div id="main-content" class="flex w-full flex-col h-screen bg-white transition-all duration-200 ease-in-out">
            <div class="flex sticky justify-between items-center bg-white p-4 shadow px-10">
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
                <div class="relative flex text-blue-700 top-3">
                    <form action="{{ route('logout') }}" method="post">
                        <button type="submit" class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                                <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                                <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
                            </svg>
                            Exit
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            
                <!-- Khusus Admin -->
                @can('isAdmin')
                <h1>ini Admin</h1>
                @endcan
                <!-- Khusus User -->
                @can('isStudent')
                <div class="flex flex-col w-full p-10 bg-white overflow-auto">
                    <!-- Search User -->
                    <div class="my-5 w-full flex">
                        <input id="search-input" type="text" placeholder="Search your friend here by username / NIM / Name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <button id="search-button" class="mx-5 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Search</button>
                    </div>

                    <h1 class="text-2xl font-bold my-5">Your friend List</h1>
                    <!-- Friends List -->
                    <div class="bg-white p-6 rounded-lg shadow w-full overflow-x-auto h-52">
                       <!-- code here -->
                       <table class="min-w-full bg-white">
                           <thead>
                               <tr>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Code Number</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Username</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">NIM</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Name</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Address</th>
                               </tr>
                           </thead>
                           <tbody id="results-table-body">
                                @foreach($users as $user)
                                <tr>
                                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $user->username }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $user->nim }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <button class="py-1 bg-blue-600 text-white px-2 rounded hover:opacity-80">
                                            <a href="{{ $user->map_url }}" target="_">Find House</a>
                                            </button>
                                    </td>
                                </tr>
                               @endforeach
                           </tbody>
                       </table>
                    </div>

                    <h1 class="text-2xl font-bold my-5">Your Log Activity</h1>
                    <!-- Log Activity -->
                    <div class="bg-white p-6 rounded-lg shadow w-full overflow-x-auto h-52">
                       <!-- code here -->
                       <table class="min-w-full bg-white">
                           <thead>
                               <tr>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Code Number</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Activity</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Created</th>
                                   <th class="py-2 px-4 bg-blue-600 text-white text-center">Updated</th>
                               </tr>
                           </thead>
                           <tbody id="activity-table-body">
                                <!-- Data will be appended here -->
                            </tbody>
                       </table>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '/api/user/activities',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var tableBody = $('#activity-table-body');
                    console.log(data);
                    var number = 1;
                    var activities = data.data;

                    // Get the last 30 activities
                    var last30Activities = activities.slice(-30);

                    last30Activities.forEach(function(activity) {
                        var row = '<tr>' +
                                    '<td class="py-2 px-4 border text-center">' + number + '</td>' +
                                    '<td class="py-2 px-4 border text-center">' + activity.activity + '</td>' +
                                    '<td class="py-2 px-4 border text-center">' + activity.created_at + '</td>' +
                                    '<td class="py-2 px-4 border text-center">' + activity.updated_at + '</td>' +
                                '</tr>';
                        tableBody.append(row);
                        number += 1;
                    });
                },
                error: function(error) {
                    console.error("Error fetching data: ", error);
                }
            });

            $('#search-button').on('click', function() {
                var searchQuery = $('#search-input').val();
                console.log(searchQuery)

                $.ajax({
                    url: '/api/users/search',
                    method: 'POST',
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify({ search: searchQuery }),
                    success: function(response) {
                        var tableBody = $('#results-table-body');
                        tableBody.empty(); // Clear existing results

                        var number = 1;
                        response.data.forEach(function(user) {
                            var row = '<tr>' +
                                        '<td class="py-2 px-4 border text-center">' + number + '</td>' +
                                        '<td class="py-2 px-4 border text-center">' + user.username + '</td>' +
                                        '<td class="py-2 px-4 border text-center">' + user.nim + '</td>' +
                                        '<td class="py-2 px-4 border text-center">' + user.name + '</td>' +
                                    '</tr>';
                            tableBody.append(row);
                            number += 1;
                        });
                    },
                    error: function(error) {
                        console.error("Error fetching data: ", error);
                    }
                });
            });
        });


    </script>
</body>
</html>
