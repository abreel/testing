<?php
use App\Models\User;
use Tests\TestCase;
class MerchantControllerAll_merchantsTest extends TestCase
{
    public function test_all_merchants_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/payment/merchant-all");
        
        // Assert response
        $response->assertOk()
            ->assertJson(["success" => true, "message" => "All merchants"])
            ->assertJsonStructure(["success", "message", "data"]);
    }

    public function test_all_merchants_bad_validation()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->getJson("/payment/merchant-all", ['limit' => 'string']);
        
        // Assert response
        $response->assertStatus(422);
    }
    
    public function test_all_merchants_search_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $query = 'query';
        $response = $this->getJson("/payment/merchant-all?search=$query");
        
        // Assert response
        $response->assertOk()
            ->assertJson(["success" => true, "message" => "All merchants"])
            ->assertJsonStructure(["success", "message", "data"]);
    }
    
    public function test_all_merchants_limit_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $limit = 10;
        $response = $this->getJson("/payment/merchant-all?limit=$limit");
        
        // Assert response
        $response->assertOk()
            ->assertJson(["success" => true, "message" => "All merchants"])
            ->assertJsonStructure(["success", "message", "data"]);
    }
}