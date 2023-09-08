<?php
use App\Models\User;
use Tests\TestCase;
class TwoFAControllerEnable2faTest extends TestCase
{
    public function test_success_2fa_enable()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/2fa/enable", [
            'twofa_type' => 'SMS'
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    public function test_failure_2fa_enable()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/2fa/enable", [
            'twofa_type' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_invalid_2fa_type()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/2fa/enable", [
            'twofa_type' => 'invalid_type'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_missing_phone_number()
    {
        // Create a user without phone and authenticate
        $user = User::factory()->create(['phone' => null]);
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/2fa/enable", [
            'twofa_type' => 'SMS'
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
    }

    public function test_enable_google_2fa()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/2fa/enable", [
            'twofa_type' => 'GOOGLE2FA'
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }
}