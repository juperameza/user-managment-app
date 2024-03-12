<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_user_can_edit_their_profile(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('PATCH', "api/users/$user->id", [
            "name" => "New Name",
            "email" => "new@mail.com"
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('users', [
            'name' => 'New Name',
            'email' => 'new@mail.com']);
    }

    public function test_user_can_edit_only_one_attribute_of_their_profile(): void
    {
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('PATCH', "api/users/{$user->id}", [
            "name" => "New Name",
            "email" => $user->email
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('users', [
            'name' => 'New Name']);
    }

    public function test_user_can_delete_their_profile(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('DELETE', "api/users/$user->id");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_all_users_can_be_retrieved(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('GET', "api/users");
        $response->assertStatus(Response::HTTP_OK);
    }
}
