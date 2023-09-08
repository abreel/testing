<?php
use App\Models\User;
use Tests\TestCase;
class TwoFAControllerVerifyTest extends TestCase
{
    public function test_2fa_key_validation_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/api/v1/2fa/verify', [
            'token' => $user->google2fa_secret,
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertExactJson([
            'success' => true,
            'message' => '2FA Key is Correct',
        ]);
    }

    public function test_2fa_key_validation_failed()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/api/v1/2fa/verify', [
            'token' => 'invalid-token',
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertExactJson([
            'success' => false,
            'message' => '2FA Key is incorrect',
        ]);
    }
}