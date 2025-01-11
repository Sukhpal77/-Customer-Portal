<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your MFA Token</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-10">
        <h1 class="text-3xl font-semibold text-center text-indigo-600">Multi-Factor Authentication (MFA) Token</h1>

        <p class="mt-6 text-lg text-gray-800">Hello,</p>
        
        <p class="mt-2 text-lg text-gray-800">Your MFA token is: <strong class="text-xl font-semibold text-blue-600">{{ $mfaToken }}</strong></p>
        
        <p class="mt-4 text-gray-800">Use this token to complete your login process. It is valid for a limited time only.</p>

        <p class="mt-4 text-gray-800">If you did not request this, please contact support immediately.</p>

        <p class="mt-6 text-gray-600 text-center">Thank you!</p>
    </div>

</body>
</html>
