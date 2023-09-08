<?php
use App\Models\User;
use Tests\TestCase;
class ReconciliationControllerUnreconciledTest extends TestCase {
    public function test_success()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/unreconciled");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }

    public function test_failure_invalid_type()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/invalid");

        // Assert the response
        $response->assertStatus(422);
        $response->assertExactJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "type" => [
                    "The selected type is invalid."
                ]
            ]
        ]);
    }

    public function test_failure_no_search_value()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/unreconciled");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }

    public function test_success_search_value()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/unreconciled?search=value");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }

    public function test_success_batchsettlement()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/batchsettlement");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }

    public function test_success_pendingsettlement()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/pendingsettlement");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }

    public function test_success_unsettled()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/unsettled");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }

    public function test_success_reconciliedtransaction()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson("/transactions/reconciliedtransaction");

        // Assert the response
        $response->assertOk();
        $response->assertJsonStructure([
            "data" => [],
            "per_page",
            "total_record",
            "headers" => [],
        ]);
    }
}