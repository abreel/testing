<?php
use App\Models\User;
use Tests\TestCase;
class SettlementAdminControllerGettransactionsplitsdetailsTest extends TestCase{
    public function test_successful_transaction_splits_fetch(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/transaction-splits");
       
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data'
        ]);
    }
    
    public function test_unauthorized_user(){
        // Call api endpoint
        $response = $this->getJson("/transaction-splits");
       
        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message'
        ]);
    }
    
    public function test_invalid_parameter_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/transaction-splits?invalid_parameter=1");
       
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }
}