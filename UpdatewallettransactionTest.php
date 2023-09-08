<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerUpdatewallettransactionTest extends TestCase
{
    public function test_update_wallet_transaction_success()
    {
        //Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->postJson("/banking/update/wallet-transaction");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                'wallet_transaction_id',
                'created_at',
                'updated_at'
            ]);
    }

    public function test_update_wallet_transaction_failure()
    {
        //Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
       
        // Call api endpoint
        $response = $this->postJson("/banking/update/wallet-transaction");

        // Assert the response
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}