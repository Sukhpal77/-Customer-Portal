<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Customer;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        Customer::truncate();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('TestToken')->accessToken;
    }

    public function test_list_all_customers()
    {
        $customers = Customer::factory()->count(3)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/customers');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_show_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
                 ->assertJson(['id' => $customer->id]);
    }

    public function test_show_non_existent_customer()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/customers/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Customer not found']);
    }

    public function test_create_customer()
    {
        $customerData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'dob' => '1994-01-01',
            'email' => 'john.doe@example.com',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/customers', $customerData);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Customer created successfully',
                     'data' => $customerData,
                 ]);
    }

    public function test_update_customer()
    {
        $customer = Customer::factory()->create();
        $updatedData = [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'age' => 28,
            'dob' => '1996-04-01',
            'email' => 'jane.smith@example.com',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/customers/{$customer->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Customer updated successfully',
                     'data' => $updatedData,
                 ]);
    }

    public function test_update_non_existent_customer()
    {
        $updatedData = [
            'first_name' => 'Non',
            'last_name' => 'Existent',
            'age' => 50,
            'dob' => '1975-06-15',
            'email' => 'non.existent@example.com',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/customers/999', $updatedData);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Customer not found']);
    }

    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Customer deleted successfully']);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_delete_non_existent_customer()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/customers/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Customer not found']);
    }
}
