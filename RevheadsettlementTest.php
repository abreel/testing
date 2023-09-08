<?php
use App\Models\User;
use Tests\TestCase;
class SettlementAdminControllerRevheadsettlementTest extends TestCase{

    public function test_revHeadSettlement_returns_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/revsettlements", ['limit' => 10]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['settlements','stats']);
    }

    public function test_revHeadSettlement_returns_bad_request(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/revsettlements", ['limit' => -1]);
        
        // Assert the response
        $response->assertStatus(400);
    }

    public function test_revHeadSettlement_returns_filtered_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/revsettlements", ['search' => 'test-value']);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonFragment(['settlement_batch' => 'test-value']);
    }

    public function test_revHeadSettlement_returns_date_filtered_data(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/revsettlements", ['from' => '2020-01-30','to' => '2020-02-01']);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonFragment(['date_paid' => '2020-02-01']);
    }

}