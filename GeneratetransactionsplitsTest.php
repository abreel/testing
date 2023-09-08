

<?php
use Tests\TestCase;
class TransactionControllerGeneratetransactionsplitsTest extends TestCase{
    public function generateTransactionSplitsTest_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        //create a transaction
        $transaction = Transaction::factory()->create();
        
        // Call api endpoint
        $response = $this->postJson("/transaction/splits/{$transaction->id}");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['status' => true, 'message' => 'Transactions split generated successfully']);
    }

    public function generateTransactionSplitsTest_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint without transaction id
        $response = $this->postJson("/transaction/splits");
        
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson(['status' => false, 'message' => 'Error generating transaction splits']);
    }

}