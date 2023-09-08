<?php
use App\Models\User;
use Tests\TestCase;
class LogsControllerActivityTest extends TestCase{
    public function test_activity_when_user_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with user parameter
        $response = $this->postJson("/core/audit-log/activity",['user' => $user->id]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => true]);
    }

    public function test_activity_when_user_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with no user parameter
        $response = $this->postJson("/core/audit-log/activity",[]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false]);
    }

    public function test_activity_when_user_invalid(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint with invalid user parameter
        $response = $this->postJson("/core/audit-log/activity",['user' => 'invalid_user_id']);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => false]);
    }

    public function test_activity_when_user_not_provided(){
        // Call api endpoint with no user parameter
        $response = $this->getJson("/core/audit-log/activity");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
        $response->assertJson(['success' => true]);
    }
}