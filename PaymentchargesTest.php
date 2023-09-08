<?php
use App\Models\Merchant;
use Tests\TestCase;

class PaymentControllerPaymentchargesTest extends TestCase
{

    public function test_payment_charges_with_valid_merchant_credentials()
    {
        // Create a merchant and authenticate
        $merchant = Merchant::factory()->create();
        $this->actingAs($merchant);

        // Call api endpoint
        $response = $this->postJson("/payment/charges", ['private_key' => $merchant->private_key]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'Fetched Sucessfully',
            'data' => [
                'card' => [
                    'percentage' => $cardPercentageCharges,
                    'flat' => $cardFlatCharges
                ],
                'transfer' => [
                    'percentage' => $transferPercentageCharges,
                    'flat' => $transferFlatCharges
                ],
            ],
        ]);
    }

    public function test_payment_charges_with_invalid_merchant_credentials()
    {
        // Call api endpoint
        $response = $this->postJson("/payment/charges", ['private_key' => 'invalid_key']);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'status' => false,
            'message' => 'Invalid Authorization key',
        ]);
    }

    public function test_payment_charges_with_missing_merchant_credentials()
    {
        // Call api endpoint
        $response = $this->postJson("/payment/charges");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'status' => false,
            'message' => 'Merchant authorization credential is missing',
        ]);
    }
}
