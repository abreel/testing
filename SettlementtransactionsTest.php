<?php
use App\Models\User;
use App\Models\Merchant;
use Tests\TestCase;
class TransactionControllerSettlementtransactionsTest extends TestCase{
    public function test_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $merchantID = Merchant::factory()->create(['creator_id' => $user->id]);

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/settlement-transactions?merchant_id={$merchantID->id}");
    
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'transaction_ref', 'customer', 'amount', 'status', 'channel', 'transaction_splits'
                ]
            ]
        ]);
    }

    public function test_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $merchantID = Merchant::factory()->create(['creator_id' => $user->id]);

        // Call api endpoint
        $response = $this->getJson("/payment/transactions/settlement-transactions?merchant_id={$merchantID->id}");
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'error'
        ]);
    }

    public function test_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/payment/transactions/settlement-transactions?merchant_id=");
    
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors'
        ]);
    }
}