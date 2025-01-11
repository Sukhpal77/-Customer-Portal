<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 flex items-center justify-center h-screen animate-fadeIn">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Register</h2>
        <form id="registerForm" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
            </div>
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
            </div>
            <div>
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transform transition duration-300 hover:scale-105">
                    Register
                </button>
            </div>
        </form>

        <p class="text-center mt-4 text-gray-700">
            <a href="/" class="bg-gradient-to-r from-blue-500 to-green-500 bg-clip-text text-transparent relative after:content-[''] after:absolute after:left-0 after:bottom-0 after:w-full after:h-[2px] after:bg-gradient-to-r from-blue-500 to-green-500 after:scale-x-0 after:origin-right after:transition-transform hover:after:scale-x-100 hover:after:origin-left text-lg">
                Already have an account? Login here
            </a>
        </p>

        <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            axios.post('/api/register', { name, email, password, password_confirmation })
                .then(response => {
                    alert('Registration successful!');
                    window.location.href = '/';
                })
                .catch(error => {
                    document.getElementById('errorMessage').innerText = error.response.data.message || 'Registration failed';
                    document.getElementById('errorMessage').classList.remove('hidden');
                });
        });
    </script>
</body>
</html>
