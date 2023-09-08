<?php
use App\Models\User;
use Tests\TestCase;
class NotificationControllerListnotificationsTest extends TestCase
{
    public function test_list_notifications_user_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/v1/core/general/notifications');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Notifications Generated Succesfully',
            'data' => [],
        ]);
    }

    public function test_list_notifications_user_failure_limit_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/v1/core/general/notifications?limit=-1');

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Validation Error',
        ]);
    }

    public function test_list_notifications_admin_success()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $response = $this->getJson('/api/v1/core/general/notifications');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Notifications Generated Succesfully',
            'data' => [],
        ]);
    }

    public function test_list_notifications_admin_failure_limit_validation()
    {
        // Create an admin user and authenticate
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $response = $this->getJson('/api/v1/core/general/notifications?limit=-1');

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Validation Error',
        ]);
    }
}