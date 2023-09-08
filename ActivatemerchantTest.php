<?php
use App\Models\User;
use App\Models\Merchant;
use Tests\TestCase;

class MerchantControllerActivatemerchantTest extends TestCase
{
    public function testSuccessfulMerchantActivation()
    {
        // Create a merchant and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant
        $merchant = Merchant::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/activate/{$merchant->id}", [
            'wallet_type' => 'MERCHANT',
            'account_id' => $merchant->account_id,
            'merchant_id' => $merchant->id,
            'name' => $merchant->business_name,
            'description' => 'Default Wallet'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'You successfully Activated this Merchant! '
        ]);
    }

    public function testFailedMerchantActivation()
    {
        // Create a merchant and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $merchantId = 999;
        $response = $this->postJson("/activate/{$merchantId}", [
            'wallet_type' => 'MERCHANT',
            'account_id' => $merchant->account_id,
            'merchant_id' => $merchant->id,
            'name' => $merchant->business_name,
            'description' => 'Default Wallet'
        ]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Merchant Not Found!'
        ]);
    }
}
