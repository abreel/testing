<?php
use App\Models\Merchant;
use Tests\TestCase;

class ComplianceControllerGetmerchantdataTest extends TestCase
{
    public function test_merchant_data_success()
    {
        // Create a merchant
        $merchant = Merchant::factory()->create([
            'public_key' => '1234567890'
        ]);

        // Call api endpoint
        $response = $this->postJson("/merchant_data", [
            'public_key' => $merchant->public_key
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'data' => $merchant->toArray()
        ]);
    }

    public function test_merchant_data_not_found()
    {
        // Call api endpoint
        $response = $this->postJson("/merchant_data", [
            'public_key' => '1234567890'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'data' => null
        ]);
    }

    public function test_merchant_data_bad_validation()
    {
        // Call api endpoint
        $response = $this->postJson("/merchant_data", [
            'public_key' => ''
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The given data was invalid.',
            'errors' => [
                'public_key' => [
                    'The public key field is required.'
                ]
            ]
        ]);
    }
}
