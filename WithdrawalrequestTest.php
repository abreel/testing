<?php
use App\Models\User;
use App\Models\Account;
use Tests\TestCase;
class TransactionControllerWithdrawalrequestTest extends TestCase{
 
    public function test_withdrawal_request_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $accountId = auth()->user()->active_account;
        $walletId = Account::where('id', $accountId)->pluck('wallet_id')->first();
        $response = $this->getJson("/withdrawal-requests", [
           'wallet_id' => $walletId,
           'perPage' => 10
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'wallet_id',
                    'amount',
                    'type',
                    'purpose',
                    'status',
                    'date',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    public function test_withdrawal_request_failed(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $accountId = auth()->user()->active_account;
        $walletId = Account::where('id', $accountId)->pluck('wallet_id')->first();
        $response = $this->getJson("/withdrawal-requests", [
           'wallet_id' => $walletId,
           'perPage' => 'string'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('perPage');
    }

    public function test_withdrawal_request_unauthorized(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $accountId = auth()->user()->active_account;
        $walletId = Account::where('id', $accountId)->pluck('wallet_id')->first();
        $response = $this->getJson("/withdrawal-requests", [
           'wallet_id' => $walletId,
           'perPage' => 10
        ]);
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }

}