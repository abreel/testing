<?php
use App\Models\User;
use Tests\TestCase;
class MerchantControllerGetmerchantstatTest extends TestCase{
    
    public function test_get_merchant_stat_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/core/merchant/stats");
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Merchants stats fetched successfully'
        ]);
    }
    
    public function test_get_merchant_stat_with_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/core/merchant/stats");
        
        // Assert the response
        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Validation error'
        ]);
    }
    
    public function test_get_merchant_stat_with_failed_authentication()
    {
        // Call api endpoint
        $response = $this->getJson("/core/merchant/stats");
        
        // Assert the response
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Unauthenticated'
        ]);
    }
    
    public function test_get_merchant_stat_with_invalid_route()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/core/merchants/stats");
        
        // Assert the response
        $response->assertStatus(404);
        $response->assertJson([
            'success' => false,
            'message' => 'Not Found'
        ]);
    }
}