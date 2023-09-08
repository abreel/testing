<?php
use App\Models\User;
use Tests\TestCase;
class NotificationControllerReadallTest extends TestCase
{
    public function testReadAllSuccessForUser(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notifications/{$user->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'All Notifications Read Succesfully'
        ]);
    }

    public function testReadAllSuccessForAdmin(){
        // Create an admin and authenticate
        $admin = Admin::factory()->create();
        $this->actingAs($admin);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notifications/{$admin->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'All Notifications Read Succesfully'
        ]);
    }

    public function testReadAllFailureForNonAdmin(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notifications/{$user->id}");

        // Assert the response
        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'Access denied'
        ]);
    }

    public function testReadAllFailureForInvalidUser(){
        // Create an admin and authenticate
        $admin = Admin::factory()->create();
        $this->actingAs($admin);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/notifications/invalid_user");

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Notification not found'
        ]);
    }
}