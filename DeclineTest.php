<?php
use App\Models\User;
use Tests\TestCase;

class DocumentUploadControllerDeclineTest extends TestCase
{
    public function test_admin_decline_success()
    {
        // Create an admin user and authenticate
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/core/tier-upgrade/decline', [
            'reason' => 'test decline',
            'id' => 1,
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Declined Successfully'
        ]);
    }

    public function test_user_decline_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/core/tier-upgrade/decline', [
            'reason' => 'test decline',
            'id' => 1,
        ]);

        // Assert the response
        $response->assertStatus(405);
        $response->assertJson([
            'success' => false,
            'message' => 'Insufficient access'
        ]);
    }

    public function test_decline_validation_failure()
    {
        // Create an admin user and authenticate
        $user = User::factory()->create([
            'role' => 'admin'
        ]);
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/core/tier-upgrade/decline');

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The reason field is required.'
        ]);
    }
}
