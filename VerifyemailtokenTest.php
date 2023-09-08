<?php
use App\Models\User;
use Tests\TestCase;
class ComplianceControllerVerifyemailtokenTest extends TestCase
{
    public function test_email_is_verified_already_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        // Set request data
        $data = [
            'token' => $user->email_token
        ];

        // Call api endpoint
        $response = $this->postJson('/verify-email-token', $data);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => false, 'message' => "Email is already verified "]);
    }

    public function test_invalid_token_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set request data
        $data = [
            'token' => 'some-invalid-token'
        ];

        // Call api endpoint
        $response = $this->postJson('/verify-email-token', $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => "Email Token expired or can not be found "]);
    }

    public function test_valid_token_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set request data
        $data = [
            'token' => $user->email_token
        ];

        // Call api endpoint
        $response = $this->postJson('/verify-email-token', $data);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'message' => 'Email Verified Successfully']);
    }

    public function test_missing_token_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set request data
        $data = [];

        // Call api endpoint
        $response = $this->postJson('/verify-email-token', $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'The token field is required.']);
    }
}