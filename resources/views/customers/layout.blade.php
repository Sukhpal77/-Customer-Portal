<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Management')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        .scroll-hidden {
            overflow-y: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scroll-hidden::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-indigo-100 to-indigo-300">

    <div
        class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 flex justify-between items-center text-white shadow-md">
        <div class="flex items-center space-x-4">
            <span class="text-lg font-bold">Customer Management</span>
            <div class="text-sm">
                <span id="userName"></span> |
                <span id="userRole"></span>
            </div>
        </div>
        <div>
            <button id="logoutButton" class="bg-red-500 hover:bg-red-600 py-2 px-4 rounded-lg text-white font-semibold">
                Logout
            </button>
        </div>
    </div>

    <div class="container mx-auto p-5 scroll-hidden h-[calc(99vh-68px)] ">
        @yield('content')
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userName = localStorage.getItem('userName');
            const userRole = localStorage.getItem('userRole');
            document.getElementById('userName').textContent = userName || 'User';
            document.getElementById('userRole').textContent = userRole || 'Guest';

            document.getElementById('logoutButton').addEventListener('click', function () {
                axios.post('/api/logout', {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                }).then(response => {
                    localStorage.removeItem('token');
                    localStorage.removeItem('userName');
                    localStorage.removeItem('userRole');
                    window.location.href = '/';
                }).catch(error => {
                    alert('Logout failed');
                });
            });
        });
    </script>
</body>

</html>