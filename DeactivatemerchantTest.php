<?php
use App\Models\Merchant;
use Tests\TestCase;

class MerchantControllerDeactivatemerchantTest extends TestCase
{
    public function test_deactivate_success()
    {
        // Create a merchant
        $merchant = Merchant::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/deactivate/{$merchant->id}");

        // Assert the response
        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonFragment(['message' => 'You successfully De-Activated this Merchant! ']);
    }

    public function test_deactivate_merchant_not_found()
    {
        // Call api endpoint with a non existing merchant id
        $response = $this->postJson("/deactivate/{$nonExistingMerchantID}");

        // Assert the response
        $response->assertStatus(404)
            ->assertJson(['success' => false])
            ->assertJsonFragment(['message' => 'Merchant Not Found!']);
    }
}
