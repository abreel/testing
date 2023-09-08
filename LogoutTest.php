<?php
use App\Models\User;
use Tests\TestCase;
class AuthControllerLogoutTest extends TestCase{

    public function test_logout_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/api/v1/core/auth/logout', [
            'user_id' => $user->id
        ]);

        // Assert response code
        $response->assertStatus(200);

        // Assert response format
        $response->assertJson([
            'success' => true,
            'message' => 'User has been logged out'
        ]);
    }

    public function test_logout_failure()
    {
        // Call api endpoint
        $response = $this->postJson('/api/v1/core/auth/logout');

        // Assert response code
        $response->assertStatus(401);

        // Assert response format
        $response->assertJson([
            'success' => false,
            'message' => 'Unauthenticated'
        ]);
    }
}