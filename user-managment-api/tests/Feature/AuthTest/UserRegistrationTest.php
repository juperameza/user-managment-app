<?php

namespace Tests\Feature\AuthTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_register(): void
    {
        $userData = [
            "name" => "Test User",
            "email" => "testuser@example.com",
            "password" => "SecurePassword123!",
            "password_confirmation" => "SecurePassword123!",
        ];

        $response = $this->json('POST', 'api/register', $userData);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('users',[ "email"=>$userData['email']]);
    }

    public function test_user_cannot_register_with_invalid_email(): void
    {
        $userData = [
            "name" => "Test User",
            "email" => "notanemail",
            "password" => "SecurePassword123!",
            "password_confirmation" => "SecurePassword123!",
        ];
        $response = $this->json('POST', 'api/register', $userData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseMissing('users',[ "email"=>$userData['email']]);
    }

    public function test_user_cannot_register_with_unmatched_passwords(): void
    {
        $userData = [
            "name" => "Test User",
            "email" => "test@test.com",
            "password" => "SecurePassword123!",
            "password_confirmation" => "NotTheSameSecurePassword123!",
        ];
        $response = $this->json('POST', 'api/register', $userData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseMissing('users',[ "email"=>$userData['email']]);
    }
    public function test_user_cannot_register_with_existing_email(): void
    {
        $userData = [
            "name" => "Test User",
            "email" => "test@test.com",
            "password" => "SecurePassword123!",
            "password_confirmation" => "SecurePassword123!",
        ];
        $this->json('POST', 'api/register', $userData);
        $response = $this->json('POST', 'api/register', $userData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_cannot_register_with_insecure_password(): void
    {
        $userData = [
            "name" => "Test User",
            "email" => "test@test.com",
            "password" => "password",
            "password_confirmation" => "password",
        ];
        $response = $this->json('POST', 'api/register', $userData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertDatabaseMissing('users',[ "email"=>$userData['email']]);
    }
}
