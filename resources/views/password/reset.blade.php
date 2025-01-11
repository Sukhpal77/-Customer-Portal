<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center h-screen animate-fadeIn">

    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Reset Password</h2>

        <form id="resetPasswordForm" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div>
                <label for="password" class="block text-gray-700">New Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transform transition duration-300 hover:scale-105">
                    Reset Password
                </button>
            </div>
        </form>

        <p class="text-center mt-4 text-gray-700">
            <a href="/" class="text-blue-500 hover:text-blue-600">Back to Login</a>
        </p>

        <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>
    </div>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;
            const token = new URLSearchParams(window.location.search).get('token');

            axios.post('/api/reset-password', { email, password, password_confirmation, token })
                .then(response => {
                    alert(response.data.message);
                    window.location.href = '/';
                })
                .catch(error => {
                    document.getElementById('errorMessage').innerText = error.response.data.error || 'Unable to reset password';
                    document.getElementById('errorMessage').classList.remove('hidden');
                });
        });
    </script>
</body>
</html>
