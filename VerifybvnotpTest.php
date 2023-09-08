<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\BvnVerification;
use Tests\TestCase;

class ComplianceControllerVerifybvnotpTest extends TestCase
{
    use RefreshDatabase;

    public function testVerifyBvnOtpSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a BvnVerification
        $bvnVerification = BvnVerification::factory()->create([
            'user_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/verify-bvn-otp", [
            'token' => $bvnVerification->token,
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'OTP verified successfully'
        ]);
    }

    public function testVerifyBvnOtpFailureWrongToken()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/verify-bvn-otp", [
            'token' => 'wrong_token',
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Wrong token provided'
        ]);
    }

    public function testVerifyBvnOtpFailureAlreadyVerified()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a BvnVerification
        $bvnVerification = BvnVerification::factory()->create([
            'user_id' => $user->id,
            'status' => 'APPROVED'
        ]);

        // Call api endpoint
        $response = $this->postJson("/verify-bvn-otp", [
            'token' => $bvnVerification->token,
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Bvn has already been verified'
        ]);
    }

    public function testVerifyBvnOtpFailureExpiredToken()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a BvnVerification
        $bvnVerification = BvnVerification::factory()->create([
            'user_id' => $user->id,
            'token_expire_at' => Carbon::now()->subMinutes(1)
        ]);

        // Call api endpoint
        $response = $this->postJson("/verify-bvn-otp", [
            'token' => $bvnVerification->token,
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Token Expired!'
        ]);
    }

    public function testVerifyBvnOtpFailureBadValidation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/verify-bvn-otp", [
            'token' => '',
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The token field is required.'
        ]);
    }
}
