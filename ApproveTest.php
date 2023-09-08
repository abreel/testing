<?php
use App\Models\User;
use Tests\TestCase;
class DocumentUploadControllerApproveTest extends TestCase{
    public function test_approve_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/core/tier-upgrade/approve',[
            'id' => 1
        ]);
    
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_approve_failure_unauthorized()
    {
        // Call api endpoint
        $response = $this->postJson('/core/tier-upgrade/approve',[
            'id' => 1
        ]);
    
        // Assert the response
        $response->assertStatus(405);
        $response->assertJson(['success' => false, 'message' => "Insufficient access"]);
    }

    public function test_approve_failure_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/core/tier-upgrade/approve',[
            'id' => 'invalid_id'
        ]);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }
}