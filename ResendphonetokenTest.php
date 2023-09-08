<?php
use App\Models\User;
use Tests\TestCase;
class UserComplianceControllerResendphonetokenTest extends TestCase{

    public function test_resend_phone_token_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/resend-phone-token");
    
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Token has been resent']);
    }

    public function test_resend_phone_token_fails_without_authentication(){
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/resend-phone-token");
    
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_resend_phone_token_fails_with_invalid_user(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/resend-phone-token", ['user_id' => 'invalid-id']);
    
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['message' => 'User not found']);
    }
}