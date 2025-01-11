<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center h-screen animate-fadeIn">

    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Forgot Password</h2>

        <form id="forgotPasswordForm" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" id="submitButton"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transform transition duration-300 hover:scale-105">
                    Send Reset Link
                </button>
            </div>
        </form>

        <!-- Loader -->
        <div id="loader" class="flex justify-center mt-4 hidden">
            <div class="w-6 h-6 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <p id="successMessage" class="text-green-500 text-center mt-4 hidden"></p>
        <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>

        <p class="text-center mt-4 text-gray-700">
            <a href="/" class="text-blue-500 hover:text-blue-600">Back to Login</a>
        </p>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const loader = document.getElementById('loader');
            const submitButton = document.getElementById('submitButton');

            loader.classList.remove('hidden');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');

            axios.post('/api/forgot-password', { email })
                .then(response => {
                    document.getElementById('successMessage').innerText = 'A reset password link has been sent to your email. Please check your inbox.';
                    document.getElementById('successMessage').classList.remove('hidden');
                    document.getElementById('errorMessage').classList.add('hidden');
                })
                .catch(error => {
                    document.getElementById('errorMessage').innerText = error.response.data.error || 'Unable to send reset link. Please try again later.';
                    document.getElementById('errorMessage').classList.remove('hidden');
                    document.getElementById('successMessage').classList.add('hidden');
                })
                .finally(() => {
                    loader.classList.add('hidden');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                });
        });
    </script>
</body>
</html>
