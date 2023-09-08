<?php
use App\Models\User;
use Tests\TestCase;

class TwoFAControllerActivate2faTest extends TestCase
{
    //Test for successful activation
    public function test_activation_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/2fa/activate", [
            'twofa_type' => 'authenticator',
            'token' => '123456'
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => '2FA settings activated successfully'
        ]);
    }

    //Test for bad validation
    public function test_activation_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/2fa/activate", [
            'twofa_type' => '',
            'token' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The twofa type field is required.'
        ]);
    }

    //Test for failure to activate
    public function test_activation_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/2fa/activate", [
            'twofa_type' => 'authenticator',
            'token' => '654321'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Error activating 2FA.'
        ]);
    }
}