@extends('customers.layout')

@section('title', 'Add New Customer')

@section('content')
    <div class="flex items-center justify-center h-screen ">
        <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Add New Customer</h2>
            <form id="createCustomerForm" class="space-y-4">
                <div>
                    <label for="first_name" class="block text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="last_name" class="block text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="age" class="block text-gray-700">Age</label>
                    <input type="number" name="age" id="age" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="dob" class="block text-gray-700">Date of Birth</label>
                    <input type="date" name="dob" id="dob" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-4 rounded-lg">
                        Add Customer
                    </button>
                </div>
            </form>

            <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>
        </div>
    </div>

    <script>
        document.getElementById('createCustomerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const first_name = document.getElementById('first_name').value;
            const last_name = document.getElementById('last_name').value;
            const age = document.getElementById('age').value;
            const dob = document.getElementById('dob').value;
            const email = document.getElementById('email').value;

            axios.post('/api/customers', { first_name, last_name, age, dob, email }, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
                .then(response => {
                    alert('Customer added successfully!');
                    window.location.href = '/customers';  
                })
                .catch(error => {
                    document.getElementById('errorMessage').innerText = error.response.data.message || 'Failed to add customer';
                    document.getElementById('errorMessage').classList.remove('hidden');
                });
        });
    </script>
@endsection
