<?php
use App\Models\User;
use Tests\TestCase;
class ComplianceControllerSettransactionpinTest extends TestCase{
    public function test_set_transaction_pin_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/set-transaction-pin", [
            'transaction_pin' => '1234',
            'transaction_pin_confirmation' => '1234'
        ]);
    
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'message' => "Transaction Pin Set Successfully"
        ]);
    }

    public function test_set_transaction_pin_failed_max_length(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/set-transaction-pin", [
            'transaction_pin' => '12345',
            'transaction_pin_confirmation' => '12345'
        ]);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            "success" => false,
            'message' => "The transaction pin may not be greater than 4 characters."
        ]);
    }

    public function test_set_transaction_pin_failed_min_length(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/set-transaction-pin", [
            'transaction_pin' => '123',
            'transaction_pin_confirmation' => '123'
        ]);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            "success" => false,
            'message' => "The transaction pin must be at least 4 characters."
        ]);
    }

    public function test_set_transaction_pin_failed_not_confirmed(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/set-transaction-pin", [
            'transaction_pin' => '1234',
            'transaction_pin_confirmation' => '12345'
        ]);
    
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            "success" => false,
            'message' => "The transaction pin confirmation does not match."
        ]);
    }
}