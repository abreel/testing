<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class DemoLiveControllerNewonboardTest extends TestCase
{
    use RefreshDatabase;

    public function testUserNewOnboardSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create mock data for onboarding
        $data = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'user_type' => $user->usertype,
            'email' => $user->email,
            'password' => $user->password,
            'business_name' => 'Test Business',
            'phone' => '0987654321',
            'bvn' => '123456789',
            'bank_code' => '12345',
            'account_no' => '123456',
            'account_name' => 'Test Account',
            'settlement_bank_title' => 'Test Title',
            'bank_name' => 'Test Bank',
            'settlement_email' => 'test@email.com'
        ];

        // Call api endpoint
        $response = $this->postJson('/new-onboard', $data);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['status' => true, 'message' => 'User Is Updated Successfully']);
    }

    public function testUserNewOnboardValidationFails()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create mock data for onboarding
        $data = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'user_type' => $user->usertype,
            'email' => $user->email,
            'password' => $user->password,
            'business_name' => '',
            'phone' => '',
            'bvn' => '',
            'bank_code' => '',
            'account_no' => '',
            'account_name' => '',
            'settlement_bank_title' => '',
            'bank_name' => '',
            'settlement_email' => ''
        ];

        // Call api endpoint
        $response = $this->postJson('/new-onboard', $data);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function testUserNewOnboardUserNotFound()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create mock data for onboarding
        $data = [
            'id' => $user->id + 1,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'user_type' => $user->usertype,
            'email' => $user->email,
            'password' => $user->password,
            'business_name' => 'Test Business',
            'phone' => '0987654321',
            'bvn' => '123456789',
            'bank_code' => '12345',
            'account_no' => '123456',
            'account_name' => 'Test Account',
            'settlement_bank_title' => 'Test Title',
            'bank_name' => 'Test Bank',
            'settlement_email' => 'test@email.com'
        ];

        // Call api endpoint
        $response = $this->postJson('/new-onboard', $data);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['message' => 'User not found']);
    }
}
