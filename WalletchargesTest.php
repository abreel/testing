<?php
use App\Models\Merchant;
use Tests\TestCase;

class PaymentControllerWalletchargesTest extends TestCase
{
    public function test_wallet_charge_success()
    {
        // Create a merchant and authenticate
        $merchant = Merchant::factory()->create();
        $this->actingAs($merchant);

        // Call api endpoint
        $response = $this->getJson("/api/v1/wallet/charges");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'card' => [
                    'percentage',
                    'provider',
                    'flat'
                ],
                'transfer' => [
                    'percentage',
                    'provider',
                    'flat'
                ]
            ]
        ]);
    }

    public function test_wallet_charge_unauthorized_failure()
    {
        // Call api endpoint
        $response = $this->getJson("/api/v1/wallet/charges");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'status' => false,
            'message' => 'Merchant authorization credential is missing'
        ]);
    }

    public function test_wallet_charge_invalid_authorization_failure()
    {
        // Authenticate with invalid credentials
        $this->actingAs($merchant);

        // Call api endpoint
        $response = $this->getJson("/api/v1/wallet/charges");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'status' => false,
            'message' => 'Invalid Authorization key'
        ]);
    }
}
