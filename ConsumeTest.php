<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
class DemoliveApiControllerConsumeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test consume() method with valid params
     *
     * @return void
     */
    public function test_consume_with_valid_params()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            "first_name" => 'John',
            "last_name" => 'Doe',
            "user_type" => 'Merchant',
            "email" => 'johndoe@example.com',
            "password" => 'password',
            "password_confirmation" => 'password',
            "business_name" => 'John Doe Merchant',
            "phone" => '1234567890',
            "bvn" => '123456789',
            "bank_code" => '123',
            "account_no" => '1234567890',
            "account_name" => 'John Doe',
            "settlement_bank_title" => 'John Doe Bank',
            "bank_name" => 'John Doe',
            "settlement_email" => 'johndoe@example.com',
        ];

        $response = $this->postJson('/api/v1/core/auth/onboard-api', $data);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Merchant Onboarding Successful',
            'data' => $data
        ]);
    }

    /**
     * Test consume() method with invalid params
     *
     * @return void
     */
    public function test_consume_with_invalid_params()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            "first_name" => 'John',
            "last_name" => 'Doe',
            "user_type" => 'Merchant',
            "email" => 'johndoe@example.com',
            "password" => 'password',
            "password_confirmation" => 'password',
            "business_name" => 'John Doe Merchant',
            "phone" => '1234567890',
            "bvn" => '123456789',
            "bank_code" => '123',
            "account_no" => '',
            "account_name" => 'John Doe',
            "settlement_bank_title" => 'John Doe Bank',
            "bank_name" => 'John Doe',
            "settlement_email" => 'johndoe@example.com',
        ];

        $response = $this->postJson('/api/v1/core/auth/onboard-api', $data);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The account no field is required.'
        ]);
    }
}