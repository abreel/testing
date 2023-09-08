<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Merchant;
use Tests\TestCase;

class CreatePublicVirtualAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_create_public_virtual_account()
    {
        // Create a merchant and authenticate
        $merchant = Merchant::factory()->create();
        $this->actingAs($merchant);

        $data = [
            'name' => 'John Doe',
            'bank_id' => 'BANK_ID',
            'currency' => 'NGN',
            'country' => 'NG',
            'description' => 'Test Description',
            'request_id' => 'REQUEST_ID'
        ];

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/virtual-account/create", $data);

        // Assert the response
        $response->assertStatus(200);
        $response->assertExactJson([
            'status' => true,
            'account_number' => 'string',
            'account_token' => 'string',
            'request_id' => 'REQUEST_ID',
        ]);
    }

    public function test_failure_create_public_virtual_account_with_missing_params()
    {
        // Create a merchant and authenticate
        $merchant = Merchant::factory()->create();
        $this->actingAs($merchant);

        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/virtual-account/create");

        // Assert the response
        $response->assertStatus(422);
        $response->assertExactJson([
            'status' => false,
            'message' => [
                'name' => ['The name field is required.'],
                'bank_id' => ['The bank id field is required.'],
                'currency' => ['The currency field is required.'],
                'country' => ['The country field is required.'],
            ]
        ]);
    }

    public function test_failure_create_public_virtual_account_with_invalid_private_key()
    {
        // Call api endpoint
        $response = $this->postJson("/api/v1/payment/virtual-account/create", [
            'private_key' => 'INVALID_PRIVATE_KEY',
        ]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertExactJson([
            'status' => false,
            'message' => 'Invalid Authorization key'
        ]);
    }
}