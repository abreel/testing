<?php
use App\Models\User;
use Tests\TestCase;
class AuthControllerCheckuserexistTest extends TestCase
{
    public function test_check_user_exist_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/core/auth/check-user-exist', ["user_id" => $user->id]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => $user->id]);
    }

    public function test_check_user_exist_failure_validation_error()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/core/auth/check-user-exist', []);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The user id field is required.']);
    }

    public function test_check_user_exist_failure_non_existing_user()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/api/v1/core/auth/check-user-exist', ["user_id" => 999]);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(["success" => false, "message" => 999]);
    }
}