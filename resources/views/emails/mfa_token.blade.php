<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MFA Verification</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center h-screen animate-fadeIn">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">MFA Verification</h2>
        <form id="mfaForm" class="space-y-4">
            @csrf
            <div>
                <label for="mfa_token" class="block text-gray-700">MFA Token</label>
                <input type="text" name="mfa_token" id="mfa_token" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transform transition duration-300 hover:scale-105">
                    Verify Token
                </button>
            </div>
        </form>

        <p class="text-center mt-4 text-gray-700">
            <a href="/login" class="text-blue-500 hover:text-blue-600">Back to Login</a>
        </p>

        <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>
    </div>

    <script>
        const userId = window.location.pathname.split('/').pop();
        document.getElementById('mfaForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const mfaToken = document.getElementById('mfa_token').value;

            axios.post('/api/verify-mfa', { mfa_token: mfaToken, user_id: userId })
                .then(response => {
                    alert('MFA verification successful!');
                    localStorage.setItem('token', response.data.token);
                    window.location.href = '/customers'; 
                })
                .catch(error => {
                    document.getElementById('errorMessage').innerText = error.response.data.message || 'Verification failed';
                    document.getElementById('errorMessage').classList.remove('hidden');
                });
        });
    </script>
</body>
</html>
