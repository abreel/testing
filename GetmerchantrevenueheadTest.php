<?php
use App\Models\User;
use Tests\TestCase;
class RevenueHeadControllerGetmerchantrevenueheadTest extends TestCase{
    public function test_get_merchant_revenue_head_success(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Call api endpoint
        $response = $this->getJson("/payment/revenue_head/merchant");
        // Assert the response
        $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'settlementBank' => [
                    'id',
                    'merchant_id',
                ]
            ]
        ]);
    }

    public function test_get_merchant_revenue_head_failure(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Call api endpoint
        $response = $this->getJson("/payment/revenue_head/merchant");
        // Assert the response
        $response->assertStatus(400);
    }

    public function test_get_merchant_revenue_head_unauthorized(){
        // Create a user and authenticate
        $user = User::factory()->create();
        // Call api endpoint
        $response = $this->getJson("/payment/revenue_head/merchant");
        // Assert the response
        $response->assertStatus(401);
    }

    public function test_get_merchant_revenue_head_invalid_route(){
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
        // Call api endpoint
        $response = $this->getJson("/payment/revenue_head/merchant/invalid");
        // Assert the response
        $response->assertStatus(404);
    }
}