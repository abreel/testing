<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerAccountwalletsTest extends TestCase{
    
    public function test_account_wallets_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson('/account');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'data']);
        $response->assertJson(['status' => true]);
    }
    public function test_account_wallets_unauthorized(){
        // Call api endpoint
        $response = $this->getJson('/account');

        // Assert the response
        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthenticated.']);
    }
    public function test_account_wallets_type_parameter(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint with type parameter
        $response = $this->getJson('/account?type=customer');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'data']);
        $response->assertJson(['status' => true]);
    }
    public function test_account_wallets_invalid_type_parameter(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint with invalid type parameter
        $response = $this->getJson('/account?type=invalid');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'data']);
        $response->assertJson(['status' => false]);
    }
}