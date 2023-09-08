<?php
use Tests\TestCase;

class WalletControllerPersonalsTest extends TestCase
{
    /**
     * Test Successful Personal Retrieval
     *
     * @return void
     */
    public function testSuccessfulPersonalsRetrieval()
    {
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/banking/personals");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure(['data' => []]);
    }

    /**
     * Test Unauthenticated Personal Retrieval
     *
     * @return void
     */
    public function testUnauthenticatedPersonalsRetrieval()
    {
        // Call api endpoint
        $response = $this->getJson("/banking/personals");

        $response->assertStatus(401);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Test Invalid Wallet ID when Retrieving Personals
     *
     * @return void
     */
    public function testInvalidWalletIdRetrievePersonals()
    {
        $this->actingAs($user);

        // Call api endpoint
        $wallet_id = 999;
        $response = $this->getJson("/banking/personals/{$wallet_id}");

        $response->assertStatus(404);
        $response->assertJson(['success' => false]);
        $response->assertJson(['message' => 'Wallet not found.']);
    }
}
