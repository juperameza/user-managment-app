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

    public function test_user_can_edit_their_profile(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('PUT', "api/user/$user->id", [
            "name" => "New Name",
            "email" => "new@mail.com"
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseHas('users', [
            'name' => 'New Name',
            'email' => 'new@mail.com']);
    }

    public function test_user_can_delete_their_profile(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('DELETE', "api/user/$user->id");
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_all_users_can_be_retrieved(): void
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"]);
        $response = $this->json('GET', "api/user");
        $response->assertStatus(Response::HTTP_OK);
    }
}
