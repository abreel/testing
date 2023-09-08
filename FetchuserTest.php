<?php
use App\Models\User;
use Tests\TestCase;
class UserControllerFetchuserTest extends TestCase
{
    public function test_fetchUser_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/check-user/{$user->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(["success" => true, "message" => 'User Is Present', "data" => $user]);
    }

    public function test_fetchUser_not_found()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/core/check-user/{$user->id+1}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(["success" => false, "message" => 'User Not Found']);
    }
}
