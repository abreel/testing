<?php
use App\Models\User;
use Tests\TestCase;
class PaymentControllerInittransferTest extends TestCase{
    public function test_initTransfer_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $transaction_id = 123;
        $response = $this->postJson("/payment/transactions/init-transfer", [
            'transaction_id' => $transaction_id
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        $response->assertJson([
            'status' => true,
            'message' => 'Successfully Initiated Transfer'
        ]);
    }

    public function test_initTransfer_failure_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/payment/transactions/init-transfer");
        
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
        $response->assertJson([
            'status' => false,
            'message' => 'The transaction id field is required.'
        ]);
    }

    public function test_initTransfer_failure_transaction_not_found(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $transaction_id = 123;
        $response = $this->postJson("/payment/transactions/init-transfer", [
            'transaction_id' => $transaction_id
        ]);
        
        $response->assertStatus(404);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);
        $response->assertJson([
            'status' => false,
            'message' => 'Invalid Transaction: Transaction Not Found'
        ]);
    }
}