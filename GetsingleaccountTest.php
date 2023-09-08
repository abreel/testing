<?php
use App\Models\Account;
use Tests\TestCase;

class AccountControllerGetsingleaccountTest extends TestCase
{
    /**
     * Test successful account retrieval.
     *
     * @return void
     */
    public function test_successful_account_retrieval()
    {
        // Create an account and authenticate
        $account = Account::factory()->create();
        $this->actingAs($account);

        // Call api endpoint
        $response = $this->getJson("/core/accounts/single-account/{$account->id}");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(["success", "data"]);
    }

    /**
     * Test unsuccessful account retrieval.
     *
     * @return void
     */
    public function test_unsuccessful_account_retrieval()
    {
        // Create an account and authenticate
        $account = Account::factory()->create();
        $this->actingAs($account);

        // Call api endpoint
        $response = $this->getJson("/core/accounts/single-account/12345");

        // Assert the response
        $response->assertStatus(200);
        $response->assertJson(["success" => true, "message" => "Account not found"]);
    }
}
