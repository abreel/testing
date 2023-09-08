<?php
use App\Models\User;
use App\Models\Merchant;
use Tests\TestCase;

class MerchantControllerLoginasmerchantTest extends TestCase
{

    public function test_loginAsMerchant_with_valid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Create a merchant
        $merchant = Merchant::factory()->create(['user_id' => $user->id]);

        // Call api endpoint
        $response = $this->postJson('/login/as', ['merchant_id' => $merchant->id]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJson(['message' => "Business Changed Successfully"]);
        $response->assertJson(['id' => $merchant->id]);
    }

    public function test_loginAsMerchant_with_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Call api endpoint
        $response = $this->postJson('/login/as', ['merchant_id' => 0]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => "Merchant Not Found!"]);
    }
    
    public function test_loginAsMerchant_without_authentication()
    {
        // Call api endpoint
        $response = $this->postJson('/login/as', ['merchant_id' => 0]);

        // Assert the response
        $response->assertStatus(403);
    }
}