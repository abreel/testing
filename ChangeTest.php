<?php
use App\Models\User;
use Tests\TestCase;
class AuthControllerChangeTest extends TestCase
{
    public function test_change_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/api/v1/change');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(["success" => true]);
    }

    public function test_change_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/api/v1/change');

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(["error" => "Something went wrong."]);
    }
    
    public function test_change_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/api/v1/change');

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(["error" => "Validation failed."]);
    }
}