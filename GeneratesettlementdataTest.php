<?php
use App\Models\User;
use Tests\TestCase;
class SettlementControllerGeneratesettlementdataTest extends TestCase{

    public function test_generate_settlement_data_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/generate-settlement");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'Transaction settlement generated with settlement batch'
        ]);
    }

    public function test_generate_settlement_data_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/generate-settlement");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'All Transaction settlements has been generated'
        ]);
    }

    public function test_generate_settlement_data_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/generate-settlement/1000");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'transaction_id'
            ]
        ]);
    }
}