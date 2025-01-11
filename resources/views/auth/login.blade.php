<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center h-screen animate-fadeIn">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Login</h2>
        <form id="loginForm" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div>
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" id="loginBtn"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transform transition duration-300 hover:scale-105">
                    Login
                </button>
            </div>
        </form>

        <div id="loader" class="hidden text-center mt-4">
            <div class="border-4 border-transparent border-t-blue-500 border-r-indigo-500 rounded-full w-10 h-10 animate-spin mx-auto"></div>
        </div>

        <p class="text-center mt-4 text-gray-700">
            <a href="/register" class="bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-full after:h-[2px] after:bg-gradient-to-r from-indigo-600 to-blue-500 after:scale-x-0 after:origin-right after:transition-transform hover:after:scale-x-100 hover:after:origin-left text-lg">
                Don't have an account? Register here
            </a>
        </p>

        <p class="text-center mt-4 text-gray-700">
            <a href="/forgot-password" class="bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-full after:h-[2px] after:bg-gradient-to-r from-indigo-600 to-blue-500 after:scale-x-0 after:origin-right after:transition-transform hover:after:scale-x-100 hover:after:origin-left text-lg">
                Forgot your password?
            </a>
        </p>

        <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            document.getElementById('loginBtn').classList.add('opacity-50', 'cursor-wait');
            document.getElementById('loader').classList.remove('hidden');

            axios.post('/api/login', { email, password })
                .then(response => {
                    alert('Please check your email for the MFA token.');
                    window.location.href = `/mfa/${response.data.user_id}`; 
                })
                .catch(error => {
                    document.getElementById('errorMessage').innerText = error.response.data.message || 'Login failed';
                    document.getElementById('errorMessage').classList.remove('hidden');
                    document.getElementById('loginBtn').classList.remove('opacity-50', 'cursor-wait');
                    document.getElementById('loader').classList.add('hidden');
                });
        });
    </script>
</body>
</html>
