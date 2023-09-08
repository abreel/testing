<?php
use App\Models\User;
use Tests\TestCase;

class NotificationControllerNotificationbadgeTest extends TestCase
{
    public function test_notification_badge_withdrawal_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/core/general/notification-badge?notificationType=Withdrawal-Request');

        // Assert the response
        $response->assertSuccessful();
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $this->assertEquals(1, $response->json()['data']['notification_count']);
    }

    public function test_notification_badge_activation_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/core/general/notification-badge?notificationType=Activation-Request');

        // Assert the response
        $response->assertSuccessful();
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $this->assertEquals(1, $response->json()['data']['notification_count']);
    }

    public function test_notification_badge_invalid_notification_type_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/api/v1/core/general/notification-badge?notificationType=invalid-type');

        // Assert the response
        $response->assertStatus(400);
        $this->assertJson($response->getContent());
        $this->assertEquals(0, $response->json()['data']['notification_count']);
    }
}
