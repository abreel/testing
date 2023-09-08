<?php
use App\Models\User;
use Tests\TestCase;

class ReconciliationControllerTransactionsTest extends TestCase
{
    /** @test */
    public function transactions_returns_all_transactions_and_total_record_and_per_page()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->getJson('/reconciliation/transactions');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
            'per_page',
            'total_record',
        ]);
    }

    /** @test */
    public function transactions_returns_all_transactions_with_limit_and_total_record_and_per_page()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Call api endpoint
        $response = $this->postJson('/reconciliation/transactions', ['limit' => 20]);

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
            'per_page',
            'total_record',
        ])
            ->assertJson([
                'per_page' => 20,
            ]);
    }
}
