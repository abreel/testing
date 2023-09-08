<?php
use App\Models\User;
use Tests\TestCase;

class ProviderControllerTransactionstatusTest extends TestCase
{
    public function test_success_transaction_status()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/transaction/status", [
            'transactionId' => '12345'
        ]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['transactionStatus']]);
        $this->assertEquals('12345', $response->json('data.transactionStatus'));
    }

    public function test_fail_transaction_status()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/transaction/status", [
            'transactionId' => '54321'
        ]);

        // Assert the response
        $response->assertStatus(404);
        $response->assertJsonStructure(['error']);
        $this->assertEquals('Transaction not found.', $response->json('error'));
    }

    public function test_bad_validation_transaction_status()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson("/provider/disbursement/transaction/status");

        // Assert the response
        $response->assertStatus(422);
        $response->assertJsonStructure(['error']);
        $this->assertEquals('The transaction id field is required.', $response->json('error'));
    }
}
