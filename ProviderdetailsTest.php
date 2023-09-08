<?php
use App\Models\User;
use Tests\TestCase;
class ProviderControllerProviderdetailsTest extends TestCase{
    public function test_provider_details_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $account_number = 987654;
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/banking/transactions/with-cr-account", [
            'account_number' => $account_number
        ]);
                
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Data fetched Successfully',
            'data' => []
        ]);
    }
    
    public function test_provider_details_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $account_number = 'invalid';
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/banking/transactions/with-cr-account", [
            'account_number' => $account_number
        ]);
                
        // Assert the response
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false
        ]);
    }
    
    public function test_provider_details_unauthorized(){
        // Call api endpoint
        $response = $this->postJson("/banking/transactions/with-cr-account", [
            'account_number' => 987654
        ]);
                
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false
        ]);
    }
    
    public function test_provider_details_bad_validation(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson("/banking/transactions/with-cr-account", [
            'account_number' => ''
        ]);
                
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false
        ]);
    }
}