<?php
use App\Models\User;
use App\Models\PasswordReset;
use Tests\TestCase;
class AuthControllerVerifytokenTest extends TestCase{
    public function test_success_verify_token(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create token
        $token = PasswordReset::create([
            'email' => $user->email,
            'token' => str_random(20)
        ]);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/auth/verify-email-token", [
            'email' => $user->email,
            'token' => $token->token
        ]);
    
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Token Matches'
        ]);
    }
    
    public function test_fail_verify_token(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/auth/verify-email-token", [
            'email' => $user->email,
            'token' => str_random(20)
        ]);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Token does not Match'
        ]);
    }
}