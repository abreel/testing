<?php
use App\Models\User;
use App\Models\VirtualAccount;
use Tests\TestCase;
class WalletRequestControllerCreaterequestTest extends TestCase{
    public function test_create_request_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create();

        // Call api endpoint 
        $response = $this->postJson("/transfer/request/", [
            'debit_account_number' => $virtualAccount->account_number,
            'amount' => 1000
        ]);

        // Assert the response
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Wallet Request Created',
            'data' => [
                'wallet_id' => $user->wallet->id,
                'debit_account_number' => $virtualAccount->account_number,
                'credit_account_number' => $virtualAccount->account_number,
                'amount' => 1000,
                'status' => 'pending'
            ]
        ]);
    }

    public function test_create_request_with_negative_amount(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create();

        // Call api endpoint 
        $response = $this->postJson("/transfer/request/", [
            'debit_account_number' => $virtualAccount->account_number,
            'amount' => -1000
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Invalid amount passed',
            'data' => [
                'debit_account_number' => $virtualAccount->account_number,
                'amount' => -1000
            ]
        ]);
    }

    public function test_create_request_with_invalid_debit_account_number(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint 
        $response = $this->postJson("/transfer/request/", [
            'debit_account_number' => 'INVALID_NUMBER',
            'amount' => 1000
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'The selected debit account number is invalid.',
            'data' => [
                'debit_account_number' => 'INVALID_NUMBER',
                'amount' => 1000
            ]
        ]);
    }

    public function test_create_request_with_same_debit_and_credit_account_number(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create();

        // Call api endpoint 
        $response = $this->postJson("/transfer/request/", [
            'debit_account_number' => $virtualAccount->account_number,
            'amount' => 1000
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'You can not transfer to the same account ',
            'data' => []
        ]);
    }

    public function test_create_request_without_authentication(){
        // Create a virtual account
        $virtualAccount = VirtualAccount::factory()->create();

        // Call api endpoint 
        $response = $this->postJson("/transfer/request/", [
            'debit_account_number' => $virtualAccount->account_number,
            'amount' => 1000
        ]);

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }
}