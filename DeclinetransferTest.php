<?php
use App\Models\User;
use App\Models\WalletTransaction;
use Tests\TestCase;
class WalletControllerDeclinetransferTest extends TestCase{
    public function test_decline_transfer_with_valid_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Valid wallet Transaction
        $walletTransaction = WalletTransaction::factory()->create([
            'status' => 'PENDING',
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/decline/transfer", [
            'wallet_transaction_id' => $walletTransaction->wallet_transaction_id
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
    }

    public function test_decline_transfer_with_invalid_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/decline/transfer", [
            'wallet_transaction_id' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_decline_transfer_with_invalid_wallet_transaction(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create Valid wallet Transaction
        $walletTransaction = WalletTransaction::factory()->create([
            'status' => 'DECLINED',
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/decline/transfer", [
            'wallet_transaction_id' => $walletTransaction->wallet_transaction_id
        ]);

        // Assert the response
        $response->assertStatus(422);
        $response->assertJson(['success' => false]);
    }
}