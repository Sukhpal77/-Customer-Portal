<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="Customer",
 *     description="Operations related to customers"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     required={"first_name", "last_name", "age", "dob", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="Sukhpal"),
 *     @OA\Property(property="last_name", type="string", example="Singh"),
 *     @OA\Property(property="age", type="integer", example=25),
 *     @OA\Property(property="dob", type="string", format="date", example="1999-12-26"),
 *     @OA\Property(property="email", type="string", format="email", example="Sukhpal.Singh@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-10T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-10T12:34:56Z")
 * )
 */

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customers",
     *     summary="List all customers",
     *     description="Retrieve a list of all customers.",
     *     tags={"Customers"},
     *     @OA\Response(
     *         response=200,
     *         description="List of customers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         )
     *     )
     * )
     */

    public function index()
    {
        return response()->json(Customer::all());
    }

    /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Show a specific customer",
     *     description="Retrieve details of a specific customer by their ID.",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer details",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return response()->json($customer);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     summary="Create a new customer",
     *     description="Create a new customer and store the information.",
     *     tags={"Customers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "age", "dob", "email"},
     *             @OA\Property(property="first_name", type="string", example="Sukhpal"),
     *             @OA\Property(property="last_name", type="string", example="Singh"),
     *             @OA\Property(property="age", type="integer", example=25),
     *             @OA\Property(property="dob", type="string", format="date", example="1999-12-26"),
     *             @OA\Property(property="email", type="string", format="email", example="Sukhpal.Singh@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Customer created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Customer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'age' => 'required|integer|min:1|max:120',
            'dob' => 'required|date',
            'email' => 'required|email|unique:customers,email',
        ]);

        $customer = Customer::create($request->all());
        return response()->json(['message' => 'Customer created successfully', 'data' => $customer], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update a customer",
     *     description="Update the details of an existing customer by their ID.",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Sukhpal"),
     *             @OA\Property(property="last_name", type="string", example="Singh"),
     *             @OA\Property(property="age", type="integer", example=25),
     *             @OA\Property(property="dob", type="string", format="date", example="1999-12-26"),
     *             @OA\Property(property="email", type="string", format="email", example="Sukhpal.Singh@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Customer updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Customer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $request->validate([
            'first_name' => 'string|max:50',
            'last_name' => 'string|max:50',
            'age' => 'integer|min:1|max:120',
            'dob' => 'date',
            'email' => 'email|unique:customers,email,' . $id,
        ]);

        $customer->update($request->all());
        return response()->json(['message' => 'Customer updated successfully', 'data' => $customer]);
    }

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Delete a customer",
     *     description="Delete a specific customer by their ID.",
     *     tags={"Customers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Customer deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
