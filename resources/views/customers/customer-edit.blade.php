@extends('customers.layout')

@section('title', 'Update Customer')

@section('content')    
<div class="flex items-center justify-center h-screen ">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-700">Update Customer</h2>
        <form id="updateCustomerForm" class="space-y-4">
            <input type="hidden" id="customerId">
            <div>
                <label for="first_name" class="block text-gray-700">First Name</label>
                <input type="text" name="first_name" id="first_name" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label for="last_name" class="block text-gray-700">Last Name</label>
                <input type="text" name="last_name" id="last_name" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label for="age" class="block text-gray-700">Age</label>
                <input type="number" name="age" id="age" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label for="dob" class="block text-gray-700">Date of Birth</label>
                <input type="date" name="dob" id="dob" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg">
                    Update Customer
                </button>
            </div>
        </form>

        <p id="errorMessage" class="text-red-500 text-center mt-4 hidden"></p>
    </div>
</div>

<!-- Add Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Fetch customer data and populate form
    const customerId = window.location.pathname.split('/')[2];

    // Fetch customer data
    axios.get(`/api/customers/${customerId}`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        }
    })
        .then(response => {
            const customer = response.data;
            document.getElementById('customerId').value = customer.id;
            document.getElementById('first_name').value = customer.first_name;
            document.getElementById('last_name').value = customer.last_name;
            document.getElementById('age').value = customer.age;
            document.getElementById('dob').value = customer.dob;
            document.getElementById('email').value = customer.email;
        })
        .catch(error => {
            document.getElementById('errorMessage').innerText = 'Failed to load customer data';
            document.getElementById('errorMessage').classList.remove('hidden');
        });

    // Update customer functionality
    document.getElementById('updateCustomerForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent page refresh

        // Capture the form data
        const updatedCustomer = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            age: document.getElementById('age').value,
            dob: document.getElementById('dob').value,
            email: document.getElementById('email').value
        };

        // Log the updated data for debugging
        console.log("Updating customer with data:", updatedCustomer);

        // Make PUT request to update customer
        axios.put(`/api/customers/${customerId}`, updatedCustomer, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            }
        })
            .then(response => {
                // If the update is successful, show a success message
                alert('Customer updated successfully!');
                window.location.href = '/customers';  // Redirect to customer list
            })
            .catch(error => {
                // Handle any error that occurs during the request
                console.error("Error updating customer:", error);
                document.getElementById('errorMessage').innerText = error.response?.data?.message || 'Failed to update customer';
                document.getElementById('errorMessage').classList.remove('hidden');
            });
    });
</script>
@endsection