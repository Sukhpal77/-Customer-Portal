@extends('customers.layout')

@section('title', 'Customer List')

@section('content')
    <div class="w-full max-w-6xl mx-auto p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-4xl font-bold text-center mb-8 text-gray-700">Customer List</h2>

        <div class="mb-6 text-right">
            <a href="/customers/create" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg">
                Add New Customer
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border text-left">ID</th>
                        <th class="p-4 border text-left">First Name</th>
                        <th class="p-4 border text-left">Last Name</th>
                        <th class="p-4 border text-left">Age</th>
                        <th class="p-4 border text-left">Date of Birth</th>
                        <th class="p-4 border text-left">Email</th>
                        <th class="p-4 border text-left">Actions</th>
                    </tr>
                </thead>
                <tbody id="customerList">
                </tbody>
            </table>
        </div>

        <p id="errorMessage" class="text-red-500 text-center mt-6 hidden"></p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log("Page is loaded and script is running");

            axios.get('/api/customers', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
            .then(response => {
                const customers = response.data;
                const customerList = document.getElementById('customerList');
                customerList.innerHTML = '';  
                customers.forEach(customer => {
                    customerList.innerHTML += `
                        <tr>
                            <td class="p-4 border">${customer.id}</td>
                            <td class="p-4 border">${customer.first_name}</td>
                            <td class="p-4 border">${customer.last_name}</td>
                            <td class="p-4 border">${customer.age}</td>
                            <td class="p-4 border">${customer.dob}</td>
                            <td class="p-4 border">${customer.email}</td>
                            <td class="p-4 border">
                                <a href="/customers/${customer.id}/edit" class="text-blue-500 hover:text-blue-700">Edit</a> | 
                                <button class="text-red-500 hover:text-red-700" onclick="deleteCustomer(${customer.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error(error);
                document.getElementById('errorMessage').innerText = 'Failed to load customer data';
                document.getElementById('errorMessage').classList.remove('hidden');
            });
        });

        function deleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                axios.delete(`/api/customers/${customerId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    alert('Customer deleted successfully!');
                    location.reload(); 
                })
                .catch(error => {
                    console.error(error);
                    alert('Failed to delete customer');
                });
            }
        }
    </script>
@endsection
