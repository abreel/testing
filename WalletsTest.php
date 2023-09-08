<?php
use App\Models\User;
use Tests\TestCase;

class WalletControllerWalletsTest extends TestCase
{
    /**
     * @test
     */
    public function test_get_wallets_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/wallets");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'name'
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function test_get_wallets_with_incorrect_route_parameter()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/wallets/{$user->id}");

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['message']);
    }

    /**
     * @test
     */
    public function test_post_wallet_without_authentication()
    {
        // Call api endpoint
        $response = $this->postJson("/wallets");

        // Assert the response
        $response->assertStatus(401);
        $response->assertJsonStructure(['message']);
    }

    /**
     * @test
     */
    public function test_post_wallet_with_invalid_data()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/wallets");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors']);
    }
}
