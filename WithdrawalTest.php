<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerWithdrawalTest extends TestCase{
    
    public function test_successful_withdrawal(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data
        $data = [
            'amount' => 10,
            'bank_code'   => '058',
            'account_number' => '12345678',
            'wallet_id' => $user->wallet()->first()->id
        ];
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/withdrawal", $data);
        
        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Withdrawal request is processing'
        ]);
    }
    
    public function test_withdrawal_invalid_amount(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data
        $data = [
            'amount' => 0,
            'bank_code'   => '058',
            'account_number' => '12345678',
            'wallet_id' => $user->wallet()->first()->id
        ];
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/withdrawal", $data);
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The amount must be at least 1.'
        ]);
    }
    
    public function test_withdrawal_invalid_bank_code(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data
        $data = [
            'amount' => 10,
            'bank_code'   => '000',
            'account_number' => '12345678',
            'wallet_id' => $user->wallet()->first()->id
        ];
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/withdrawal", $data);
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'The selected bank code does not exist!'
        ]);
    }
    
    public function test_withdrawal_invalid_account_number(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data
        $data = [
            'amount' => 10,
            'bank_code'   => '058',
            'account_number' => '00000000',
            'wallet_id' => $user->wallet()->first()->id
        ];
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/withdrawal", $data);
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'The selected account number does not exist!'
        ]);
    }
    
    public function test_withdrawal_invalid_wallet_id(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data
        $data = [
            'amount' => 10,
            'bank_code'   => '058',
            'account_number' => '12345678',
            'wallet_id' => 0
        ];
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/withdrawal", $data);
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'The selected wallet does not belong to this account!'
        ]);
    }
    
    public function test_withdrawal_insufficient_fund(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Prepare data
        $data = [
            'amount' => 1000000,
            'bank_code'   => '058',
            'account_number' => '12345678',
            'wallet_id' => $user->wallet()->first()->id
        ];
        
        // Call api endpoint
        $response = $this->postJson("/api/v1/banking/wallet/withdrawal", $data);
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Insufficient Fund!'
        ]);
    }
}