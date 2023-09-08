<?php
use App\Models\User;
use Tests\TestCase;
class WalletControllerAccountwalletchartTest extends TestCase{
    public function test_success_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/account-wallet-chart");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'balance',
                'total_credits',
                'total_debits'
            ],
            'chart_data' => [
                'dates' => [],
                'amount' => []
            ]
        ]);
    }

    public function test_failure_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint with wrong data
        $response = $this->getJson("/banking/account-wallet-chart?range=invalid_range");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }

    public function test_bad_validation_response()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/banking/account-wallet-chart", [
            'range' => ''
        ]);

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure([
            'success',
            'message'
        ]);
    }
}