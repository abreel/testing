<?php
use App\Models\Wallet;
use Tests\TestCase;
class MerchantsTest extends TestCase
{
    public function test_merchants_returns_success_with_data()
    {
        // Create a wallet and authenticate
        $wallet = Wallet::factory()->create();
        $this->actingAs($wallet);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/banking/wallet/merchants/{$wallet->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonFragment(['success'=>true]);
        $response->assertJsonStructure(
            [
                'success',
                'data' => [
                    'current_page',
                    'data' => [
                        [
                            'id',
                            'first_name',
                            'last_name',
                            'email'
                        ]
                    ]
                ]
            ]
        );
    }
    
    public function test_merchants_returns_failure_when_wallet_not_found()
    {
        // Create a wallet and authenticate
        $wallet = Wallet::factory()->create();
        $this->actingAs($wallet);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/banking/wallet/merchants/0");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonFragment(['success'=>false]);
        $response->assertJsonStructure(['success', 'message']);
    }
    
    public function test_merchants_returns_failure_when_unauthorized()
    {
        // Call api endpoint
        $response = $this->getJson("/api/v1/banking/wallet/merchants/1");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonFragment(['success'=>false]);
        $response->assertJsonStructure(['success', 'message']);
    }
    
    public function test_merchants_returns_failure_when_invalid_parameters()
    {
        // Create a wallet and authenticate
        $wallet = Wallet::factory()->create();
        $this->actingAs($wallet);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/banking/wallet/merchants/invalid-param");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonFragment(['success'=>false]);
        $response->assertJsonStructure(['success', 'message']);
    }
}