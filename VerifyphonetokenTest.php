<?php
use App\Models\User;
use Tests\TestCase;
class UserComplianceControllerVerifyphonetokenTest extends TestCase
{
    public function test_success_verification_of_a_valid_token(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a valid token
        User::where('id', $user->id)->update([
            'phone_token' => Str::random(6),
            'expiration_date' => Carbon::now()->addMinutes(10)
        ]);
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/verify-phone-token", [
            'token' => $user->phone_token
        ]);
        
        // Assert the response
        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Token is Valid'
            ]);
    }

    public function test_failure_verification_of_an_invalid_token(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a token
        User::where('id', $user->id)->update([
            'phone_token' => Str::random(6),
            'expiration_date' => Carbon::now()->addMinutes(10)
        ]);
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/verify-phone-token", [
            'token' => Str::random(6)
        ]);
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid Token Provided'
            ]);
    }

    public function test_failure_verification_of_an_expired_token(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a token
        User::where('id', $user->id)->update([
            'phone_token' => Str::random(6),
            'expiration_date' => Carbon::now()->subMinutes(10)
        ]);
        // Call api endpoint
        $response = $this->postJson("/api/v1/core/general/verify-phone-token", [
            'token' => $user->phone_token
        ]);
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Token Expired!'
            ]);
    }
}