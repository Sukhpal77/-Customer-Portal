<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

        public function setUp(): void
        {
            parent::setUp();
    
            User::truncate();
        }
    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'user_id']);
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['error' => 'Unauthorized']);
    }

    public function test_login_validation_errors()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_mfa_verification_with_valid_token()
    {
        $user = User::factory()->create([
            'mfa_token' => '123456',
            'mfa_token_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->postJson('/api/verify-mfa', [
            'user_id' => $user->id,
            'mfa_token' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'message']);
    }

    public function test_mfa_verification_with_invalid_token()
    {
        $user = User::factory()->create([
            'mfa_token' => '123456',
            'mfa_token_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->postJson('/api/verify-mfa', [
            'user_id' => $user->id,
            'mfa_token' => '654321',
        ]);

        $response->assertStatus(400)
                 ->assertJson(['error' => 'Invalid or expired MFA token']);
    }

    public function test_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->accessToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logout successful']);
    }
}
