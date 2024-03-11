<?php

namespace Tests\Feature\AuthTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    private $registrationData=[
        "name" => "Test User",
        "email" => "test@test.com",
        "password" => "SecurePassword123!",
        "password_confirmation" => "SecurePassword123!",
    ];


    public function test_user_can_login(): void
    {
        $userData = [
            "email" => "test@test.com",
            "password" => "SecurePassword123!",
        ];
        $this->json('POST', 'api/register', $this->registrationData);
        $response = $this->json('POST', 'api/login', $userData);
        Log::info($response->getContent());

        $response->assertStatus(Response::HTTP_OK);
    }
    public function test_user_cannot_login_with_invalid_email(): void
    {
        $userData = [
            "email" => "notanemail",
            "password" => "SecurePassword123!",
        ];
        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_user_cannot_login_with_invalid_password(): void
    {
        $userData = [
            "email" => "test@test.com",
            "password" => "SecurePassword123!",
        ];
        $this->json('POST', 'api/register', $this->registrationData);
        $userData['password'] = "NotTheSameSecurePassword123!";
        $response = $this->json('POST', 'api/login', $userData);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
