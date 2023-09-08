<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerCreditTest extends TestCase{
    public function test_successful_credit_transaction(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/credit", [
            'wallet_id' => $user->wallet_id,
            'amount' => 10
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Wallet funded successfully'
        ]);
    }

    public function test_failed_validation_credit_transaction(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/credit", [
            'amount' => 10
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'wallet_id is required'
        ]);
    }

    public function test_failed_amount_validation_credit_transaction(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/credit", [
            'wallet_id' => $user->wallet_id,
            'amount' => -10
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid Amount Provided'
        ]);
    }

    public function test_failed_internal_transfer_credit_transaction(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/credit", [
            'wallet_id' => $user->wallet_id,
            'amount' => 10,
            'purpose' => 'INTERNAL_TRANSFER',
            'craccount_no' => '11111111111',
            'craccount_name' => 'Test Account',
            'dbaccount_name' => 'Test Account',
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Verification failed. Please contact support'
        ]);
    }

}