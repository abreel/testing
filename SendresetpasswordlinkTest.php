<?php
use App\Models\User;
use Tests\TestCase;
class TenancyAuthControllerSendresetpasswordlinkTest extends TestCase
{
    public function test_send_reset_password_link_success()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson('/tenancy/send/resetlink', [
            'email' => $user->email
        ]);
        
        // Assert the response
        $response->assertOk();
        $response->assertJson(["success" => true]);
        $response->assertJson(["message" => 'If you have an account with us, check your email.']);
    }

    public function test_send_reset_password_link_with_no_email()
    {
        // Call api endpoint
        $response = $this->postJson('/tenancy/send/resetlink', [
            'email' => ''
        ]);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(["success" => false]);
        $response->assertJson(["message" => 'The email field is required.']);
    }

    public function test_send_reset_password_link_with_non_existing_user()
    {
        // Call api endpoint
        $response = $this->postJson('/tenancy/send/resetlink', [
            'email' => 'non-existing@example.com'
        ]);
        
        // Assert the response
        $response->assertOk();
        $response->assertJson(["success" => true]);
        $response->assertJson(["message" => 'If you have an account with us, check your email.']);
    }
}