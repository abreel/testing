<?php
use App\Models\User;
use App\Models\Transaction;
use App\Models\Settlement;
use App\Models\SettlementBank;
use App\Models\RevenueHead;
use Tests\TestCase;
class SplitLogicControllerListsplitsTest extends TestCase{
    public function test_list_splits_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split");
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => true
            ]);
    }
    
    public function test_list_splits_with_transaction_id_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a transaction
        $transaction = Transaction::factory()->create();
        $transId = $transaction->id;
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split?trans_id=$transId");
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => true,
                'data' => [
                    'transaction_id' => $transId
                ]
            ]);
    }
    
    public function test_list_splits_with_settlement_id_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a settlement
        $settlement = Settlement::factory()->create();
        $settlementId = $settlement->id;
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split?settlement_id=$settlementId");
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => true,
                'data' => [
                    'settlement_id' => $settlementId
                ]
            ]);
    }
    
    public function test_list_splits_with_settlement_bank_id_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a settlement bank
        $bank = SettlementBank::factory()->create();
        $bankId = $bank->id;
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split?settlement_bank_id=$bankId");
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => true
            ]);
    }
    
    public function test_list_splits_with_revenue_head_id_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a revenue head
        $head = RevenueHead::factory()->create();
        $headId = $head->id;
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split?revenue_head_id=$headId");
        
        // Assert the response
        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => true
            ]);
    }
    
    public function test_list_splits_with_invalid_parameters()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split?invalid_param=test");
        
        // Assert the response
        $response->assertStatus(400)
            ->assertJsonFragment([
                'status' => false
            ]);
    }
    
    public function test_list_splits_with_unauthorized_request()
    {
        // Call api endpoint
        $response = $this->getJson("/api/v1/payment/settlement/admin/transaction-split");
        
        // Assert the response
        $response->assertStatus(401)
            ->assertJsonFragment([
                'status' => false
            ]);
    }
}