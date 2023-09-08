<?php
use App\Models\User;
use App\Models\Merchant;
use Tests\TestCase;
class DemoliveApiControllerAllow_switchTest extends TestCase
{
    public function test_allow_switch_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant with ACTIVATED status
        $merchant = Merchant::factory()->create([
            'status' => 'ACTIVATED',
            'user_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/user/allow-switch", [
            'active_merchant' => $merchant->id
        ]);
        
        // Assert the response
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Merchant switch to live'
        ]);
    }

    public function test_allow_switch_failure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a merchant with PENDING status
        $merchant = Merchant::factory()->create([
            'status' => 'PENDING',
            'user_id' => $user->id
        ]);

        // Call api endpoint
        $response = $this->postJson("/api/v1/core/user/allow-switch", [
            'active_merchant' => $merchant->id
        ]);
        
        // Assert the response
        $response->assertStatus(405);
        $response->assertJson([
            'success' => false,
            'message' => 'Unable to complete process'
        ]);
    }
}