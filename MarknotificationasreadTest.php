<?php
use App\Models\User;
use App\Models\Notification;
use Tests\TestCase;

class NotificationControllerMarknotificationasreadTest extends TestCase
{
    public function test_mark_notification_as_read_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a notification and save it
        $notification = Notification::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notification/{$notification->id}");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Notification Read Successfully',
            'data' => $notification
        ]);
    }
    
    public function test_mark_notification_as_read_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notification/9999");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Notification not found',
        ]);
    }
    
    public function test_mark_notification_as_read_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notification/");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'errors' => [
                'notification' => [
                    'The notification field is required.'
                ]
            ]
        ]);
    }
}