<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AccountControllerOnboardbusinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_onboard_business_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a payload for the request
        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'MERCHANT',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '09087654321',
            'business_name' => 'John Doe Business',
            'business_phone' => '09087654321',
            'business_email' => 'john@doe.com',
            'bvn' => '1234567890',
            'bank_code' => '044',
            'account_no' => '0000000000'
        ];

        // Call api endpoint
        $response = $this->postJson("/core/onboard-business", $payload);

        // Assert the response
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'Merchant Onboarding Successful'
        ]);
    }

    public function test_onboard_business_fails_with_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a payload for the request
        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'MERCHANT',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'invalid_password',
            'phone' => '09087654321',
            'business_name' => 'John Doe Business',
            'business_phone' => '09087654321',
            'business_email' => 'john@doe.com',
            'bvn' => '1234567890',
            'bank_code' => '044',
            'account_no' => '0000000000'
        ];

        // Call api endpoint
        $response = $this->postJson("/core/onboard-business", $payload);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The password confirmation does not match.'
        ]);
    }

    public function test_onboard_business_fails_with_existing_email()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a payload for the request
        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'MERCHANT',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '09087654321',
            'business_name' => 'John Doe Business',
            'business_phone' => '09087654321',
            'business_email' => 'john@doe.com',
            'bvn' => '1234567890',
            'bank_code' => '044',
            'account_no' => '0000000000'
        ];

        // Call api endpoint
        $response = $this->postJson("/core/onboard-business", $payload);

        // Assert the response
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'message' => 'User Exists',
            'user_id' => $user->id
        ]);
    }

    public function test_onboard_business_fails_with_invalid_bank_details()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a payload for the request
        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_type' => 'MERCHANT',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '09087654321',
            'business_name' => 'John Doe Business',
            'business_phone' => '09087654321',
            'business_email' => 'john@doe.com',
            'bvn' => '1234567890',
            'bank_code' => '044',
            'account_no' => 'invalid_account_no'
        ];

        // Call api endpoint
        $response = $this->postJson("/core/onboard-business", $payload);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'ACCOUNT DOES NOT EXIST'
        ]);
    }
}
