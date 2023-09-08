<?php
use App\Models\User;
use App\Models\WalletRequest;
use App\Models\WalletTransaction;
use Tests\TestCase;
class WalletRequestControllerDeclinerequestTest extends TestCase{
   
    public function test_decline_successfully(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a wallet request
        $walletRequest = WalletRequest::factory()->create([
            'status' => WalletTransaction::$status["pending"]
        ]);

        // Call api endpoint
        $response = $this->getJson("/decline/{$walletRequest->wallet_request_id}");
       
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_decline_unsuccessfully_request_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/decline/1");
       
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Wallet request not found']);
    }

    public function test_decline_unsuccessfully_request_already_approved(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a wallet request
        $walletRequest = WalletRequest::factory()->create([
            'status' => WalletTransaction::$status["approved"]
        ]);

        // Call api endpoint
        $response = $this->getJson("/decline/{$walletRequest->wallet_request_id}");
       
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Request already approved']);
    }

    public function test_decline_unsuccessfully_request_already_declined(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a wallet request
        $walletRequest = WalletRequest::factory()->create([
            'status' => WalletTransaction::$status["declined"]
        ]);

        // Call api endpoint
        $response = $this->getJson("/decline/{$walletRequest->wallet_request_id}");
       
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['success' => false, 'message' => 'Request already declined']);
    }
}