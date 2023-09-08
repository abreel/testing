<?php
use App\Models\User;
use Tests\TestCase;

class WalletControllerCustomerTest extends TestCase
{
    /**
     * Test the customers endpoint with correct data
     */
    public function testCustomersSuccess()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint with correct data
        $response = $this->getJson("/banking/single/customer");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['success' => true, "data" => $wallets]);
    }

    /**
     * Test the customers endpoint with invalid data
     */
    public function testCustomersFailure()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint with invalid data
        $response = $this->getJson("/banking/single/customer");

        // Assert the response
        $response->assertStatus(400);
        $response->assertJsonStructure(['success' => false]);
    }
}
