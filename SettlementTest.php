<?php
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
class AffliateControllerSettlementTest extends TestCase{
    
    public function test_success_settlement_with_no_parameters(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/settlement");
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_success_settlement_with_valid_parameters(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        $wallet_id = Wallet::factory()->create()->id;
        $amount = 100;
        // Call api endpoint
        $response = $this->postJson("/settlement", [
            "wallet_id" => $wallet_id,
            "amount" => $amount
        ]);
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_failure_settlement_with_invalid_parameters(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Call api endpoint
        $response = $this->postJson("/settlement", [
            "wallet_id" => null,
            "amount" => null
        ]);
                
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["wallet_id", "amount"]);
    }

    public function test_failure_settlement_without_authentication(){
        // Call api endpoint
        $response = $this->postJson("/settlement");
                
        // Assert the response
        $response->assertStatus(401);
    }

}