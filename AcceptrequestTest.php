<?php
use App\Models\User;
use App\Models\WalletRequest;
use App\Models\VirtualAccount;
use App\Models\WalletTransaction;
use Tests\TestCase;

class WalletRequestControllerAcceptrequestTest extends TestCase
{
    public function testAcceptRequestSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a wallet request
        $walletRequest = WalletRequest::factory()->create();

        // Create a virtual account
        $debitAcWallet = VirtualAccount::factory()->create([
            'account_number' => $walletRequest->dbaccount_no,
        ]);

        // Call api endpoint
        $response = $this->postJson("/approve/{$walletRequest->wallet_request_id}", [
            'amount' => $walletRequest->amount,
            'bank_code' => $walletRequest->craccount_bank_code,
            'account_number' => $walletRequest->craccount_no,
            'account_name' => $walletRequest->craccount_name,
            'wallet_id' => $debitAcWallet->wallet_id,
            'request_payment_id' => $walletRequest->wallet_request_id,
            'type' => "request",
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);
    }

    public function testAcceptRequestNotFound()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a wallet request
        $walletRequest = WalletRequest::factory()->create();

        // Call api endpoint
        $response = $this->postJson("/approve/{$walletRequest->wallet_request_id}");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Wallet request not found',
        ]);
    }

    public function testAcceptRequestAlreadyApproved()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a wallet request
        $walletRequest = WalletRequest::factory()->create([
            'status' => WalletTransaction::$status["approved"],
        ]);

        // Call api endpoint
        $response = $this->postJson("/approve/{$walletRequest->wallet_request_id}");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Request already approved',
        ]);
    }
}
